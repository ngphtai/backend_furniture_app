<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carts as cart;


class CartController extends Controller
{
    public function create(Request $request){
        try{
            $request->validate([
                'uid' => 'required',
                'products' => 'required'
            ]);
            $cart = new cart();
            $cart->uid = $request->uid;
            $cart->products =json_encode($request->products);
            $cart->save();
            return response()->json(["Messenger" => "success","cart"=> $cart], 200);
        }catch(\Exception $e){
            return response()->json(["Messenger" => $e->getMessage()]);
        }
    }

    public function get(Request $request){
        $cart = Cart::where('uid', $request -> uid)->first();
        $cart->products = json_decode($cart->products);

        return response()-> json(["Messenger" =>"success","Cart"=> $cart] , 200);
    }
    public function edit(Request $request){
        try{
            $request->validate([
                'uid' => 'required',
                'products' => 'required'
            ]);
            $cart = Cart::where('uid', $request->uid)->first();
            $cart->products = json_encode($request->products);
            $cart->save();
            return response()->json(["Messenger" => "success","cart"=> $cart], 200);
        }catch(\Exception $e){
            return response()->json(["Messenger" => $e->getMessage()]);
        }
    }
}
