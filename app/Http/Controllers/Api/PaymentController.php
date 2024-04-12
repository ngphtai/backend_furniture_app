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

class PaymentController extends Controller
{
    public function checkout(Request $request){
        try{

        Stripe::setApiKey("sk_test_51P2UjyAPHtNagExbA9nGuoC0h27gTg6QrvxZMATX4sokQKSFm5LsI0NOyTV88MuzMTS5VYplHw2WrAaDx5hY6D8j0023bMUQ1r");

        // $products = [
        //     ['product_id' => 82, 'quantity' => 2],
        //     ['product_id' => 83, 'quantity' => 1],
        //   ];

        //with array product
        foreach($request->products as $product){
            $product_id = $product['product_id'];
            $product = Products::where('id',"=", $product_id)->first();
            if(empty($product)){
                return response()->json(['message' => 'Product not found'], 404);
            }
        }


        // $product_id = $request->product_id;
        // $product = Products::where('id',"=", $product_id)->first();
        // if(empty($product)){
        //     return response()->json(['message' => 'Product not found'], 404);
        // }
        $oderMap =[];
        $oderMap['product_id'] = json_encode($request->products);
        $oderMap['status'] = 1;

        $orderRes = Orders::where($oderMap)->first();

        if(!empty($orderRes)){ //
           return response()->json(['message' => 'Order is available'], 404);
        }





        $yourdomain = env('DB_HOST:8000');
        $map = [] ;
        $map['user_id'] = $request->user_id;
        $map['product_id'] = json_encode($request->products);
        $map['quantity'] = 1;
        $map['status'] = 0;
        $map['total'] = $product->price;
        $map['created_at'] = Carbon::now();

        $oderNum = Orders::insertGetId($map);// tạo order mới và lấy id của order mới tạo ra

        $CheckOutSession = Session::create([
            'payment_method_types' => ['card'],
             // tạo ra mảng line_items từ danh sách sản phẩm trong order
            'line_items' => $this->generateLineItems(json_encode($request->products)),
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
            'cancel_url' =>  'http://localhost:4242/success.html',


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
            $map = [];
            $map['status'] = 1;
            $map['updated_at'] = Carbon::now();
            $whereMap = [];
            $whereMap['id'] = $order_id;
            $whereMap['user_id'] = $user_id;
            $order = Orders::where($whereMap)->update($map);
            if(empty($order)){
                Log::info('update order failed cmn :)) ');
            }
            Log::info('update order success');

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
          $lineItems[] = [
            'price_data' => [
              'currency' => 'vnd',
              'product_data' => [
                'name' => $product->product_name,
                'description' => $product->description,
              ],
              'unit_amount' => intval($product->price * 1000), // Chuyển đổi sang integer in cents
            ],
            'quantity' => $detail['quantity'],
          ];
        }

        return $lineItems;
      }


}