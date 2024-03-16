<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{


    public function index(){
        $result['info'] = DB::table('users')->get()->toArray();
        //set data to view
        return view('page.Users', $result);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'avatar' => 'required',
            ]);

            $user = new Users();
            $user->uid = $request->uid;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->avatar = $request->avatar;

            $user -> save();
            return response()->json(['message' => 'User created successfully', 'user' => $user], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            // Lấy dữ liệu từ request
        $data = $request->all();

        // Lưu dữ liệu vào bảng
        $user = Users::create($data);

        // Trả về kết quả
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $user = Users::findOrFail($id);

            return response()->json(['status' => true, 'message' => 'User retrieved successfully', 'data' => $user], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving user', 'error' => $e->getMessage()], 500);
        }
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
    public function update(Request $request, string $id)
    {
        try{

            $validatedData = $request->validate([
                'name' => 'nullable',
                'email' => 'nullable|email|unique:users',
                'avatar' => 'nullable',
                'address' => 'nullable',
                'phone_number' => 'nullable'
            ]);

            $user = new Users();
            $user = Users::findOrFail($id);
            if($request->hasFile('avatar')){
                // xóa file cũ trên storage public
                $oldfile = public_path('storage/'.  basename($user->avatar));
                unlink($oldfile);

                $image = $request->file('avatar');
                // đổi tên image thày tên mới là id của user
                $fileName = $user-> uid . '.' . $image->getClientOriginalExtension();
                $pathFile = $image->storeAs('avatars', $fileName, 'public');
                 $user->avatar = $pathFile;

            }
            $user->name = $request->name?? $user->name;
            $user->email = $request->email ?? $user->email;
            $user->adress = $request->adress ?? $user->adress;
            $user->phone_number = $request->phone_number?? $user->phone_number;
            $user -> save();

            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error updating user', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function search(Request $request){

        if($request->ajax()){

            $data=Users::where('name','like','%'.$request->search.'%')
            ->orwhere('email','like','%'.$request->search.'%')->get();

            $output='';
            if(count($data)>0){
                $output ='
                    <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                    </tr>
                    </thead>
                    <tbody>';
                        foreach($data as $row){
                            $output .='
                            <tr>
                            <th scope="row">'.$row->id.'</th>
                            <td>'.$row->name.'</td>
                            <td>'.$row->email.'</td>
                            </tr>
                            ';
                        }
                $output .= '
                    </tbody>
                    </table>';
            }
            else{
                $output .='No results';
            }
            return $output;
        }
    }
}
