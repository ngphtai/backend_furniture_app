<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refund_requests;
use App\Models\Products;
use App\Models\Orders;
use Stripe\Refund;

class RefundRequestController extends Controller
{
    public function index(){
        $info = Refund_requests::orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(15);

        return view('page.approve_refund',compact('info'));
    }
    public function cancelOrder(Request $request){
        $request->validate([
            'id' => 'required',
            'reason'=> 'required'
        ]);

        $order = Orders::where('id', $request->id)->first();
        if($order != null){
            $order -> is_done = 4;
            foreach(json_decode($order->products) as $item){
                $product = Products::where('id', $item->product_id)->first();
                $product->quantity += $item->quantity;
                $product->save();
            }
            $order->save();
             Refund_requests:: create([
                'order_id' => $request->id,
                'reason' => $request->reason,
                'status' => 0
            ]);

            return response()->json(['message' => 'Cancel success'], 200);
        }else{
            return response()->json(['message' => 'Cancel failed'], 200);
        }

    }
    public function update(Request $request){
        $refund = Refund_requests::where('id', $request->id)->first();
       if( $refund->status == 0){
            $refund->status = 1;
            $order = Orders::where('id', $refund->order_id)->first();
            $order->is_done = -1;
            // return json_decode($order->products);
            foreach(json_decode($order->products) as $item){
                $product = Products::where('id', $item->product_id)->first();
                $product->quantity += $item->quantity;
                $product->check_quantity += $item->quantity;
                $product->save();
            }
            $order->save();
            $refund->save();
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
}
