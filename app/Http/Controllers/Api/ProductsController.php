<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Promotions;
use App\Models\Colors;
use App\Models\Orders;
use App\Models\Comments;

use function PHPUnit\Framework\isEmpty;

class ProductsController extends Controller
{

    public function index()
    {
        $result['info'] = Products::with('promotion', 'category')->paginate(10);

        $result['colors'] = DB::table('colors')->get();
        return view('page.product')-> with($result);
    }
    public function detail1(Request $request){

        $request ->validate([
            'id' => 'required|integer',
            'order_id' => 'required'
        ]);

        $timeOrder = Orders::where('id', $request->order_id)->first()->created_at -> timestamp;

        $product = Products::where("id",$request ->id)->first();
        $promotion = Promotions::where("id",$product->promotion_id)->first();


        if(empty($promotion)){
            $product-> promotion_id = 0;
        }
        else{
         if( $timeOrder > strtotime($promotion->start_date) &&  $timeOrder < strtotime($promotion->end_date)){
            $product-> promotion_id = $promotion->discount;
         }
         else {
            $product-> promotion_id = 0;
         }
        }

        return response()->json( $product, 200);

    }

    // display product detail
    public function detail($id)
    {
        $result['info'] = $id;

        return view('page.product_detail')-> with($result);
    }

    public function addProduct()
    {
        return view('page.add_product');
    }

