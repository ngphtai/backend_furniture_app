<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Customer;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Products;
use App\Models\Orders;
use Illuminate\Support\Carbon;
use Stripe\Checkout\Session;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function checkout(Request $request){
        try{

        Stripe::setApiKey("sk_test_51P2UjyAPHtNagExbA9nGuoC0h27gTg6QrvxZMATX4sokQKSFm5LsI0NOyTV88MuzMTS5VYplHw2WrAaDx5hY6D8j0023bMUQ1r");

        $products = [
            ['product_id' => 82, 'quantity' => 2],
            ['product_id' => 83, 'quantity' => 2],
          ];
        $total_price = 0;
        //with array product
        foreach($products as $item){ // test
            $product_id = $item['product_id'];
            $product = Products::where('id',"=", $product_id)->first();

            if(empty($product)){
                return response()->json(['message' => 'Product not found'], 404);
            }
            if( $item['quantity'] > $product->quantity){
                return response()->json(['message' => 'Product not enough quantity'], 404);
            }
            $total_price += $product->price * $item['quantity'];
        }

        // kiểm tra 1 product
        // $product_id = $request->product_id;
        // $product = Products::where('id',"=", $product_id)->first();
        // if(empty($product)){
        //     return response()->json(['message' => 'Product not found'], 404);
        // }
        $oderMap =[];
        $oderMap['products'] = json_encode($products); //test
        $oderMap['status'] = 1;

        $orderRes = Orders::where($oderMap)->first();

        if(!empty($orderRes)){
           return response()->json(['message' => 'Order is available'], 404);
        }

        $yourdomain = env('DB_HOST:8000');
        // tạo order mới
        $map = [] ;
        $map['user_id'] = $request->user_id;
        $map['total_price'] = $total_price;
        $map['products'] = json_encode($products); // test
        $map['address'] = $request->address;
        $map['phone'] = $request->phone;
        $map['name'] = $request->name;
        $map['type_payment'] = "stripe";
        $map['status'] = 0;
        $map['note'] = $request->note?? null;
        $map['is_done'] = 0;
        $map['created_at'] = Carbon::now();

        $oderNum = Orders::insertGetId($map);// tạo order mới và lấy id của order mới tạo ra

        $CheckOutSession = Session::create([
            'payment_method_types' => ['card'],
             // tạo ra mảng line_items từ danh sách sản phẩm trong order
            'line_items' => $this->generateLineItems(json_encode($products)),//test
        //     'line_items' => [[
        //     'price_data' => [
        //         'currency' => 'vnd',
        //         'product_data' => ['name' => $product->product_name ,'description' =>  $product->description],
        //         'unit_amount' => intval($product->price * 1000), // chỉ nhận giá trị nguyên
        //     ],
        //     'quantity' => 1,
        // ],],
            'payment_intent_data' => [
            'metadata' => [ // dữ liệu sẽ được lưu trữ trong payment_intent của stripe
                'order_id' => $oderNum,
                'user_id' => $request->user_id,
            ]
            ],
            'metadata' => [ // dữ liệu sẽ được lưu trữ trong payment_intent của stripe
            'order_id' => $oderNum,
            'user_id' => $request->user_id,
            ],
            'mode' => 'payment',
            'success_url' => 'http://localhost:4242/success.html',
            'cancel_url' =>  'http://localhost:4242/cancel.html',


        ]);
            return response()->json([
                'code'=> 200,
                'message' => 'success',
                'data' => $CheckOutSession-> url,
            ]);


        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function success(){
        return response()->json(['message' => 'success'],200);
    }
    public function cancel(){
        return response()->json(['message' => 'cancel'],200);
    }

    public function webGoHook(){
        Log::info('starts here.....');
        Stripe::setApiKey('sk_test_51P2UjyAPHtNagExbA9nGuoC0h27gTg6QrvxZMATX4sokQKSFm5LsI0NOyTV88MuzMTS5VYplHw2WrAaDx5hY6D8j0023bMUQ1r');
        $endPointSecret = 'whsec_wVOVMhS6FMIH9PeNBbpFkpZDpTR4WVAZ';
        $payload = @file_get_contents('php://input');// lấy dữ liệu từ stripe webhook gửi về server qua phương thức post và lưu vào biến payload dưới dạng json string
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        Log::info('set up buffer and handshake done.....');
        try{
            $event =  \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endPointSecret
            );

        }catch(\UnexpectedValueException $e){
            Log::info('UnexpectedValueException '.$e);
            http_response_code(400);
            exit();
        }catch(\Stripe\Exception\SignatureVerificationException $e){
            Log::info('SignatureVerificationException '.$e);
            http_response_code(400);
            exit();
        }
        // Log::inf("cross the try catch block");
        if($event->type=="charge.succeeded"){
            $session = $event->data->object;
            $metadata = $session["metadata"];
            $order_id = $metadata->order_id;
            $user_id = $metadata->user_id;
            Log::info('order id is '.$order_id .' user id is '.$user_id);
            //find
            $map=[];
            $map['id'] = $order_id;
            $map['user_id'] = $user_id;
            $order = Orders::where($map)->first();
            //update
            $order->status = 1;
            $order->updated_at = Carbon::now();
            $order->products = json_decode($order->products);

            foreach($order->products as $product){

                $product_id = $product['product_id'];
                $quantity = $product['quantity'];

                $product = Products::where('id', $product_id)->first();

                $product->quantity -= $quantity;
                $product->sold += $quantity;
                $product->save();
            }
            $order ->products = json_encode($order->products);
            $order->save();
            $this -> afterCheckout($order);

            // $map = [];
            // $map['status'] = 1;
            // $map['updated_at'] = Carbon::now();
            // $whereMap = [];
            // $whereMap['id'] = $order_id;
            // $whereMap['user_id'] = $user_id;
            // $order = Orders::where($whereMap)->update($map);
            if(empty($order)){
                Log::info('update order failed cmn :)) ');
            }
            Log::info('update order success');

            Log::info('end here.....');
        }
       if($event->type=="charge.expired" || $event->type=="charge.failed"){
            $session = $event->data->object;
            $metadata = $session["metadata"];
            $order_id = $metadata->order_id;
            $user_id = $metadata->user_id;
            Log::info('order id is '.$order_id .' user id is '.$user_id);
            //find
            $map=[];
            $map['id'] = $order_id;
            $map['user_id'] = $user_id;
            $order = Orders::where($map)->first();
            //delete order
            $order->delete();
            Log::info('end here.....');
        }

        http_response_code(200);
    }
    //example array products
    // $orderDetails = [
    //     ['product_id' => 1, 'quantity' => 2],
    //     ['product_id' => 3, 'quantity' => 1],
    //   ];
    private function generateLineItems($products) {
        $lineItems = [];
        $products = json_decode($products, true);
        foreach ($products as $detail) {
          $product = Products::find($detail['product_id']);
          $product_image = json_decode($product->image)[0];
          $lineItems[] = [
            'price_data' => [
              'currency' => 'vnd',
              'product_data' => [
                'name' => $product->product_name,
                'image' =>$product_image,
                'description' => $product->description,
              ],
              'unit_amount' => intval($product->price * 1000), // Chuyển đổi sang integer in cents
            ],
            'quantity' => $detail['quantity'],
          ];
        }

        return $lineItems;
      }

    private function afterCheckout(Request $request){

        $request->validate([
            'uid' => 'required',
            // 'products' => 'required| json',
        ]);

        // $products = json_decode($request->products);
        $products = [
            // ['product_id' => 82, 'quantity' => 2],
            ['product_id' => 82, 'quantity' => 1],
          ];
        $cart = DB::table('carts')->where('uid', $request->uid)->first();

        if(!$cart){
            return response()->json(["Messenger" => "Chưa có sản phẩm"], 200);
        }
        $prod = json_decode($cart->products);
        // kiểm tra từng sản phẩm đã hoàn thành thanh toán
        foreach($products as $key => $productdone){
            //kiểm tra từng sản phẩm trong giỏ hàng
            foreach ($prod->items as $key => $item) {
                //nếu có sản phẩm đã hoàn thành thanh toán trong giỏ hàng
                if ($item->id == $productdone['product_id']) {
                    //cập nhật lại tổng số lượng sản phẩm trong giỏ hàng
                    $prod->totalItems -= $item->quantity;
                    //cập nhật lại tổng tiền
                    $prod->total -= $item->price * $item->quantity;
                    // xoá sản phẩm trong cart
                    array_splice($prod->items, $key, 1);
                    $cart->products = json_encode($prod);
                    $cart->save();
                    return response()->json([
                        'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng thành công',
                        'cart' => $cart
                    ], 200);
                }
            }
        }


    }
}
