<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index(){
        return view('page.index');
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
        }else{
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
