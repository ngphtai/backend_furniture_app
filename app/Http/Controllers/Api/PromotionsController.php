<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PromotionsController extends Controller
{
    public function index()
    {
        $result['info'] = DB::table('promotions')->paginate(10);
        return view('page.promotion', $result);
    }
    public function edit(Request $request)
    {
        $promotion = Promotions::where('id', $request->id)->first();
        return response()->json($promotion, 200);
    }


    public function store(Request $request)
    {

             $request -> validate([
                'promotion_name' => 'required',
                'description' => 'required',
                'discount' => 'required | integer | min:0 | max:100',
                'start_date' => 'required | date | after:end_date  ',
                'end_date' => 'required | date | after:start_date',
                'is_show' => 'required | boolean'
            ]);


            $promotion = new Promotions();
            $promotion -> promotion_name = $request -> promotion_name;
            $promotion -> description = $request -> description;
            $promotion -> discount = $request -> discount;
            $promotion -> start_date = $request -> start_date;
            $promotion -> end_date = $request -> end_date;
            $promotion -> is_show = $request -> is_show;

            $promotion -> save();
            session()->flash('success', 'Promotion created successfully');
            return redirect()->route('promotion.index');

    }

    public function update(string $id,Request $request)
    {

            $request -> validate([
                'id' => 'required',
                'promotion_name' => 'nullable',
                'description' => 'nullable',
                'discount' => 'nullable | integer | min:0 | max:100',
                'start_date' => 'nullable | date  ',
                'end_date' => 'nullable | date  ',
                'is_show' => 'nullable | boolean'
            ]);

            $promotion = Promotions::findOrFail($id);
            $promotion -> promotion_name = $request -> promotion_name ?? $promotion -> promotion_name;
            $promotion -> description = $request -> description ?? $promotion -> description;
            $promotion -> discount = $request -> discount ?? $promotion -> discount;
            $promotion -> start_date = $request -> start_date ?? $promotion -> start_date;
            $promotion -> end_date = $request -> end_date ?? $promotion -> end_date;
            $promotion -> is_show = $request -> is_show    ?? $promotion -> is_show;

            $promotion -> save();
            session()->flash('success', 'Promotion updated successfully');
            return response()->json(['status' => 200]);
    }

    public function destroy(string $id)
    {

            $promotion = Promotions::findOrFail($id);
            $promotion->delete();
            session()->flash('success', 'Promotion deleted successfully');
            return redirect()->route('promotion.index');
    }

    // search by name
    public function search_admin(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            $data=Promotions::where('promotion_name','like','%'.$request->search.'%')->orwhere('description','like','%'.$request->search.'%')->get();
            // if seacrh by discount have % in search
            if(strpos($request->search, '%') == true){
                $data = Promotions::where('discount', 'like', '%' . substr($request->search, 0, -1) . '%')
                    ->get();
            }


            if(count($data)>0){
                    foreach ($data as $item ){
                    $output .='
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">'
                                                .$item -> id.
                                        '</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>'.$item -> promotion_name   .'</td>
                                <td>'.$item -> description.'</td>
                                <td>'.$item -> discount.'%</td>
                                <td>'.$item -> start_date.'</td>
                                <td>'.$item -> end_date.'</td>
                                <td>';
                                    if($item ->is_show == 1){
                                        $output .= '<icon class="badge bg-success">Hiển Thị</icon>';
                                    }else{
                                       $output .= '<icon class="badge bg-danger">Ẩn</icon>';
                                    }
                    $output .='</td>
                                <td>
                                    <div class="d-flex order-actions">'
                                        .'<div class="ms-auto " data-bs-toggle="modal" data-bs-target="#editPromotionModal"  >'.'
                                        <a class="edit-promotion-btn" id = '.$item -> id.' onclick="editPromotion('.$item->id.')" class=""><i '; $output .='  class=" bx bxs-edit " '.'></i></a>'.'
                                    </div>'

                                        .' <a href= "/promotions/delete/'.$item->id.'" class="ms-3" onclick="'; $output .=' return confirm("Bạn có chắc chắn muốn xoá?")';$output .='"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </td>
                            </tr>';
                        }

            }
            else{
                $output .='<div class="alert alert-danger">Không tìm thấy khuyến mãi nào</div>';
            }
            return $output;
        }

    }

    //API
    public function showAll()
    {
        $request = Promotions::all();
        return response() -> json($request, 200) ;
    }


}
