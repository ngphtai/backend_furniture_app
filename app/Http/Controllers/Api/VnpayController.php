<?php

namespace App\Http\Controllers\api;

use App\Events\UpdateNotification;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Refund_requests;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\Products;
use App\Models\Promotions;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
class VnpayController extends Controller
{
    public function pay(Request $request)
    {

        $products = json_decode($request->products);
        $Total_price = $request->total_price;
        //with array product
        foreach($products as $item){ // test
            $product_id = $item->product_id;
            $product = Products::where('id',"=", $product_id)->first();
            if(empty($product)){
                return response()->json(['message' => 'Product not found'], 404);
            }
            if( $item->quantity > $product->quantity){
                return response()->json(['message' => 'Product not enough quantity'], 404);
            }

        }

        // $oderMap =[];
        // $oderMap['products'] = json_encode($products ); //test
        // $orderMap['user_id'] = $request->uid;

        // $oderMap['status'] = 1;

        // $orderRes = Orders::where($oderMap)->first();

        // if(!empty($orderRes)){
        //    return response()->json(['message' => 'Order is available!!'], 404);
        // }

            $map = [] ;
            $map['user_id'] = $request->uid;
            $map['total_price'] = $Total_price;
            $map['products'] = json_encode($products);//test
            $map['address'] = $request->address;
            $map['phone'] = $request->phone;
            $map['name'] = $request->name;
            $map['type_payment'] = "vnpay";
            $map['status'] = 0;
            $map['note'] = $request->note??'';
            $map['is_done'] = 0;
            $map['created_at'] = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

            $order_id = Orders::insertGetId($map);

        //trừ số lượng sp mới mua trong kho
        $order = Orders::where('id', $order_id)->first();
        $order->products = json_decode($order->products, true);

        foreach($order->products as $product){
            $product_id = (int) $product['product_id'];
            $quantity = $product['quantity'];

            $product = Products::where('id', $product_id)->first();

            $product->quantity -= $quantity;
            $product->sold += $quantity;
            $product->save();
        }


        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = "S4SMEJK5"; //Website ID in VNPAY System
        $vnp_HashSecret = "EAORGNSLPZWOCEUQVZWUFEYIMQTOFTNR"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $vnp_Returnurl = env('APP_URL') . '/api/vnpay-return';  // URL nhan ket qua tra ve
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đơn hàng ';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $Total_price * 2500000;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        //Billing
        $vnp_Bill_Mobile = '0949522102';
        $vnp_Bill_Email = "ngphtai.it@gmail.com";
        $fullName = trim("NGUYEN PHUOC TAI");
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address = "124 Lê Dương Thanh, Quận Hai Bà Trưng, Hà Nội";
        $vnp_Bill_City = "Hà Nội";
        $vnp_Bill_Country = 'VN';
        $vnp_Bill_State = '';
        // Invoice
        $vnp_Inv_Phone = "02437764668"; //input
        $vnp_Inv_Email = "pholv@vnpay.vn";
        $vnp_Inv_Customer = "Lê Văn Phổ";
        $vnp_Inv_Address = "22 Láng Hạ, Phường Láng Hạ, Quận Đống Đa, TP Hà Nội";
        $vnp_Inv_Company = "Công ty Cổ phần giải pháp Thanh toán Việt Nam";
        $vnp_Inv_Taxcode = "0102182292";
        $vnp_Inv_Type = "I";

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address" => $vnp_Bill_Address,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,
            "vnp_Inv_Phone" => $vnp_Inv_Phone,
            "vnp_Inv_Email" => $vnp_Inv_Email,
            "vnp_Inv_Customer" => $vnp_Inv_Customer,
            "vnp_Inv_Address" => $vnp_Inv_Address,
            "vnp_Inv_Company" => $vnp_Inv_Company,
            "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            }
        return response()->json($returnData);
    }

