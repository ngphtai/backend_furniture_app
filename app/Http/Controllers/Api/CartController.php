<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carts as cart;


class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try{
            // Lấy dữ liệu từ request
        $userId = $request->input('user_id');
        $productData = $request->input('product');

        // Kiểm tra xem giỏ hàng của người dùng đã tồn tại chưa
        $cart = Cart::where('user_id', $userId)->first();

        // Nếu giỏ hàng không tồn tại, tạo mới
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->total_price = 0; // Khởi tạo giá trị tổng tiền
            $cart->product = []; // Khởi tạo mảng rỗng cho sản phẩm
        }

        // Thêm sản phẩm mới vào giỏ hàng
        $newProduct = [
            'product_id' => $productData['product_id'],
            'product_name' => $productData['product_name'],
            'price' => $productData['price'],
            'quantity' => $productData['quantity']
        ];
        $cart->product[] = $newProduct;

        // Cập nhật tổng giá tiền trong giỏ hàng
        $cart->total_price += $productData['price'] * $productData['quantity'];

        // Lưu giỏ hàng vào cơ sở dữ liệu
        $cart->save();

        // Trả về thông báo hoặc dữ liệu cần thiết cho phía client
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

    public function delete(Request $request)
    {
        // Lấy dữ liệu từ request
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');

        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $userId)->first();

        // Nếu không tìm thấy giỏ hàng, trả về thông báo lỗi
        if (!$cart) {
            return response()->json(['message' => 'Không tìm thấy giỏ hàng của người dùng'], 404);
        }

        // Tìm sản phẩm trong giỏ hàng
        $index = null;
        foreach ($cart->product as $key => $product) {
            if ($product['product_id'] == $productId) {
                $index = $key;
                break;
            }
        }

        // Nếu không tìm thấy sản phẩm, trả về thông báo lỗi
        if ($index === null) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm trong giỏ hàng'], 404);
        }

        // Xóa sản phẩm khỏi giỏ hàng
        unset($cart->product[$index]);

        // Cập nhật tổng giá tiền
        $cart->total_price -= $cart->product[$index]['price'] * $cart->product[$index]['quantity'];

        // Lưu thay đổi vào cơ sở dữ liệu
        $cart->save();

        // Trả về thông báo hoặc dữ liệu cần thiết cho phía client
        return response()->json(['message' => 'Sản phẩm đã được xóa khỏi giỏ hàng thành công'], 200);
    }

    public function edit(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required|integer|min:1'
            ],
            [
                'user_id.required' => 'Vui lòng nhập user_id',
                'product_id.required' => 'Vui lòng nhập product_id',
                'quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
                'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
                'quantity.min' => 'Số lượng sản phẩm phải lớn hơn hoặc bằng 1'
            ] // THÔNG BÁO LỖI
            );
        // Lấy dữ liệu từ request
        $userId = $request->user_id;
        $productId = $request->product_id;
        $newQuantity = $request->quantity;

        // Tìm giỏ hàng của người dùng
        $cart = Cart::where('user_id', $userId)->first();

        // Nếu không tìm thấy giỏ hàng, trả về thông báo lỗi
        if (!$cart) {
            return response()->json(['message' => 'Không tìm thấy giỏ hàng của người dùng'], 404);
        }

        // Tìm sản phẩm trong giỏ hàng
        $index = null;
        foreach ($cart->product as $key => $product) {
            if ($product['product_id'] == $productId) {
                $index = $key;
                break;
            }
        }

        // Nếu không tìm thấy sản phẩm, trả về thông báo lỗi
        if ($index === null) {
            return response()->json(['message' => 'Không tìm thấy sản phẩm trong giỏ hàng'], 404);
        }

        // Cập nhật số lượng sản phẩm
        $cart->product[$index]['quantity'] = $newQuantity;

        // Cập nhật tổng giá tiền
        $cart->total_price += ($newQuantity - $cart->product[$index]['quantity']) * $cart->product[$index]['price'];

        // Lưu thay đổi vào cơ sở dữ liệu
        $cart->save();

        // Trả về thông báo hoặc dữ liệu cần thiết cho phía client
        return response()->json(['message' => 'Số lượng sản phẩm đã được cập nhật thành công'], 200);
    }
}
