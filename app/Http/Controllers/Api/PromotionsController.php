<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Promotions;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;


class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result['info'] = DB::table('promotions')->get()->toArray();
        return view('page.promotion', $result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // try{
        //     $request -> validate([
        //         'promotion_name' => 'required',
        //         'description' => 'required',
        //         'discount' => 'required | integer | min:0 | max:100',
        //         'start_date' => 'required | date  ',
        //         'end_date' => 'required | date  ',
        //         'is_show' => 'required | boolean'
        //     ]);

        //     $promotion = new Promotions();
        //     $promotion -> promotion_name = $request -> promotion_name;
        //     $promotion -> description = $request -> description;
        //     $promotion -> discount = $request -> discount;
        //     $promotion -> start_date = $request -> start_date;
        //     $promotion -> end_date = $request -> end_date;
        //     $promotion -> is_show = $request -> is_show;

        //     $promotion -> save();
        //     return response()->json(['message' => 'Promotion created successfully'], 200);
        // }catch(\Exception $e){
        //     return response()->json(['message' => 'Error creating promotion', 'error' => $e->getMessage()], 400);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = Promotions::findOrFail($id);
        return response()->json($request, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(String $id,Request $request)
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
            $promotion -> is_show = $request -> is_show     ?? $promotion -> is_show;

            $promotion -> save();
            return response()->json(['message' => 'Promotion updated successfully',$promotion  ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

            $promotion = Promotions::findOrFail($id);
            $promotion->delete();
            session()->flash('delete success', 'Promotion deleted successfully');
            return redirect()->route('promotion.index');
    }

    // search by name

    public function search(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            $data=Promotions::where('promotion_name','like','%'.$request->search.'%')->get();
            if(count($data)>0){
                // $output ='
                // <div class="alert alert-success">'.count($data).' kết quả được tìm thấy</div>

                    foreach ($data as $item ){
                    $output .='
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">';
                                                $output .= $stt++;
                                 $output.= '</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>'.$item -> promotion_name.'</td>
                                <td>'.$item -> description.'</td>
                                <td>'.$item -> discount.'</td>
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
                                        .'<a href="javascript:;" class=""><i class="bx bxs-edit"></i></a>'
                                        .' <a href= "/promotions/delete/'.$item->id.'" class="ms-3" '.' onclick="return confirm("Bạn có chắc chắn muốn xoá?")'.'">'.'<i class="bx bxs-trash"></i></a>
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
}
