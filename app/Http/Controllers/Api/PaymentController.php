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
use App\Models\Promotions;
use Illuminate\Support\Carbon;
use Stripe\Checkout\Session;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;
use App\Http\Controllers\api\VnpayController as Vnpay;
use App\Models\Notifications;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\DB;
use App\Events\UpdateNotification;
use App\Models\Refund_requests;
use Illuminate\Support\Facades\Broadcast;

class PaymentController extends Controller
{


    public function direct(Request $request){
        $request->validate([
            'products' => 'required| json',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'note' => 'nullable',
            'uid' => 'required',
            'total_price' => 'required',
        ]);

        $products = json_decode($request->products);
        foreach($products as $prorduct ){
            $product = Products::where('id', $prorduct->product_id)->first();
            if(empty($product)){
                return response()->json(['message' => 'Product not found'], 200);
            }
            if($prorduct->quantity > $product->quantity){
                return response()->json(['message' => 'Product not enough quantity'], 200);
            }
        }
          //trừ số lượng sp mới mua trong kho

          $products = json_decode($request->products);

          foreach($products as $product){
            $product_id = $product->product_id;
              $quantity = $product->quantity;

              $product = Products::where('id', $product_id)->first();

              $product->quantity -= $quantity;
              $product->check_quantity -= $quantity;
              $product->sold += $quantity;
              $product->save();
          }


          $map = [] ;
        $map['user_id'] = $request->uid;
        $map['total_price'] = $request->total_price;
        $map['products'] = $request ->products;
        $map['address'] = $request->address;
        $map['phone'] = $request->phone;
        $map['name'] = $request->name;
        $map['type_payment'] = "direct";
        $map['status'] = 0;
        $map['note'] = $request->note?? '';
        $map['is_done'] = 0;
        $map['created_at'] = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

        $ordersNum = Orders::insertGetId($map);
        $orders = Orders::where('id', $ordersNum)->first();

        $this -> afterCheckout($ordersNum, $request->uid);

        $notifi = new Notifications();
        $notifi->user_id = $orders->user_id;
        $notifi->title = "Order successfully paid";
        $notifi->content = "Your order #".$orders->id ." has been successfully paid. Check your order status in Orders Management";
        $notifi->is_read =0;
        $notifi->type= 1;
        $notifi->save();

        $this -> PushNotifi($notifi);

        $orders->products = json_decode($orders->products);
        foreach($orders->products as $product){
            $product->product_id =(int) $product->product_id;
        }
        return response()->json([
            'code'=> 200,
            'data' => $orders,
            'message' => 'success',
        ]);

    }

    public function PushNotifi($notifi){
        Broadcast(new UpdateNotification($notifi))->toOthers();
    }


