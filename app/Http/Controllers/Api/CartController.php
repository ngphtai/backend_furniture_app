<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carts as cart;

// example cart
// {
//     "uid" : 3,
//     "products": {
//         "items": [
//         {
//             "id": "1",
//             "name": "Product 1",
//             "price": 10.99,
//             "quantity": 2
//         },
//         {
//             "id": "2",
//             "name": "Product 2",
//             "price": 5.49,
//             "quantity": 1
//         },
//         {
//             "id": "3",
//             "name": "Product 3",
//             "price": 7.79,
//             "quantity": 3
//         }
//         ],
//         "totalItems": 6,
//         "subtotal": 53.74,
//         "total": 59.11
//     }
// }
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try{
           $request->validate([
            'uid' => 'required',
            'products' => 'required',
        ], [
            'uid.required' => 'Vui lòng nhập uid',
            'products.required' => 'Vui lòng nhập product_id'
        ]);

        $cart = Cart::where('uid', $request->uid)->first();
        if (!$cart) {
            $cart = new Cart();
            $cart->uid = $request->uid;
            $cart->products = json_encode([]);
        }
        $cart->products = json_encode($request->products);
        $cart->uid = $request->uid;
        $cart-> save();
        return response()->json([
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công',
            'cart' => $cart
        ], 200);
        }catch  (\Exception $e){
            return response()->json(["Messenger" => $e->getMessage()]);
        }
    }

    public function get(Request $request){
        $cart = Cart::where('uid', $request -> uid)->first();
        $cart->products = json_decode($cart->products);

        return response()-> json(["Messenger" =>"success","Cart"=> $cart] , 200);
    }

}
