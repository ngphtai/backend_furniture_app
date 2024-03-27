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

    public function Profile(){
        // $result['info'] = DB::table('users')->where('user_type','admin' )->get()->toArray();
        return view('page.admin_detail') ;
    }

    public function index(){
        $result['info'] = DB::table('users')->get()->toArray();
        return view('page.Users', $result);
    }

    public function search(Request $request){
        $output ="";
        $stt = 1;
        if($request->ajax() && $request->search != ""){
            $data=Users::where('name','like','%'.$request->search.'%')
            ->orwhere('email','like','%'.$request->search.'%')
            ->orwhere('phone_number','like','%'.$request->search.'%')
            ->orwhere('uid','like','%'.$request->search.'%')->get();
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
                                <td>'.$item -> uid.'</td>
                                <td>'.$item -> name.'</td>
                                <td>';
                                if($item->avatar){
                                    $output.= ' <img class ="avatar" src="'. asset("storage/" . $item->avatar) .'" alt="No Avatar">';
                                 }else{
                                    $output .= ' <span class ="avatar">No avatar</span>';
                                 };'
                                </td>';
                                $output .='
                                <td>'.$item -> email.'</td>
                                <td>';$output .=$item -> address ?? "trống" .'</td>
                                <td>';$output .=$item -> phone_number ?? "trống".'</td>
                                ';$output .= '<td>';$output .=$item -> user_type .'</td>
                                <td>
                                    <div class="d-flex order-actions">'
                                        .' <a href= "/users/delete/'.$item->id.'" class="ms-3" onclick="'; $output .=' return confirm("Bạn có chắc chắn muốn xoá?")';$output .='"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </td>
                            </tr>';
                        }

            }
            else{
                $output .='<div class="alert alert-danger">Không tìm thấy tài khoản nào</div>';
            }
            return $output;
        }

    }

    //API

    public function create(Request $request)
    {
        $existingUser = users::where('uid', $request->uid)->first();
        if ($existingUser) {
            return response()->json(['message' => 'đăng nhập thành công với gg', 'user' => $existingUser], 200);
        }
        try{
            $validatedData = $request->validate([
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'avatar' => 'nullable',
                'password' => 'nullable',
                'address' => 'nullable',
                'phone_number' => 'nullable'

            ]);

            $user = new Users();
            $user->uid = $request->uid;
            $user->name = $request->name ;
            $user->email = $request->email;
            $user->avatar = $request->avatar ?? '/uploads/user1.jpg';
            $user->password = $request->password ?? '';
            $user->address = $request->address ?? '';


            $user -> save();
            return response()->json(['message' => 'User created successfully', 'user' => $user], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 400);
        }
    }



    public function show(Request $request)
    {

            $profile = users::where('uid', $request->uid)->first();
            $user = new Users();
            $user -> uid = $profile->uid ;
            $user -> name = $profile->name ;
            $user -> email = $profile->email ;
            $user -> avatar = $profile->avatar ;
            if($profile->password != null){
                $user -> password = $profile->password ;
            } else {
                $user -> password = '' ;
            }
            if( $profile->phone_number != null){
                $user -> phone_number = $profile->phone_number ;
            } else {
                $user -> phone_number = '' ;

            }
            if ($profile->address != null){
                $user -> address = $profile->address ;
            } else {
                $user -> address = '' ;
            }

            if ($profile) {
                return response()->json(['message' => 'User fetched successfully', 'user' => $user], 200);
            }
            return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{

            $validatedData = $request->validate([
                'uid' => 'required',
                'name' => 'nullable',
                'avatar' => 'nullable',
                'address' => 'nullable',
                'phone_number' => 'nullable',
                'email' => 'nullable | email',
                'password' => 'nullable',

            ]);
            $user = users::where('uid', $request->uid)->first();
            $user->name = $request->name?? $user->name;
            $user->address = $request->address ?? $user->address;
            $user->phone_number = $request->phone_number?? $user->phone_number;
            $user->password = $request->password ?? $user->password;
            $user -> save();

            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error updating user', 'error' => $e->getMessage()], 400);
        }
    }

    public function update_avatar(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'uid' => 'required',
                'avatar' => 'required|image',
            ]);
            $user = users::where('uid', $request->uid)->first();
            if($user->avatar!= null){
                $user->avatar = $request->avatar;
                $filename = $user-> uid .'.' . $request->avatar->getClientOriginalExtension();
                $path = $request->avatar->storeAs('avatars', $filename, 'public');
                $user->avatar =  $path;
            }

            $user -> save();
            return response()->json(['message' => 'Avatar updated successfully', 'user' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error updating avatar', 'error' => $e->getMessage()], 400);
        }
    }



}