    public function checkout(Request $request){
        try{
        Stripe::setApiKey("sk_test_51P2UjyAPHtNagExbA9nGuoC0h27gTg6QrvxZMATX4sokQKSFm5LsI0NOyTV88MuzMTS5VYplHw2WrAaDx5hY6D8j0023bMUQ1r");
        $request -> validate([
            'uid' => 'required',
            'products' => 'required| json',
            'total_price' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'name' => 'required',
            'note' ,
        ]);


        $total_price = $request->total_price;
        $products = json_decode($request->products);
        $cancelUrl = env('APP_URL') . '/api/cancel/'. 0 ;
        if(is_array($products) == false){
            return response()->json([
                'code'=> 200,
                'message' => 'success',
                'data' => $cancelUrl .'/0',
            ]);
        }
        //with array product
        foreach($products as $item){
            $product_id = $item->product_id;
            $product = Products::where('id', $product_id)->first();

            if(empty($product)){
                return response()->json([
                    'code'=> 200,
                    'message' => 'product not found',
                    'data' => $cancelUrl .'/0',
                ]);
            }
            if($item->quantity > $product->quantity){
                return response()->json([
                    'code'=> 200,
                    'message' => 'product not enough quantity',
                    'data' => $cancelUrl .'/2',
                ]);
            }
        }

        // kiểm tra 1 product
        // $product_id = $request->product_id;
        // $product = Products::where('id',"=", $product_id)->first();
        // if(empty($product)){
        //     return response()->json(['message' => 'Product not found'], 404);
        // }

        //kiểm tra đơn hàng đã tồn tại chưa
        // $oderMap =[];
        // $oderMap['products'] = json_encode($products); //test
        // $oderMap['status'] = 1;

        // $orderRes = Orders::where($oderMap)->first();

        // if(!empty($orderRes)){
        //    return response()->json(['message' => 'Order is available'], 404);
        // }


        // tạo order mới
        $map = [] ;
        $map['user_id'] = $request->uid;
        $map['total_price'] = $total_price;
        $map['products'] = $request ->products;
        $map['address'] = $request->address;
        $map['phone'] = $request->phone;
        $map['name'] = $request->name;
        $map['type_payment'] = "stripe";
        $map['status'] = 0;
        $map['note'] = $request->note?? '';
        $map['is_done'] = 0;
        $map['created_at'] = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

        $oderNum = Orders::insertGetId($map);// tạo order mới và lấy id của order mới tạo ra

        //trừ số lượng sp mới mua trong kho
        $order = Orders::where('id', $oderNum)->first();
        $order->products = json_decode($order->products, true);

        foreach($order->products as $product){
            $product_id = (int) $product['product_id'];
            $quantity = $product['quantity'];

            $product = Products::where('id', $product_id)->first();

            $product->quantity -= $quantity;
            $product->sold += $quantity;
            $product->save();
        }

        $successUrl = env('APP_URL') . '/api/success/' . $oderNum;
        $cancelUrl = env('APP_URL') . '/api/cancelv2/'.  $oderNum .'/3';
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
                'user_id' => $request->uid,
            ]
            ],
            'metadata' => [ // dữ liệu sẽ được lưu trữ trong payment_intent của stripe
            'order_id' => $oderNum,
            'user_id' => $request->uid,
            ],
            'mode' => 'payment',
            'success_url' =>   $successUrl,
            'cancel_url' =>  $cancelUrl,


        ]);
            return response()->json([
                'code'=> 200,
                'message' => 'success',
                'data' => $CheckOutSession-> url,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'code'=> 200,
                'data' => $e->getMessage(),
            ]);
        }

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
            //check data
            Log::info('order id is '.$order_id .' user id is '.$user_id);
            //find
            $map=[];
            $map['id'] = $order_id;
            $map['user_id'] = $user_id;
            $order = Orders::where($map)->first();
            //update
            $order->status = 1;
            $order->updated_at = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');
            $order->save();

            //kiểm tra sản phẩm còn đủ số lượng không ( tránh nhiều người đặt cùng lúc và thiếu sản phẩm)

            $productsOnOrder = json_decode($order->products, true);

            foreach($productsOnOrder as $product){
                $product_id = (int) $product['product_id'];
                $quantity = $product['quantity'];
                Log::info('product in order id is '.$product_id .' quantity is '.$quantity);
                $product = Products::where('id', $product_id)->first();

                $product->check_quantity -= $quantity;
                if($product->check_quantity < 0){

                    $product->check_quantity = 0;
                    $product->quantity = 0;
                    $product -> sold -= $quantity;
                    $order ->is_done = 4;
                    $order->save();
                    $product->save();
                    Log::info('product id '.$product_id.' is out of stock'. 'quantity is '.$product->quantity);
                    //TODO request refund for user
                    $refund = new Refund_requests();
                    $refund->order_id = $order->id;
                    $refund->reason = "OUT OF STOCK !!!";
                    $refund->status = 0;
                    $refund->save();

                    //TODO send notification event to pusher and send notification to onesingal services
                    $notifi = new Notifications();
                    $notifi->user_id = $order->user_id;
                    $notifi->title = 'Order Failed';
                    $notifi->content = 'Sorry, your order #'.$order->id.' has been failed because the product is out of stock. The amount paid will be refunded to you shortly. Please check your order and try again';
                    $notifi->is_read = 0;
                    $notifi->type = 1;
                    $notifi->save();
                    Broadcast( new UpdateNotification($notifi))->toOthers();

                }
                $product->save();
            }

            //TODO notification success
            $notifi = new Notifications();
            $notifi->user_id = $user_id;
            $notifi->title = "Order successfully paid";
            $notifi->content = "Your order #".$order_id ." has been successfully paid. Check your order status in Orders Management";
            $notifi->is_read =0;
            $notifi->type= 1;
            $notifi->save();

            // xoá sản phẩm trong cart sau khi thực hiện thanh toán thành công
            $this-> afterCheckout($order_id, $user_id);
            
            Broadcast(new UpdateNotification($notifi))->toOthers();

            if(empty($order)){
                Log::info('update order failed cmn :)) ');
            }
            Log::info('update order success');
            Log::info('end here.....');
            http_response_code(200);
        }
        // catch session expired
        // if( $event->type ="checkout.session.expired"){
        //     Log::info('Payment failed !!!!!!!!!   start here.....');
        //     $session = $event->data->object;
        //     $metadata = $session["metadata"];
        //     $order_id = $metadata->order_id;
        //     $user_id = $metadata->user_id;
        //     Log::info('order id is '.$order_id .' user id is '.$user_id);
        //     //find
        //     $map=[];
        //     $map['id'] = $order_id;
        //     // $map['user_id'] = $user_id;
        //     $order = Orders::where($map)->first();
        //     if($order)
        //     {
        //             $order->products = json_decode($order->products, true);
        //             foreach($order->products as $product){
        //                 $product_id = (int) $product['product_id'];
        //                 $quantity = $product['quantity'];
        //                 Log::info(('Failed: Quantity product is '.$quantity));
        //                 $product = Products::where('id', $product_id)->first();
        //                 Log::info(('Failed: After Sold product is '.$product->sold));
        //                 $product->quantity += $quantity;
        //                 $product -> sold -= $quantity;
        //                 $product->save();
        //                 Log::info(('Failed: Before Sold product is '.$product->sold));
        //             }
        //             //delete order
        //             // $order->delete();
        //     }else {
        //         Log::info('Order not found');
        //     }

        //     Log::info('Payment failed !!!!!!!!!   end here.....');
        //     http_response_code(200);
        // }

        http_response_code(200);
    }


    private function generateLineItems($products) {
        $lineItems = [];
        $products = json_decode($products, true);
        foreach ($products as $detail) {
          $product = Products::find($detail['product_id']);
        // if (!is_null($product->image)) {
        //     $product_image = json_decode($product->image[0]);
        // } else {
        //     $product_image = null;
        // }

          $lineItems[] = [
            'price_data' => [
              'currency' => 'usd',
              'product_data' => [
                'name' => $product->product_name,
                'description' => $product->description,
              ],
              'unit_amount' => intval($detail["price"]*100 ), // Chuyển đổi sang integer in cents
            ],
            'quantity' => $detail['quantity'],
          ];
        }

        return $lineItems;
      }


    // xoá sản phẩm sau khi thực hiện thanh toán thành công
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
                        $prodOnCart['totalItems'] -= $item['quantity'];
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
}
