<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
class OrdersController extends Controller
{
    public function index()
    {
        $result['info'] = DB::table('orders')->orderBy('created_at')->get()->toArray();

            //example of how to use it , get email from user_id


        return view('page.orders', $result);
    }

    public function show(Request $request)
    {
        $order = DB::table('orders')->where('id', $request->id)->first();
        $order-> email = DB::table('users')->where('id', $order->user_id)->first()->email;
        return response()-> json($order);
    }

    public function all(Request $request){
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $order-> email = DB::table('users')->where('id', $order->user_id)->first()->email;
        }
        return response()->json($orders);
    }
    public function updatedone(Request $request)
    {
        $order = Orders::where('id', $request->id)->first();
        $order -> is_done ++;
        $order->save();

        toastr()-> success('Cập nhật thành công tình trạng sản phẩm');
        return response()->json(['message' => 'Update success'], 200);
    }

}
