<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    public function addNewUser(Request $request)
    {
        try {
            $this->validate($request, [
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required|email', // Added email validation
                'password' => 'required',
                'user_type' => 'required',
            ]);

            $currentUser = auth()->guard('ANNTStore')->user();

            if ($currentUser->user_type != 'Admin') {
                if ($request->user_type == 'Admin' || $request->user_type == 'Staff') {
                    toastr()->error("Tài khoản không có quyền thực hiện chức năng này!");
                    return redirect()->route('user.index');
                }
            }
            $user = new Users();
            $user->uid = $request->uid;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->user_type = $request->user_type;
            $user->avatar = 'storage/avatars/default.png';
            $user->save();

            toastr()->success('Thêm tài khoản thành công');
            return redirect()->route('users.index');

        } catch (\Exception $e) {
            toastr()->error('Thêm tài khoản thất bại: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 400);
        }
    }

    public function block(String $id){
        try{
            $user = Users::where('id',$id)->first();
            if($user -> is_lock == 0){
                $user -> is_lock = 1;
                $user -> save();
                toastr()-> success("Khoá tài khoản thành công");
                return redirect()->route('user.index');
            }else{
                $user -> is_lock = 0;
                $user -> save();
                toastr()-> success("Mở khoá tài khoản thành công");
                return redirect()->route('user.index');
            }
        }catch(\Exception $e){
            toastr()->error('Thao tác thất bại: ' . $e->getMessage());
            return response()->json(['message' => 'Error creating user', 'error' => $e->getMessage()], 400);
        }

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
                                <td>'.Str::limit($item->uid, 10, '...').'</td>
                                <td>'.$item -> name.'</td>
                                <td>';
                                if($item->avatar){
                                    $output.= ' <img class ="avatar" src="'. asset( $item->avatar) .'" alt="No Avatar">';
                                 }else{
                                    $output .= ' <span class ="avatar">No avatar</span>';
                                 };'</td>';
                                $output .='
                                <td>'.$item -> email.'</td>
                                <td>';
                                    if($item -> address == null )
                                        $output.='trống';
                                    else{
                                        $output.= Str::limit($item->address, 10, '').'<br>';
                                        if (strlen($item->address) > 10)
                                        $output.= Str::substr($item->address, 10);

                                    }
                                    ;'</td>';
                                $output .='
                                <td>';$output .=$item -> phone_number ?? "trống".'</td>
                                ';$output .= '<td>';$output .=$item -> user_type .'</td>
                                <td>';
                                    if($item -> is_lock == 0){
                                        $output .= '<span class="badge bg-success">Hoạt động</span>';
                                    }else{
                                        $output .= '<span class="badge bg-danger">Đã khoá</span>';
                                    }
                                    $output .= '</td>
                                <td>
                                    <div class="d-flex order-actions">';
                                    if($item->is_lock == 0){
                                        $output .= ' <a href="/users/block/'.$item -> id.'" class="ms-3 size_button_action" onclick="if (!window.confirm(\'Bạn có chắc chắn muốn  khoá tài khoản này?\')) return false;"><i class="bx bx-block"></i></a>';
                                    }else{
                                        $output .= ' <a href="/users/block/'.$item -> id.'" class="ms-3 size_button_action" onclick="if (!window.confirm(\'Bạn có chắc chắn muốn mở khoá tài khoản này?\')) return false;"><i class="bx bx-check"></i></a>';
                                    }
                                    '</td>
                            </tr>';
                        }

            }
            else{
                $output .='<div class="alert alert-danger">Không tìm thấy tài khoản nào</div>';
            }
            return $output;
        }

    }


    public function bam(Request $request){
        $pass =  bcrypt($request ->pass);
        return response()->json(['message' => 'User updated successfully', 'user' => $pass], 200);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'uid' => 'required',
                'name' => 'nullable',
                'file' => 'nullable| image| mimes:jpeg,png,jpg,gif,wepb',
                'address' => 'nullable',
                'phone_number' => 'nullable|min:10|max:10|regex:/^0[^0][0-9]{8}$/',
                'email' => 'nullable|email|unique:users,email,' . $request->uid . ',uid',
                // 'password' => 'nullable',
            ], [
                'phone_number.regex' => 'Số điện thoại không hợp lệ',
                'phone_number.min' => 'Số điện thoại không hợp lệ',
                'phone_number.max' => 'Số điện thoại không hợp lệ',
                'phone_number.required' => 'Số điện thoại không hợp lệ',
                'email.email' => 'Email không hợp lệ',
                'email.unique' => 'Email đã tồn tại',
                'file.image' => 'Avatar không hợp lệ',
            ]);

            $user = Users::where("uid", $request->uid)->first();
            if (!$user) {
                throw new \Exception('User not found');
            }

            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            // $user->password = $request->password;

            if ($request->file != null) {
                // Delete old avatar
                if ($user->avatar != 'storage/avatars/default.png') {
                    $oldAvatar = str_replace('storage/', '', $user->avatar);
                    Storage::disk('public')->delete($oldAvatar);
                }
                $filename = $user->uid . '.' . $request->file->getClientOriginalExtension();
                $path = $request->file->storeAs('avatars', $filename, 'public');
                $path = "storage/" . $path;
                $user->avatar = $path;
            }

            $user->save();

            toastr()->success('Cập nhật tài khoản thành công');
            return redirect()->route('admin.profile');
            // return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            toastr()->error('Cập nhật tài khoản thất bại: ' . $e->getMessage());
            return redirect()->route('admin.profile');
            // return response()->json(['error' => $e->getMessage()], 400);
        }
    }


}