    public function store(Request $request)
    {

        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'promotion_id' => 'nullable ',
            'rating_count' => 'nullable|integer',
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sold' => 'nullable|integer|min:0',
            'is_show' => 'required|boolean',
        ],);


        $product = new Products();
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->promotion_id = $request->promotion_id?? '';
        $product->rating_count = $request->rating_count?? 5;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->check_quantity = $request->quantity;
        $product->price = $request->price;
        $product->sold = $request->sold??0;
        $product->is_show = $request->is_show;

        $imagePaths = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $fileName = time().rand(1,99) . '.' . $file->getClientOriginalExtension();
                $directory =  substr($request->product_name, 1, 5);
                $pathFile = $file->storeAs('products/'.$directory, $fileName, 'public');
                $imagePaths[] = $pathFile;
            }
        }else{
            session()->flash('error', 'Please upload at least one image');
            return redirect()->route('product.addProduct');
        }

        $product->product_image = json_encode($imagePaths);
        $product->save();

        session()->flash('success', 'Product added successfully');
        return redirect()->route('product.addProduct');

    }

    public function update(Request $request, String $id)
    {

        $request->validate([
            'product_name' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'promotion_id' => 'nullable|integer',
            'add_quantity' => 'nullable|integer',
            'images' => 'nullable|string',  // ảnh cũ
            'file.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp', // ảnh mới thêm
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'is_show' => 'nullable|boolean',
        ]);
        if($request->product_name == null && $request->category_id == null && $request->promotion_id == null && $request->add_quantity == 0 && $request->images == null && $request->description == null && $request->price == null && $request->is_show == null){
            toastr()->error('Không có dữ liệu để cập nhật');
            return response()->json(['message' => 'No data to update'], 400);
        }
        $product = Products::findOrFail($id);
        $product -> product_name = $request->product_name?? $product->product_name;
        $product -> category_id = $request->category_id?? $product->category_id;
        $product -> promotion_id = $request->promotion_id?? $product->promotion_id;
        $product -> description = $request->description?? $product->description;
        $product -> quantity = $product->quantity + $request->add_quantity;
        if($product->quantity < 0){
            toastr()->error('Số lượng sản phẩm không hợp lệ');
            return response()->json(['message' => 'Invalid quantity'], 400);
        }
        $product -> check_quantity = $product->check_quantity + $request->add_quantity;
        $product -> price = $request->price?? $product->price;
        $product -> is_show = $request->is_show?? $product->is_show;


        $directory = substr($product->product_name, 1, 5);
        $storedImages = [];
        if ($request->has('images') ) {
            $images = explode(',', $request->images); // lấy ra mảng ảnh cũ

            if($request -> has('file')){
                // $imges_array = substr($images_string, 2, -2);
                // $images = explode(',',  $imges_array );
                //  return $images;

                // Store new images
                foreach ($request->file('file') as $file) {
                    $fileName = time() . rand(1, 99) . '.' . $file->getClientOriginalExtension();
                    $path = "products/{$directory}/{$fileName}";
                    Storage::disk('public')->put($path, file_get_contents($file));
                    $storedImages[] = $path;
                }
            }
            foreach ($images as $image) {
                $storedImages[] = $image;
            }
            $storedImages = array_filter($storedImages);
            $productData['product_image'] = json_encode($storedImages);
        }

        $product->fill($productData)->save();
        session()->flash('success', 'Cập nhật thành công thông tin sản phẩm');
        return response()->json(['message' => 'Product updated successfully'], 200);
    }



    public function destroy(string $id)
    {

            $product = Products::findOrFail($id);
            // xoá file cũ
            $images = json_decode($product->product_image);
            //lấy 5 kí tự đầu trong file image
            foreach ($images as $image) {
                $folder = str($image,0,5); //lấy 5 kí tự đầu
                Storage::delete('public/products/'.$folder);
                break;
            }
            $product->delete();
            session()->flash('success', 'Product deleted successfully');
            return redirect()->route('product.index');
    }

    public function search_admin(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            $data=Products::where('product_name','like','%'.$request->search.'%')->get();
            if(count($data)>0){
                // $output ='
                // <div class="alert alert-success">'.count($data).' kết quả được tìm thấy</div>
                $item = Products::with('category')->get();
                foreach ($data as $item ){
                    $images = json_decode($item -> product_image) ;

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
                                <td>
                                    <div class="avatar-lg me-4">
                                        <img src=" '.asset('storage/' . $images[0]).' " alt="Hình ảnh" style="width: 100px; height: 100px;">
                                    </div>
                                 </td>

                                 <td>
                                    <div ';$output.='class="mb-3" >'.'
                                    ';$output.=' <h5 class="font-size-18 " >'.'
                                            <a href="'. url("products/detail", $item->id) .'" class= ';$output.='"text-dark">';
                                            $output .= substr($item->product_name, 0, 50) . '...'; '
                                            </a>
                                        </h5>
                                        ';$output.='<h6 class="font-size-15">';$output .= optional($item->category)->name ;' </h6>'.'
                                        ';$output.='<p '.'  class="text-muted mb-0 mt-2 pt-2">
                                            ';$output .= $item->rating_count.'
                                            <i   class="bx bxs-star text-warning"></i>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <ul class="list-unstyled ps-0 mb-0 ">
                                        <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Tồn kho:<b style ="font size:13 px">'.$item -> quantity.'</b> </p></li>
                                        <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Đã bán:<b style ="font size:13 px"> '.$item -> sold.'</b> </p></li>
                                        <li><p class="text-muted mb-0 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Giá tiền: <b style ="font size:15 px">'.$item -> price.'</b></p></li>
                                        <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Khuyến mãi: <b style ="font size:13 px">';$output .=optional($item->promotion)->name??"trống".'</b> </p></li>
                                    </ul>
                                </td>

                                <td class="col-md-4 text-muted" style=" font-size: 15px">'; $output .=  substr($item->description, 0, 150) . '...'; '</td>

                           ';$output .=' <td class ="col-md-1">
                                <a href="'. url('products/detail', $item->id) .'"  '; $output .=' class="btn btn-primary btn-sm waves-effect waves-light" style ="font-size:20px;"><i '; $output .=' class="bx bx-detail me-2 align-middle"></i></a>
                            </td>

                            <td class="col-md-1">
                                <div class="d-flex order-actions" style="font-size: 20px;">';
                                if($item ->is_show == 1){
                                    $output .= '<icon class="badge bg-success">Hiển Thị</icon>';
                                }else{
                                $output .= '<icon class="badge bg-danger">Ẩn</icon>';
                                }
                $output .='   </div>
                            </td>

                            <td class="col-md-1">
                                <div class="d-flex order-actions">
                                    <a href="'.url("products/delete", $item->id) .'" onclick="'; $output .=' return confirm("Bạn có chắc chắn muốn xoá?")';$output .='"><i class="bx bxs-trash" ></i></a>
                                </div>
                            </td>


                            </tr>';
                        }

            }
            else{
                $output .='<div class="alert alert-danger">Không tìm thấy sản phẩm nào</div>';
            }
            return $output;
        }

    }

    // API
    //detail product
    public function show(Request $request)
    {
        $product = Products::where("id",$request ->id)->where('is_show', 1)->first();
        // lấy ra discount khuyến mãi đưa vào promotion_id của sản phẩm
        $promotion = Promotions::where("id",$product->promotion_id)->first();
                if(empty($promotion)){
                    $product-> promotion_id = 0;
                }
                else{
                    if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                        $product-> promotion_id = $promotion->discount;
                    }
                    else {
                        $product-> promotion_id = 0;
                    }
                }
            //  lấy màu của sản phẩm và đưa vào biến color_name
            $color_id = mb_substr($product->product_name, 5, 1);
            $color = Colors::where('id',$color_id)->first();
            $color = $color->color_name;
            $product-> color_name = $color;
            // $product->product_image = json_decode($product->product_image);
        //giải mã ảnh
        $product->product_image = json_decode($product->product_image);

        return response()->json(['product' => $product], 200);
    }

    // public function showByCategory(Request $request)
    // {
    //     $products = Products::where('category_id', $request ->id)
    //                         ->where('is_show', 1)
    //                         ->get();
    //     foreach ($products as $product) {
    //         $promotion = Promotions::findOrFail($product->promotion_id)->first();
    //             if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
    //                 $product-> promotion_id = $promotion->discount;
    //             }
    //             else {
    //                 $product-> promotion_id = 0;
    //             }

    //         //lấy màu của sản phẩm và đưa vào biến color_name
    //         $color_id = mb_substr($product->product_name, 5, 1);
    //         $color = Colors::where('id',$color_id)->first();
    //         $color = $color->color_name;
    //         $product-> color_name = $color;
    //        $product->product_image = json_decode($product->product_image);
    //     }
    //     return response()->json(['products' => $products], 200);
    // }


    public function all(){
        $products = Products::where('is_show', 1)->get();
        foreach ($products as $product) {
            $promotion = Promotions::where("id",$product->promotion_id)->first();
                if(empty($promotion)){
                    $product-> promotion_id = 0;
                }
                else{
                    if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                        $product-> promotion_id = $promotion->discount;
                    }
                    else {
                        $product-> promotion_id = 0;
                    }
                }
            //  lấy màu của sản phẩm và đưa vào biến color_name
            $color_id = mb_substr($product->product_name, 5, 1);
            $color = Colors::where('id',$color_id)->first();
            $color = $color->color_name;
            $product-> color_name = $color;
            $product->product_image = json_decode($product->product_image);
        }
        return response()-> json(['products' => $products],200);
    }

    public function search(Request $request){

        $request ->validate(
            [
                    'category_id' => 'nullable|integer',
                    'product_name' => 'nullable|string',
                    'rating_count' => 'nullable ',
                    'price_min' => 'nullable|numeric ',
                    'price_max' => 'nullable|numeric',
                    'type' => 'nullable|string'
                ]
        );



        $productRequest= Products::query()->where('is_show','=', 1);

        if (!empty($request->category_id)) {
            $productRequest->where('category_id','=', $request->category_id);

        }

        if (!empty($request->rating_count)) {
             $productRequest->where('rating_count','>=', $request->rating_count);

        }


        if (!empty($request->price_min)) {
              $productRequest->where('price', '>=', $request->price_min);

        }

        if (!empty($request->price_max)) {
             $productRequest->where('price', '<=', $request->price_max);

        }

        if (!empty($request->product_name)) {
            $productRequest->whereRaw('LOWER(product_name) LIKE ?', ['%' . strtolower($request->product_name) . '%']);
        }


        if (!empty($request->type)) {
            switch ($request->type) {
            case 'asc':
                $productRequest->orderBy('price','asc');
                break;
            case 'desc':
                $productRequest->orderBy('price','desc');
                break;
            }
        }

        //handle data to transform data
        function handledata($products)
        {
            foreach ($products as $item) {
                $promotion = Promotions::where("id", $item->promotion_id)->first();
                if (empty($promotion)) {
                    $item->promotion_id = 0;
                } else {
                    if (time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)) {
                        $item->promotion_id = $promotion->discount;
                    } else {
                        $item->promotion_id = 0;
                    }
                }
                //lấy màu của sản phẩm và đưa vào biến color_name
                $color_id = mb_substr($item->product_name, 5, 1);
                $color = Colors::where('id',$color_id)->first();
                $color = $color->color_name;
                $item-> color_name = $color;
                $item->product_image = json_decode($item->product_image);
            }
            return response()->json([ 'products' => $products], 200);
        }

        $products = $productRequest->get();

        return $products->isEmpty() ? response()->json(['products' => []], 200) : handledata($products);

    }

    public function newProduct()
    {
        $products = Products::where('is_show', 1)->orderBy('created_at', 'desc')->take(5)->get();
        foreach ($products as $product) {
            $promotion = Promotions::where("id",$product->promotion_id)->first();
                if(empty($promotion)){
                    $product-> promotion_id = 0;
                }
                else{
                    if(time() > strtotime($promotion->start_date) && time() < strtotime($promotion->end_date)){
                        $product-> promotion_id = $promotion->discount;
                    }
                    else {
                        $product-> promotion_id = 0;
                    }
                }
            //  lấy màu của sản phẩm và đưa vào biến color_name
            $color_id = mb_substr($product->product_name, 5, 1);
            $color = Colors::where('id',$color_id)->first();
            $color = $color->color_name;
            $product-> color_name = $color;
            $product->product_image = json_decode($product->product_image);
        }
        return response()-> json(['data' => $products],200);
    }
}
