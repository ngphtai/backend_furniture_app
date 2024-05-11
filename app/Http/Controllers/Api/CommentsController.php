<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForbiddenKeywords;
use App\Models\Comments;
use App\Models\Users;
use App\Models\Products;

use Illuminate\Support\Facades\DB;


class CommentsController extends Controller
{
    public function index(){
        $result['info']  = Comments::with('user', 'product')->paginate(10);
        $result['keys'] = json_decode(ForbiddenKeywords::first()->keyword);
        return view('page.comment')-> with($result);
    }

    public function addForbiddeneywords(Request $request)
    {
        $output1='';
        try{
            $request->validate([
                'keyword' => 'required'
            ]);

            $keyword = ForbiddenKeywords::all();

            if(count($keyword) == 0){
                $keyword = new ForbiddenKeywords();
                $keyword->keyword = json_encode([$request->keyword]);
            }else{
                $keyword = ForbiddenKeywords::first();
                $keywords = json_decode($keyword->keyword);
                foreach($keywords as $key){
                    if($key == $request->keyword){
                        return response()->json([
                            'message' => 'Keyword already exists'
                        ],401);
                    }
                }
                $keywords[]= $request->keyword;
                $keyword->keyword = json_encode($keywords);
            }
            $keyword->save();
            $output1 = $this->generateKeywordHTML(json_decode($keyword->keyword));
            return $output1;

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error: '.$e->getMessage()
            ],500);
        }
    }
    private function generateKeywordHTML($keywords)
    {
        $output1 = '';
        foreach ($keywords as $key) {
            $output1 .= '<div class="col">';
            $output1 .= '<div type="button" class="btn btn-info key-detail" data-key="' . $key . '">';
            $output1 .= $key;
            $output1 .= '<span class="badge bg-red"><i class="bx bxs-trash"></i></span>';
            $output1 .= '</div>';
            $output1 .= '</div>';
        }
        return $output1;
    }

    public function delete(Request $request){
        $output1 = '';
        try{
                $request->validate([
                    'delete_key' => 'required'
                ]);
                $keyword = ForbiddenKeywords::first();
                $keys = json_decode($keyword->keyword);

                $index = array_search($request-> delete_key,$keys);
                if($index !== FALSE){
                    unset($keys[$index]);
                }
                $keys = array_values($keys);
                $keyword->keyword = json_encode($keys);
                $keyword->save();


                $output1 = $this->generateKeywordHTML(json_decode($keyword->keyword));
                return $output1;

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error: '.$e->getMessage()
            ],500);
        }
    }
    public function search(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            // $data=Comments::where('content','like','%'.$request->search.'%')->get();
            $data = Comments::with('user')->where('content','like','%'.$request->search.'%')->get();
            if(count($data)>0){
                $item = Comments::with('user','product')->get();
                foreach ($data as $item ){
                    $output .='  <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="ms-2">
                                                <h6 class="mb-0 font-14">';
                                                $output .= $stt++;
                                 $output.= '</h6>
                                            </div>
                                        </div>
                                    </td>';
                    $output .='
                                    <td>'.
                                        // optional($item->user)->name
                                        $item -> user-> name
                                        .'</td>
                                    <td>'.$item -> order_id.'</td>
                                    <td>'.
                                     // optional($item->product())->product_name
                                        $item->product->product_name = \Illuminate\Support\Str::limit($item->product->product_name, 15, '...', 5)
                                   .'</td>
                                    <td>'.$item -> rating . '' ;
                                    foreach(range(1,5) as $i) {
                                        $output .= '<span class="fa-stack" style="width:1em">';
                                        $output .= '<i class="far fa-star fa-stack-1x text-warning"></i>';

                                        if($item->rating > 0) {
                                            if($item->rating > 0.5) {
                                                $output .= '<i class="fas fa-star fa-stack-1x text-warning"></i>';
                                            } else {
                                                $output .= '<i class="fas fa-star-half fa-stack-1x text-warning"></i>';
                                            }
                                        }

                                        $output .= '</span>';
                                    }
                                    $output .= '</td>
                                    <td class="mb-2">
                                        <h5 style=" font-size: 15px" >
                                        ';
                                            $output .= substr($item->content, 0,250) . '...'; '
                                        </h5>
                                    </td>
                                </tr>';
                            }

            }
            else{
                $output .='<div class="alert   alert-danger">Không tìm thấy bình luận nào</div>';
            }
            return $output;
        }
    }

    //API
    public function create(Request $request){
            $request->validate([
                'order_id' => 'required',
                'user_id' => 'required',
                'product_id' => 'required',
                'rating' => 'required| numeric | min:1 | max:5',
                'content' => 'required| string | max:350',
            ]);

            $id = Users::where('uid', $request->user_id)->first()->id;
            $bannedKey =  json_decode(ForbiddenKeywords::first()->keyword);
            foreach($bannedKey as $key){

                if(mb_stripos($request->content, $key) !== false){
                    return response()->json([
                        'message' => 'Comment has a forbidden: '.$key
                    ], 200);
                }
            }
            $order = DB::table('orders')->where('id', $request->order_id)->first();
            foreach(json_decode($order->products) as $product){
                if($product->product_id == $request->product_id){
                    $id = Users::where('uid', $request->user_id)->first()->id;
                    $comment = Comments::where('order_id', $request->order_id)->where('product_id', $request->product_id)->where('user_id',$id)->first();
                    if($comment != null){
                        return response()->json([
                            'message' => 'Comment already exists'
                        ], 200);
                    }
                }
            }

            $comment = new Comments();
            $comment->order_id = $request->order_id;
            $comment->user_id = $id;
            $comment->product_id = $request->product_id;
            $comment->rating = $request->rating;
            $comment->content = $request->content;

            $product = Products::where('id', $request->product_id)->first();
            $total_rated = Comments::where('product_id', $request->product_id)->count();
            $product->rating_count = ($product->rating_count* $total_rated + $request->rating) / ($total_rated + 1);
            $product->save();

            $comment->save();

            return response()->json([
                'message' => 'success'
            ],200);
    }

    public function show(Request $request){
        $request->validate([
            'product_id' => 'required'
        ]);
            $comments = Comments::where('product_id', $request->product_id)->with('user')->get();
            if(count($comments) == 0){
                return response()->json([
                    'message' => 'No comments found', 'data' => []
                ],200);
            }
            return response()->json([
                'data' => $comments
            ],200);

    }

}
