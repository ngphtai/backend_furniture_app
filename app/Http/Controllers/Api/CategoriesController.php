<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $result['info'] = DB::table('categories')->get()->toArray();
       return view('page.category', $result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $user = auth()->guard('ANNTStore')->user();
            if($user->user_type != 'Admin'){
                toastr()->error("Tài khoản không có quyền thực hiện chức năng này!");
                return response()->json(['status' => 200]);
            }
            $request->validate([
                'name' => 'required',
                'image' => 'required|image',
            ]);

            $categories = new categories();
            $categories->name = $request->name;

            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $pathFile = $image->storeAs('categories', $fileName, 'public');
            $categories->image = $pathFile;

            $categories->save();

            session()->flash('success', 'Category created successfully');
            return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request) // hàm edit sẽ trả về một form để chỉnh sửa category
    {
        $categories = Categories::findOrFail($request->id);
        return response($categories)  ;
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(String $id,Request $request ) // Hành động này thực hiện việc cập nhật dữ liệu trong cơ sở dữ liệu dựa trên dữ liệu mà người dùng đã chỉnh sửa trong biểu mẫu hoặc giao diện
    {
            $user = auth()->guard('ANNTStore')->user();
            if($user->user_type != 'Admin'){
                toastr()->error("Tài khoản không có quyền thực hiện chức năng này!");
                return response()->json(['status' => 200]);
            }

            $request->validate([
                // 'id' => 'required',
                'name' => 'nullable | string ',
                'image' => 'nullable |image',
            ]);
            // Tìm kiếm category theo ID
            $category = Categories::findOrFail($id);

            // Cập nhật dữ liệu category từ request
            $category->name = $request->name?? $category->name;

             // Kiểm tra xem có tệp ảnh cũ và xóa nếu tồn tại


            // Kiểm tra xem có tệp ảnh mới được gửi đi không
            if ($request->file('image')!= null) {
                if ($category->image && file_exists(public_path('storage/' . $category->image))) {
                    unlink(public_path('storage/' . $category->image));
                }
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $pathFile = $image->storeAs('categories', $fileName, 'public');
                $category->image = $pathFile;

            }

            $category->save();

            session()->flash('success', 'Category updated successfully');
            return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->guard('ANNTStore')->user();
            if($user->user_type != 'Admin'){
                toastr()->error("Tài khoản không có quyền thực hiện chức năng này!");
                return redirect()->route('category.index');
            }
            $category = Categories::findOrFail($id);

            // Xóa category
            $category->delete();
            // Xóa ảnh của category
            $oldImagePath = public_path('storage/' . $category->image);
            unlink($oldImagePath); // Xóa ảnh cũ từ thư mục uploads

            session()->flash('success', 'Category deleted successfully');
            return redirect()->route('category.index');
    }


    public function search(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            $data=Categories::where('name','like','%'.$request->search.'%')->get();
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
                                <td>'.$item -> name.'</td>
                                <td>
                                '; $output.=' <img class="image_review_category" src="'.asset("/storage/" . $item->image).'" alt="No Image">'.'  </td>
                                <td>
                                    <div class="d-flex order-actions">'
                                        .'<div class="ms-center " data-bs-toggle="modal" data-bs-target="#editCategoryModal"  >'.'
                                        <a class="edit-category-btn"'; $output .='  id = '.$item -> id.' > '.'
                                        <i '; $output .='  class=" bx bxs-edit " '.'></i></a>'.'
                                    </div>'
                                        .' <a href= "{{url("categories/delete",'.$item->id.')}}" class="ms-3" onclick="'; $output .=' return confirm("Bạn có chắc chắn muốn xoá?")';$output .='"><i class="bx bxs-trash"></i></a>
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
    // tham khảo
    // public function upload_photo(Request $request){

    //     $file = $request->file('file');

    //     try {
    //     $extension = $file->getClientOriginalExtension();

    //     $fullFileName = uniqid(). '.'. $extension;
    //     $timedir = date("Ymd");
    //     $file->storeAs($timedir, $fullFileName,  ['disk' => 'public']);

    //     $url = env('APP_URL').'/uploads/'.$timedir.'/'.$fullFileName;
    //     return ["code" => 0, "data" => $url, "msg" => "success"];
    //     } catch (Exception $e) {
    //         return ["code" => -1, "data" => "", "msg" => "error"];
    //     }
    // }



    //API
    public function show_all()
    {
        try {
            // Lấy danh sách category từ cơ sở dữ liệu
            $categories = Categories::all();

            // Trả về danh sách category
            return response()->json(['message' => 'get successfuly categories','categories' => $categories], 200);
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra
            return response()->json(['message' => 'Error get categories', 'error' => $e->getMessage()], 500);
        }
    }
    public function show(string $id)
    {

        $categories = categories::findOrFail($id);
        return response()->json($categories, 200);

    }

}
