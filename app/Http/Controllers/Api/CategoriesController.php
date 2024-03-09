<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

use Exception;



class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = categories::all(); // categories::all() phải trùng tên với tên model (model phải trùng tên với tên bảng trong database)

            return response()->json(['status' => true, 'message' => 'Categories retrieved successfully', 'data' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to retrieve categories', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
        // giá trị trả về từ request sẽ được kiểm tra xem có đúng với các quy định không
        $request->validate([
            'nameCategory' => 'required',
            'imageCategory' => 'required|image | mimes:jpeg,png,jpg,gif',
        ]);
        // tạo mới một đối tượng categories và gán giá trị từ request vào
        $categories = new categories();
        $categories->name = $request->nameCategory;

        if ($request->hasFile('imageCategory')) {
            $image = $request->file('imageCategory');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileName);
            $categories->image = $fileName;
        }else {
            return response()->json(['message' => 'Image is required'], 400);
        }

        $categories->save();

        return response()->json(['message' => 'Category created successfully', 'category' => $categories], 201);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating category', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {
        try {
            // Tìm kiếm category theo ID
            $categories = categories::findOrFail($id);

            // Trả về category nếu tìm thấy
            return response()->json(['categories' => $categories], 200);
        } catch (\Exception $e) {
            // Xử lý nếu không tìm thấy category hoặc có lỗi xảy ra
            return response()->json(['message' => 'Category not found'], 404);
        }
    }


    public function upload_photo(Request $request){

        $file = $request->file('file');

        try {
        $extension = $file->getClientOriginalExtension();

        $fullFileName = uniqid(). '.'. $extension;
        $timedir = date("Ymd");
        $file->storeAs($timedir, $fullFileName,  ['disk' => 'public']);

        $url = env('APP_URL').'/uploads/'.$timedir.'/'.$fullFileName;
      return ["code" => 0, "data" => $url, "msg" => "success"];
    } catch (Exception $e) {
      return ["code" => -1, "data" => "", "msg" => "error"];
   }
 }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) // hàm edit sẽ trả về một form để chỉnh sửa category
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     // hoạt động vs tên category còn image chưa thực hiện được
    public function update(String $id,Request $request ) // Hành động này thực hiện việc cập nhật dữ liệu trong cơ sở dữ liệu dựa trên dữ liệu mà người dùng đã chỉnh sửa trong biểu mẫu hoặc giao diện
    {
        try {
            // $request->validate([
            //     // 'id' => 'required',
            //     'name' => 'nullable | string | max:255',
            //     'image' => 'nullable |image | mimes:jpeg,png,jpg,gif',
            // ]);
            // Tìm kiếm category theo ID
            $category = Categories::findOrFail($id);

            // Cập nhật dữ liệu category từ request
            $category->name = $request->name;

            // Kiểm tra xem có tệp ảnh mới được gửi đi không
            if ($request->hasFile('image')) {
                // Kiểm tra xem category đã có ảnh trước đó hay không

                    // Nếu có, xóa ảnh cũ
                    $oldImagePath = public_path('uploads/' . $category->image);

                        unlink($oldImagePath); // Xóa ảnh cũ từ thư mục uploads

                    return response()->json(['message' => 'Upload image successfully', 'category' => $category], 200);

                // Lưu ảnh mới
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads'), $fileName);
                $category->image = $fileName;
            }
            // else {
            //     return response()->json(['message' => 'Image is required'], 400);}

            $category->save();

            // Trả về thông báo và dữ liệu category đã cập nhật
            return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
        } catch (\Exception $e) {
            // Xử lý nếu không tìm thấy category hoặc có lỗi xảy ra
            return response()->json(['message' => 'Error updating category', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Tìm kiếm category theo ID
            $category = Categories::findOrFail($id);

            // Xóa category
            $category->delete();
            // Xóa ảnh của category
            $oldImagePath = public_path('uploads/' . $category->image);
            unlink($oldImagePath); // Xóa ảnh cũ từ thư mục uploads

            // Trả về thông báo và dữ liệu category đã xóa
            return response()->json(['message' => 'Category deleted successfully', 'category' => $category], 200);
        } catch (\Exception $e) {
            // Xử lý nếu không tìm thấy category hoặc có lỗi xảy ra
            return response()->json(['message' => 'Error deleting category', 'error' => $e->getMessage()], 400);
        }
    }
}
