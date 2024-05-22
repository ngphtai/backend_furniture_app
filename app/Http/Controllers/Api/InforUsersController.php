<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InforUsers;
use Illuminate\Support\Facades\Hash;


class InforUsersController extends Controller
{
    //API

    public function create(Request $request)
    {
        $existingUser = inforUsers::where('uid', $request->uid)->first();
        if ($existingUser) {
            if($request-> password != null){
                $existingUser->password = bcrypt($request->password);
                $existingUser->save();
            }
            return response()->json(['message' => 'đăng nhập thành công với tài khoản', 'user' => $existingUser], 200);
        }
        try{
             $request->validate([
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:Users',
                'avatar' => 'nullable',
                'password' => 'nullable',
                'address' => 'nullable',
                'phone_number' => 'nullable'

            ]);

            $user = new inforUsers();
            if($request->avatar ==''){
                $user->avatar = 'storage/avatars/default.png';
            }
            $user->uid = $request->uid;
            $user->name = $request->name ;
            $user->email = $request->email;
            $user->avatar = $request->avatar ?? 'storage/avatars/default.png';
            $user->password = bcrypt($request->password) ?? null;
            $user->address = $request->address ?? null;

            $user -> save();
            return response()->json(['message' => 'User created successfully', 'user' => $user], 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 200);
        }
    }

    public function checklock(Request $request)
    {
        $request->validate([
            'uid' => 'required'
        ]);
        $user = inforUsers::where('uid', $request->uid)->first();
        if($user->is_lock == 1){
            return response()->json(['message' => 'true'], 200);
        }else
        {
            return response()->json(['message' => 'false'], 200);
        }

    }


    public function show(Request $request)
    {
            $request->validate([
                'uid' => 'required'
            ]);
            $profile = inforUsers::where('uid', $request->uid)->first();
            $user = new inforUsers();
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
            return response()->json(['message' => 'User not found'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    $request->validate([
        'uid' => 'required',
        'name' => 'nullable',
        'avatar' => 'nullable',
        'address' => 'nullable',
        'phone_number' => 'nullable',
        'email' => 'nullable | email',
        'password' => 'nullable',
        'old_password' => 'nullable',
    ]);

    $user = InforUsers::where('uid', $request->uid)->first();

    $user->name = $request->name ?? $user->name;
    $user->address = $request->address ?? $user->address;
    $user->phone_number = $request->phone_number ?? $user->phone_number;

    if ($request->password != null && $request->old_password != null) {
            if (Hash::check($request->old_password, $user->password)) {

                // $user->password = Hash::make($request->password);
                // $user->save(); // Save the updated user with reset flag
                return response()->json(['message' => 'Password updated successfully', 'user' => $user], 200);
            }else {
                return response()->json(['message' => 'Old password is incorrect', 'user' => null], 200);
            }

    }

    $user->save();

    return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
}


    public function update_avatar(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'uid' => 'required',
                'avatar' => 'required|image',
            ]);
            $user = inforUsers::where('uid', $request->uid)->first();
            if($request->avatar!= null){
                // $user->avatar = $request->avatar;
                $filename = time().rand(1,99) . '_' . $user-> uid .'.' . $request->avatar->getClientOriginalExtension();
                $directory =  $user-> uid;
                $path =  $request->avatar->storeAs('avatars/'.$directory, $filename, 'public');
                $path = "storage/" . $path;
                $user->avatar =  $path;
            }
            $user -> save();
            return response()->json(['message' => 'Avatar updated successfully', 'user' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 200);
        }
    }

}
