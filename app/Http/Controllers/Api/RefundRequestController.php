<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund_requests;
use App\Models\Products;
use App\Models\Orders;
use Stripe\Refund;
use App\Models\Notifications;
use App\Events\UpdateNotification;
class RefundRequestController extends Controller
{
    public function index(){
        $info = Refund_requests::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(15);

        return view('page.approve_refund',compact('info'));
    }

    public function update(Request $request){
        $refund = Refund_requests::where('id', $request->id)->first();
        if( $refund->status == 0){
            $refund->status = 1;
            $order = Orders::where('id', $refund->order_id)->first();
            $order->is_done = -1;

            if($refund -> reason != "OUT OF STOCK !!!"){
                // return json_decode($order->products);
                foreach(json_decode($order->products) as $item){
                    $product = Products::where('id', $item->product_id)->first();
                    $product->quantity += $item->quantity;
                    $product->check_quantity += $item->quantity;
                    $product -> sold -= $item->quantity;
                    $product->save();
                }
            }
            $order->save();
            $refund->save();

             // $this -> sendToOneSignal($messenger);
            $notifi = new Notifications();
            $notifi->user_id = $order->user_id;
            $notifi->title = 'Refund Request Approved';
            $notifi->content = 'Order #'.$order->id.' has been approved!.The money will be refunded to your account soon. Thank you!';
            $notifi->is_read = 0;
            $notifi->type = 1;
            $notifi->save();
            Broadcast( new UpdateNotification($notifi))->toOthers();
            toastr()->success('Đã Duyệt Thành Công');
            return response()->json(['message' => 'Update success'], 200);
        }else{
            return response()->json(['message' => 'Update failed'], 200);
        }
    }
    public function search(Request $request){
        $request->validate([
            'order_id' => 'nullable |string',
            'status' => 'nullable ',
            'start_date' => 'nullable |date ',
            'end_date' => 'nullable | date',
        ]);

        $query =  Refund_requests::query();

        if( $request->order_id!= ''){
             $query->where('order_id', 'like', '%'.$request->order_id.'%');
        }

        if( $request->status!= ''){
            $query->where('status', $request->status);
        }

        if(!empty($request->start_date)){
            $query->where('created_at', '>=', $request->start_date);
        }
        if(!empty($request->end_date)){
            $query->where('created_at', '<=', $request->end_date);
        }


        $refund = $query->get();
        // return $orders->isEmpty() ? response()->json($orders, 200) : addEmail($orders);
        return response()->json($refund);

    }

    //api

    public function cancelOrder(Request $request)   {
        $request->validate([
            'order_id' => 'required',
            'reason'=> 'required'
        ]);

        $order = Orders::where('id', $request->order_id)->first();
        if($order != null){
            $order -> is_done = 4;
            foreach(json_decode($order->products) as $item){
                $product = Products::where('id', $item->product_id)->first();
                $product->quantity += $item->quantity;
                $product->save();
            }
            $order->save();
             Refund_requests:: create([
                'order_id' => $request->order_id,
                'reason' => $request->reason,
                'status' => 0
            ]);

            return response()->json(['message' => 'Cancel success'], 200);
        }else{
            return response()->json(['message' => 'Cancel failed'], 200);
        }

    }
}