    public function vnpayReturn(Request $request)
    {

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $successUrl = env('APP_URL') . '/api/success/' . $vnp_TxnRef;
        $cancelUrl = env('APP_URL') . '/api/cancel/'. $vnp_TxnRef .'/1';
        if ($vnp_ResponseCode == '00') {
            $order = Orders::where('id', $vnp_TxnRef)->first();
            $order->status = 1;
            $order->updated_at = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

            $order->products = json_decode($order->products, true);
            //kiểm tra hệ phân tán
            foreach($order->products as $product){
                $product_id = (int) $product['product_id'];
                $quantity = $product['quantity'];

                $product = Products::where('id', $product_id)->first();

                $product->check_quantity -= $quantity;
                if($product->check_quantity < 0){
                    $cancelUrl = env('APP_URL') . '/api/cancel/'. 0 .'/2' ;// thông báo hết hàng
                    $product->check_quantity = 0;
                    $product->quantity =0;
                    $product->sold -= $quantity;
                    $order ->is_done = 4;
                    $order->save();
                    $product->save();

                    //TODO request refund for user
                    $refund = new Refund_requests();
                    $refund->order_id = $order->id;
                    $refund->reason = "OUT OF STOCK !!!";
                    $refund->status = 0;
                    $refund->save();

                    //TODO notification stock out
                    $notifi = new Notifications();
                    $notifi->user_id = $order->user_id;
                    $notifi->title = 'Order Failed';
                    $notifi->content = 'Sorry, your order #'.$order->id.' has been failed because the product is out of stock. The amount paid will be refunded to you shortly. Please check your order and try again';
                    $notifi->is_read =0;
                    $notifi->type= 1;
                    $notifi->save();
                    Broadcast(new UpdateNotification($notifi))->toOthers();

                    return Redirect::to($cancelUrl); // thông báo hết hàng
                }
                $product->save();
            }
            $order->save();
            $this ->afterCheckout($vnp_TxnRef, $order->user_id);

            //TODO notification success
            $notifi = new Notifications();
            $notifi->user_id = $order->user_id;
            $notifi->title = "Order successfully paid";
            $notifi->content = "Your order #".$vnp_TxnRef ." has been successfully paid. Check your order status in Orders Management";
            $notifi->is_read =0;
            $notifi->type= 1;
            $notifi->save();
            Broadcast(new UpdateNotification($notifi))->toOthers();
            return Redirect::to($successUrl);
        } else {
            $order = Orders::find($vnp_TxnRef);
            //xoá order
            $order->products = json_decode($order->products, true);
            foreach($order->products as $product){
                $product_id = (int) $product['product_id'];
                $quantity = $product['quantity'];
                $product = Products::where('id', $product_id)->first();
                $product->quantity += $quantity;
                $product -> sold -= $quantity;
                $product->save();
            }
            $order->delete();

            return Redirect::to($cancelUrl );
        }

        return Redirect::to($successUrl);
    }
    private function afterCheckout( $order_id , $user_id){
        $order = Orders::where('id', $order_id)->first();
        $products = json_decode($order->products, true);

        $cart = DB::table('carts')->where('uid', $user_id)->first();

        $prod = json_decode($cart->products);
        $prodOnCart = json_decode($prod,true);

        // kiểm tra từng sản phẩm đã hoàn thành thanh toán
        foreach($products as $key => $productdone){
            //kiểm tra từng sản phẩm trong giỏ hàng
            $product_id = $productdone['product_id'];
                foreach ($prodOnCart['items'] as $key => $item) {
                    //nếu có sản phẩm đã hoàn thành thanh toán trong giỏ hàng
                    if ($item['id'] == $product_id) {
                        $product = DB::table('products')->where('id', $product_id)->first();
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

                        //cập nhật lại tổng số lượng sản phẩm trong giỏ hàng
                        $prodOnCart['totalItems'] -= $item['quantity'];
                        //cập nhật lại tổng tiền
                        $prodOnCart['total'] -= $promotion * $item['quantity'];
                        // xoá sản phẩm trong cart
                        array_splice($prodOnCart['items'], $key, 1);
                        $cart->products = json_encode($prodOnCart);
                        $cart = DB::table('carts')->where('uid', $user_id)->update([
                            'products' => json_encode($cart->products),
                        ]);
                    }
                }
        }
        // $cart -> products = json_decode(json_decode($cart->products));
        // return $cart;
    }


    // test for total price order
    public function totalPrice(){
        $orders = Orders::all();
        $total_price = 0;
        foreach($orders as $item){
            $total_price = 0;
            $products = json_decode($item->products);
            foreach($products as $product){
                $product_id = $product->product_id;
                $quantity = $product->quantity;
                $product = Products::where('id', $product_id)->first();
                $total_price += $product->price * $quantity;
            }
            $item->total_price = $total_price;
        }
        return $total_price;
    }
}
