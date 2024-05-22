<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carts as cart;
use App\Models\Products ;
use Illuminate\Support\Facades\DB;
use  App\Models\Promotions;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'uid' => 'required',
            'products_id' => 'required',
            'quantity' => 'required',
        ]);

        $cart = Cart::where('uid', $request->uid)->first();
        if (!$cart) {
            $cart = new Cart();
            $cart->uid = $request->uid;
            $cart->products = json_encode(["items" => [], "totalItems" => 0, "total" => 0.0]);
        }
        if($cart->products == null){
            $cart->products = json_encode(["items" => [], "totalItems" => 0, "total" => 0.0]);
        }

        $prod = json_decode($cart->products);
        $product = DB::table('products')->where('id', $request->products_id)->first();
        $product_image = json_decode($product->product_image);
        $product_image = json_decode($product_image);
        $product_image =$product_image[0]; //ảnh
        $name = $product->product_name; // tên
        $price = $product->price;// giá
        // return response()->json($product_image);
        $promotion = Promotions::where("id",$product->promotion_id)->first();
        if(empty($promotion)){
            $promotion = 0.0;
        }
        else{
            if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                $promotion = ($promotion->discount);
            }
            else {
                $promotion = 0.0;
            }
        }
        $dicountPrice = ($price - $price*$promotion/100);

        if ($prod) {
            foreach ($prod->items as $key => $item) { // kiểm tra sản phẩm đã có trong giỏ hàng chưa
                if ($item->id == $request->products_id) {
                    $prod->items[$key]->quantity +=(int) $request->quantity +0;
                    $prod->totalItems +=(int) $request->quantity;
                    $prod->total += $dicountPrice * $request->quantity;
                    $cart->products = json_encode($prod);


                    //check quantity in product
                    $product = DB::table('products')->where('id', $request->products_id)->first();
                    if($product -> quantity < $prod->items[$key]->quantity){
                        return response()->json([
                            'message' => 'Added maximum quantity of product', //oke r á
                        ], 200);
                    }else {
                        $cart->save();
                    }

                    return response()->json([
                        'message' => 'The product has been added to the cart successfully',
                        'Cart' => $cart
                    ], 200);
                }
            }
        }
        // If the product does not exist in the cart, add it as a new item
        $prod->items[] = [
            'id' => $request->products_id,
            'name' => $name,
            'price' => $price,
            'image' => $product_image,
            'quantity' => (int)$request->quantity +0,
            'dicountPrice' => $dicountPrice,
        ];

        $prod->totalItems +=(int) $request->quantity;
        $prod->total += $dicountPrice * $request->quantity;
        $cart->products = json_encode($prod);
        $product = DB::table('products')->where('id', $request->products_id)->first();

        if($product -> quantity < $request->quantity){
            return response()->json([
                'message' => 'Added maximum quantity of product',
            ], 200);
        }else {
            $cart->save();
        }
        return response()->json([
            'message' => 'The product has been added to the cart successfully',
            'Cart' => $cart
        ], 200);

        //lấy thông tin sản phẩm

        $prod->items[] = [
            'id' => $request->products_id,
            'name' => $name,
            'price' => $price,
            'image' => $product_image,
            'quantity' => (int)$request->quantity,
            'dicountPrice' => $dicountPrice,
        ];

        $prod->totalItems +=(int) $request->quantity;
        $prod->total += $dicountPrice* $request->quantity;
        $cart->products = json_encode($prod);

        $cart->save();
        return response()->json([
            'message' => 'The product has been added to the cart successfully',
        ], 200);

    }

    public function get(Request $request){
        $cart = Cart::where('uid', $request -> uid)->first();
        if(!$cart){
            return response()->json(["message" => "Chưa có sản phẩm"], 200);
        }
        $prod = json_decode($cart->products);
        foreach ($prod->items as $key => $item) {
            $product = DB::table('products')->where('id', $item->id)->first();
            $promotion = Promotions::where("id",$product->promotion_id)->first();
            if(empty($promotion)){
                $promotion = 0.0;
            }
            else{
                if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                    $promotion = $promotion->discount;
                }
                else {
                    $promotion = 0.0;
                }
            }
            // nếu hết sản phẩm
            if($product->quantity == 0){
                //set số lượng sản phẩm về 0
                $prod->items[$key]->quantity = 0;
                $prod->totalItems -= $item->quantity;
                $prod->total -= $item->dicountPrice * $item->quantity;
            }
            $tempPrice = $item->price;
            $item->dicountPrice = $tempPrice - $tempPrice * $promotion / 100;
            $prod->total += $item->dicountPrice *$item->quantity ;
        }
        $cart->products = json_encode( $prod);
        $cart->save();

        $cart->products = json_decode($cart->products);
        return response()-> json(["Messenger" =>"success","Cart"=> $cart] , 200);
    }

    //delete
    public function delete(Request $request){

        $request->validate([
            'uid' => 'required',
            'product_id' => 'required',
        ]);

        $cart = Cart::where('uid', $request->uid)->first();

        $prod = json_decode($cart->products);
        foreach ($prod->items as $key => $item) {
            if ($item->id == $request->product_id) {
                $product = DB::table('products')->where('id', $request->product_id)->first();
                $promotion = Promotions::where("id",$product->promotion_id)->first();
                if(empty($promotion)){
                    $promotion = 0.0;
                }
                else{
                    if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                        $promotion = $promotion->discount;
                    }
                    else {
                        $promotion = 0.0;
                    }
                }
                $prod->totalItems -=(int) $item->quantity;
                $prod->total -= ($item->price - $item->price*$promotion/100) * $item->quantity;
                // xoá giá trị trong mảng
                array_splice($prod->items, $key, 1); //unset là xoá giá trị trong mảng nhưng vẫn giữ index còn array_splice là xoá giá trị và index
                $cart->products = json_encode($prod);
                $cart->save();
                return response()->json([
                    'message' => 'The product has been deleted successfully',
                    'cart' => $cart
                ], 200);
            }
        }
        return response()->json([
            'message' => 'The product does not exist in the cart',
        ], 200);

    }

    public function update(Request $request){

            $request->validate([
                'uid' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
            ]);

            $cart = Cart::where('uid', $request->uid)->first();

            $prod = json_decode($cart->products);
            foreach ($prod->items as $key => $item) {
                if ($item->id == $request->product_id) {
                    $product = DB::table('products')->where('id', $request->product_id)->first();
                    if($product -> quantity < $request->quantity){
                        return response()->json([
                            'message' => 'Added maximum quantity of product',
                        ], 200);
                    }
                    $promotion = Promotions::where("id",$product->promotion_id)->first();
                    if(empty($promotion)){
                        $promotion = 0;
                    }
                    else{
                        if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                            $promotion = $promotion->discount;
                        }
                        else {
                            $promotion = 0;
                        }
                    }
                    $discountPrice = $item->price - $item->price*$promotion/100; // giá sau khi giảm giá

                    $change = $request->quantity - $item->quantity;// số lượng thay đổi

                    $prod->totalItems += $change;
                    $prod->items[$key]->quantity = (int)$request->quantity/1;
                    if($prod->items[$key]->quantity == 0){
                        array_splice($prod->items, $key, 1);
                    }
                    $prod->total += $discountPrice  * $change;


                    $cart->products = json_encode($prod);
                    $cart->save();
                    return response()->json([
                        'message' => 'Sản phẩm đã được cập nhật thành công',
                    ], 200);
                }
            }
            return response()->json([
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng',
            ], 200);

    }



}
