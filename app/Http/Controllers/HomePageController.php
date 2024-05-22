<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Promotions;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index(){
        $count_order = Orders::count();
        $count_sold = DB::table('products')->sum('sold');
        $count_user = Users::count();
        $products = Products::orderBy('sold', 'desc')->take(10)->get();

        $revenue = 0;

        foreach($products as $product){
            $discount = Promotions::where('id', $product->promotion_id)->first();
            $discount = $discount ? $discount->discount : 0;
            if($discount != 0){
                $revenue += $product->price * $product->sold * (1 - $discount/100);
            } else {
                $revenue += $product->price * $product->sold;
            }
        }
        $order = Orders::all();
        $analysis = [];
        //lấy số lượng order trong ngày hiện tại và 6 ngày trước
        $analysis[0] = Orders::where('created_at', '>=', date('Y-m-d'))->where('created_at', '<', date('Y-m-d', strtotime('+1 day')))->count();
        $analysis[1] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-1 day')))->where('created_at', '<', date('Y-m-d'))->count();
        $analysis[2] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-2 day')))->where('created_at', '<', date('Y-m-d', strtotime('-1 day')))->count();
        $analysis[3] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-3 day')))->where('created_at', '<', date('Y-m-d', strtotime('-2 day')))->count();
        $analysis[4] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-4 day')))->where('created_at', '<', date('Y-m-d', strtotime('-3 day')))->count();
        $analysis[5] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-5 day')))->where('created_at', '<', date('Y-m-d', strtotime('-4 day')))->count();
        $analysis[6] = Orders::where('created_at', '>=', date('Y-m-d', strtotime('-6 day')))->where('created_at', '<', date('Y-m-d', strtotime('-5 day')))->count();




        $month = [];
        $month[0] = Orders::where('created_at', '>=', date('Y-1-1'))->where('created_at', '<', date('Y-1-31'))->count();
        $month[1] = Orders::where('created_at', '>=', date('Y-2-1'))->where('created_at', '<', date('Y-2-28'))->count();
        $month[2] = Orders::where('created_at', '>=', date('Y-3-1'))->where('created_at', '<', date('Y-3-31'))->count();
        $month[3] = Orders::where('created_at', '>=', date('Y-4-1'))->where('created_at', '<', date('Y-4-30'))->count();
        $month[4] = Orders::where('created_at', '>=', date('Y-5-1'))->where('created_at', '<', date('Y-5-31'))->count();
        $month[5] = Orders::where('created_at', '>=', date('Y-6-1'))->where('created_at', '<', date('Y-6-30'))->count();
        $month[6] = Orders::where('created_at', '>=', date('Y-7-1'))->where('created_at', '<', date('Y-7-31'))->count();
        $month[7] = Orders::where('created_at', '>=', date('Y-8-1'))->where('created_at', '<', date('Y-8-31'))->count();
        $month[8] = Orders::where('created_at', '>=', date('Y-9-1'))->where('created_at', '<', date('Y-9-30'))->count();
        $month[9] = Orders::where('created_at', '>=', date('Y-10-1'))->where('created_at', '<', date('Y-10-31'))->count();
        $month[10] = Orders::where('created_at', '>=', date('Y-11-1'))->where('created_at', '<', date('Y-11-30'))->count();
        $month[11] = Orders::where('created_at', '>=', date('Y-12-1'))->where('created_at', '<', date('Y-12-31'))->count();


        $vnpay = Orders::where('type_payment', 'vnpay')->count();
        $direct = Orders::where('type_payment', 'direct')->count();
        $stripe = Orders::where('type_payment', 'stripe')->count();

        $chuaxacnhan = Orders::where('is_done', 0)->count();
        $danggiao = Orders::where('is_done', 1)->count();
        $daxacnhan = Orders::where('is_done', 2)->count();
        $hoanthanh = Orders::where('is_done', 3)->count();
        $hoantien = Orders::where('is_done', 4)->count();
        $tuchoi = Orders::where('is_done', -1)->count();
        return view('page.index', compact('count_order','count_sold','count_user','revenue','order','analysis','month', 'products', 'vnpay', 'direct', 'stripe', 'chuaxacnhan', 'danggiao', 'daxacnhan', 'hoanthanh', 'hoantien', 'tuchoi'));
    }
    public function Login(){
        $check = Auth::guard('ANNTStore')->check();
        if($check) {
            return redirect('/homepage');
        } else {
            return view('page.auth.login');
        }

    }
    public function actionLogin(Request $request){
        //  dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống'
        ]);


        $map = [];
        $map['email'] = $request->email;
        $user = Users::where($map)->first();
        if(!$user){
            toastr()->error("Tài khoản không tồn tại!");
            return redirect('/');
        }
        if($user->user_type =="User"){
            toastr()->error("Tài khoản không đúng loại!");
                return redirect('/');
        }
        if($user->is_lock == 1){
            toastr()->error("Tài khoản đã bị khóa!");
            return redirect('/');
        }
        else{
            $check =  Auth::guard('ANNTStore')->attempt(['email'  => $request->email, 'password' => $request->password]) ;
            if($check) {

                toastr()->success("Đã đăng nhập thành công!");
                return redirect('/homepage');
            } else {
                toastr()->error("Tài khoản hoặc mật khẩu không đúng!");
                return redirect('/');
            }
        }

    }
    public function actionLogout(){
        Auth::guard('ANNTStore')->logout();
        return redirect('/');
    }
}
