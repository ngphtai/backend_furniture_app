<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                // 'avatar' => 'required',
                // 'type'  => 'required',
                // 'open_id' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $validateUser = $validateUser->validated();

            $map =[];

            // $map['type'] = $validateUser['type'];
            // $map['open_id'] = $validateUser['open_id'];

            $user = User::where($map)-> first();

            // khi tài khoản đã tồn tại và sẵn sàng đăng nhập
            // lưu thông tin tài khoản cho lần đầu đăng nhập
            if(empty($user->id)){
                $validated['token'] =md5(uniqid().rand(1000,9999));// tạo token cho lần đăng nhập đầu tiên
                $validated['created_at'] = Carbon::now(); // thời gian tạo tài khoản
                $userID  = User::insertGetId($validated); // lưu thông tin tài khoản
                $userInfo = User::where('id','=',$userID);
                $accsessToken = $userInfo-> createToken(uniqid())->plainTextToken; // tạo token cho lần đăng nhập đầu tiên

                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'data' => $userInfo,
                ], 200); // trả về thông tin tài khoản và token
            }

                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);


            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first(); // get the user from the database by email

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function login(Request $request)
    {


try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'avatar'=>'required',
                'type'=>'required',

                'name' => 'required',
                'email' => 'required',
                'open_id' => 'required',
                "password"=>'required|min:6'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $validated = $validateUser->validated();
            $map = [];
            $map['type']=$validated['type'];
            $map['open_id'] = $validated['open_id'];
            $user = User::where($map)->first();

            if(empty($user->id)){
                $validated['token'] = md5(uniqid().rand(10000, 99999));
                $validated['created_at']=Carbon::now();
               // $validated['password'] = Hash::make($validated);
                $userID = User::insertGetId($validated);
                $userInfo = User::where('id', '=', $userID)->first();
                $accessToken = $userInfo->createToken(uniqid())->plainTextToken;
                $userInfo->access_token = $accessToken;
                User::where('id', '=', $userID)->update(['access_token'=>$accessToken]);

                return response()->json([
                    'code' => 200,
                    'msg' => 'User Created Successfully',
                    'data' => $userInfo
                ], 200);

            }
            $accessToken = $user->createToken(uniqid())->plainTextToken;
            $user->access_token = $accessToken;
            User::where('open_id', '=', $validated['open_id'])->update(['access_token'=>$accessToken]);
            return response()->json([
                'code' => 200,
                'msg' => 'User logged in Successfully',
                'data' => $user
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
