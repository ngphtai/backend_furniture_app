<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use App\Models\InforUsers;
use Stripe\Climate\Order;


class OrdersController extends Controller
{
    public function index()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', 0)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }
    public function index_1()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', 1)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }
    public function index_2()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', 2)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }
    public function index_3()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', 3)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }

    public function index_4()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', 4)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }

    public function index_5()
    {
        $orders = Orders::with('user')-> get();
        $orders = Orders::where('is_done', -1)->orderBy('created_at')->get();

        $info = $orders ;


        return view('page.orders', compact('info'));
    }
    public function index_6()
    {
        $orders = Orders::with('user')-> get();
        $info = $orders ;
        return view('page.orders', compact('info'));
    }


    public function show(Request $request)
    {
        $order = DB::table('orders')->where('id', $request->id)->first();
        $order-> email = DB::table('users')->where('uid', $order->user_id)->first()->email;
        if($order->email == null)
            return response()->json(['message' => 'Not found'], 404);
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
        if($order -> is_done ==3)
        {
            toastr()-> warning('Sản phẩm đã hoàn thành');
            return response()->json(['message' => 'Update success'], 200);
        }

        $order -> is_done ++;
        if( $order -> is_done == 3)
           if($order -> status == 0)
            $order -> status = 1;


        $order->save();

        toastr()-> success('Cập nhật thành công tình trạng sản phẩm');
        return response()->json(['message' => 'Update success'], 200);
    }


    public function updateretreatdone(Request $request)
    {
        $order = Orders::where('id', $request->id)->first();
        $user = auth()->guard('ANNTStore')->user();
        if($user->user_type == 'Admin'){
        // admin mới được chueyern lùi trạng thái sản phẩm
            if($order ->is_done ==-1)
            {
                toastr()-> warning('Không thể thực hiện hành động này');
                return response()->json(['message' => 'Update success'], 200);
            }
            $order -> is_done --;
            $order->save();


            toastr()-> success('Cập nhật thành công tình trạng sản phẩm');
            return response()->json(['message' => 'Update success'], 200);
        }else{
            toastr()-> warning('Tài khoản không đủ quyền để thực hiện hành động này');
            return response()->json(['message' => 'Update success'], 200);
        }
    }

    public function updateIsDone(Request $request){
        $request->validate([
            'id' => 'required',
            'is_done' => 'required'
        ]);

        $order = Orders::where('id', $request->id)->first();
        $user = auth()->guard('ANNTStore')->user();
        if ($request->is_done == 3 ) {
            $order->status = 1;
        }
        if ($order->is_done > $request->is_done) {
            if ($user->user_type != 'Admin') {
                toastr()->warning('Tài khoản không đủ quyền để thực hiện hành động này');
                return response()->json(['message' => 'Update success'], 200);
            } else {
                $order->is_done = $request->is_done;


                $order->save();
                toastr()->success('Cập nhật thành công tình trạng sản phẩm');
                return response()->json(['message' => 'Update success'], 200);
            }
        } else {
            if ($order->is_done == 3) {
                toastr()->warning('Hoá đơn đã hoàn thành');
                return response()->json(['message' => 'Update success'], 200);
            }
            $order->is_done = $request->is_done;
            $order->save();
            toastr()->success('Cập nhật thành công tình trạng sản phẩm');
            return response()->json(['message' => 'Update success'], 200);
        }
    }

    public function toPDF(String $id){
        $orders = Orders::where('id', $id)->first();
        $orders-> email = DB::table('users')->where('id', $orders->user_id)->first()->email;

        return view('page.pdf', compact('orders'));
    }

    public function search(Request $request){
        $request->validate([
            'email' => 'nullable |string',
            'type_payment' => 'nullable |string',
            'status' => 'nullable ',
            'is_done' => 'nullable ',
            'start_date' => 'nullable |date ',
            'end_date' => 'nullable | date',
        ]);

        $ordersrequest =  Orders::query();

        if( $request->email!= ''){
             $ordersrequest->where('name', 'like', '%'.$request->email.'%');
        }

        if( $request->type_payment!= ''|| $request->type_payment == "Phương thức"){
            $ordersrequest->where('type_payment', $request->type_payment);
        }

        if( $request->status!= ''){
            $ordersrequest->where('status', $request->status);
        }
        if( $request->is_done!= null){
            $ordersrequest->where('is_done', $request->is_done);
        }
        if(!empty($request->start_date)){
            $ordersrequest->where('created_at', '>=', $request->start_date);
        }
        if(!empty($request->end_date)){
            $ordersrequest->where('created_at', '<=', $request->end_date);
        }

        // function addEmail($info)
        // {
        //     foreach ($info as $order) {
        //         $order->email = DB::table('users')->where('id', $order->user_id)->first()->email;
        //     }
        //     return response()->json($info);
        // }

        $orders = $ordersrequest->get();

        // return $orders->isEmpty() ? response()->json($orders, 200) : addEmail($orders);
        return response()->json($orders);



    }


    //API
    public function allByUid(Request $request){
        $request->validate([
            'uid' => 'required'
        ]);
        $orders = Orders::where('user_id', $request->uid)->get() ;

        foreach($orders as $order){
            $products = json_decode($order->products);
            foreach($products as $item){
                $product = DB::table('products')->where('id', $item->product_id)->first();

                $product->product_image = json_decode($product->product_image);
                $product->product_image = json_decode($product->product_image);

                $item->image = $product->product_image[0];
                $item->product_id = $product->product_name;
                $order->products = $products;
            }
        }



        if($orders->isEmpty())
            return response()->json(['message' => 'Not found'], 404);

        return response()->json($orders);
    }

    public function success(String $id){
        $order = Orders::where('id', $id)->first();
        $email = DB::table('users')->where('uid', $order->user_id)->first()->email;

        return view('page.order.order_success',compact('order', 'email'));


    }
    public function cancel(String $id){
        $order = Orders::where('id', $id)->first();
        if($order!= null)
            $order->delete();
        return view('page.order.order_failed');
    }
}
