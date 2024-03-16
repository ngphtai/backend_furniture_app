<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\ListingImage;
use Illuminate\Http\UploadedFile\array;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('page.product');
    }

    public function list()
    {
        try {
            // Lấy danh sách sản phẩm từ cơ sở dữ liệu
            $products = Products::all();

            // Trả về danh sách sản phẩm
            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra
            return response()->json(['message' => 'Error retrieving products', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
        //     $validatedData = $request->validate([
        //     'product_name' => 'required|string|max:255',
        //     'category_id' => 'required|integer',
        //     'promotion_id' => 'nullable|integer',
        //     'rating_id' => 'nullable|integer',
        //     'rating_count' => 'nullable|integer',
        //     'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        //     'description' => 'nullable|string',
        //     'quantity' => 'required|integer|min:0',
        //     'price' => 'required|numeric|min:0',
        //     'sold' => 'nullable|integer|min:0',
        //     'status' => 'required|boolean',
        // ]);


        //   // Create new product instance
        //   $product = new Products();
        //   if($product :: findorfail($validatedData['product_name'])){
        //     return response()->json(['message' => 'Product already exists'], 400);
        //     }

        //   $product->product_name = $validatedData['product_name'];
        //   $product->category_id = $validatedData['category_id'] ;
        //   $product->promotion_id = $validatedData['promotion_id'];
        //   $product->rating_id = $validatedData['rating_id'];
        //   $product->rating_count = $validatedData['rating_count']?? 0;
        //   $product->description = $validatedData['description'];
        //   $product->quantity = $validatedData['quantity'];
        //   $product->price = $validatedData['price'];
        //   $product->sold = $validatedData['sold']?? 0;
        //   $product->status = $validatedData['status'];


        // // Handle product image upload
        // $imagePaths = [];
        // if ($request->hasFile('product_image')) {
        //     foreach ($request->file('product_image') as $image) {
        //         $fileName = time() . '_' . $image->getClientOriginalName();
        //         $image->move(public_path('uploads/product'), $fileName);
        //         $imagePaths[] = 'uploads/product/' . $fileName; // Lưu đường dẫn của ảnh vào mảng
        //     }
        // }
        // // else {
        // //    if($imagePaths == []){
        // //     return response()->json(['message' => 'Error'], 400);
        // //    }
        // // }
        // $product->product_image = json_encode($imagePaths);
        //  // Save the product
        //  $product->save();

        //  return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'promotion_id' => 'nullable|integer',
            'rating_id' => 'nullable|integer',
            'rating_count' => 'nullable|integer',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp', // Kiểm tra xem ảnh có phải là mảng không
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sold' => 'nullable|integer|min:0',
            'status' => 'required|boolean',
        ]);
         // Xử lý ảnh
        if (is_array($request->image['product_image'])) {
            return response()->json(['message' => 'Error'], 400);
        }

        // Tạo sản phẩm mới
        $product = Products::create([
            'product_name' => $validatedData['product_name'],
            'category_id' => $validatedData['category_id'],
            'promotion_id' => $validatedData['promotion_id'],
            'rating_id' => $validatedData['rating_id'],
            'rating_count' => $validatedData['rating_count'] ?? 0,
            'description' => $validatedData['description'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'],
            'sold' => $validatedData['sold'] ?? 0,
            'status' => $validatedData['status'],
        ]);

        $file = $_FILES['product_image'];
        $imagePaths = []; // Mảng chứa đường dẫn ảnh
        foreach (  $file  as $image) {
            $fileName = rand(99,9999) . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $fileName);
            $imagePaths[] += $image;// Lưu đường dẫn của ảnh vào mảng
        }

        // Lưu đường dẫn ảnh vào sản phẩm
        $product->product_image = $imagePaths;
        $product->save();

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating product', 'error' => $e->getMessage()], 400);
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
        $product = Products::findOrFail($id);
        return response()->json(['product' => $product], 200);
    }

    public function showByCategory(string $id)
    {
        $products = Products::where('category_id', $id)->get();
        return response()->json(['products' => $products], 200);
    }

    public function search(string $name)
    {
        $products = Products::where('product_name', 'like', '%' .$name . '%')->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found with the given name'], 404);
        }

        return response()->json(['message' => 'Products found successfully', 'products' => $products], 200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

            $product = Products::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    //tham khảo
    public function update1(Request $request, $id)
{

    // $listing = Listing::where('id', $id)->first();

    // $listing->title = $request->get('title');
    // $listing->price = $request->get('price');
    // $listing->address = $request->get('address');
    // $listing->rooms = $request->get('rooms');
    // $listing->city = $request->get('city');
    // $listing->state = $request->get('state');
    // $listing->zip_code = $request->get('zip_code');
    // $listing->area = $request->get('area');
    // $listing->balcony = $request->get('balcony');
    // $listing->bedrooms = $request->get('bedrooms');
    // $listing->bathrooms = $request->get('bathrooms');
    // $listing->toilet = $request->get('toilet');
    // $listing->bathroom_type = $request->get('bathroom_type');
    // $listing->kitchen = $request->get('kitchen');
    // $listing->parking_space = $request->get('parking_space');
    // $listing->description = $request->get('description');
    // $listing->featured = $request->get('featured');
    // $listing->status = $request->get('status');
    // $listing->type = $request->get('type');
    // $listing->water_supply = $request->get('water_supply');
    // $listing->power_supply = $request->get('power_supply');

    if($request->hasFile('images') != ''){

    //     $listingImage = ListingImage::findOrFail($id);
    //     //add new image
    //     foreach ($request->file('images') as $image) {
    //         // remove this line of code
    //         $image = $request->file('images');
    //        $imageName = time().'.'.$image->getClientOriginalExtension();

    //        $oldImagepath = $listingImage->image_path;
    //        // Update the database
    //        $listingImage->image_path = $imageName;
    //        // Delete the old photo
    //        Storage::delete($oldImagepath);
    //        $listingImage->save();
    //        $image->move(public_path('images/listing/'.$listing->id),$imageName);
    //    }
    }

    // $listing->save();
    return redirect('/home')->with('success', 'Listing updated!');
}
}
