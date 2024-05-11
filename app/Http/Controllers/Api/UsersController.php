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
        return view('page.admin_detail') ;
    }

    public function index(){
        $result['info'] = DB::table('users')->paginate(10);
        return view('page.Users', $result);
    }

    public function addNewUser(Request $request)
    {
        try {
            $this->validate($request, [
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required|email| unique:users,email',
                'password' => 'required',
                'user_type' => 'required',
            ],[
                'uid.required' => 'Vui lòng nhập mã nhân viên',
                'name.required' => 'Vui lòng nhập tên nhân viên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không hợp lệ',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'user_type.required' => 'Vui lòng chọn loại tài khoản',
                'email.unique' => 'Email đã tồn tại',
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
            return redirect()->route('user.index');

        } catch (\Exception $e) {
            toastr()->error('Thêm tài khoản thất bại: ' . $e->getMessage());
            return redirect()->route('user.index');
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
            return redirect()->route('user.index');
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
        $user = Users::where('uid', $request->uid)->first();
        $pass = password_hash($user->password, PASSWORD_DEFAULT);
        return response()->json(['message' => 'User updated successfully', 'user' => $pass], 200);
    }

    public function changePass(Request $request){
        $request->validate([
            'uid' => 'required',
            'oldPass' => 'required',
            'newPass' => 'required',
        ]);
        return "oldPass" + $request->oldPass +" + "+ "newPass" + $request->newPass;
        $user = Users::where('uid', $request->uid)->first();

        if (!password_verify($request->oldPass, $user->password)) {
            toastr()->error('Mật khẩu cũ không chính xác');
            return response()->json(['message' => 'Mật khẩu cũ không chính xác'], 400);
        }
        $user->password = bcrypt($request->newPass);
        $user->save();
        toastr()->success('Đổi mật khẩu thành công');
        return response()->json(['message' => 'Đổi mật khẩu thành công'], 200);

    }
    public function update(Request $request)
    {
        try {
            $request->validate([
                'uid' => 'required',
                'name' => 'required',
                'file' => 'nullable| image| mimes:jpeg,png,jpg,gif,wepb',
                'phone_number' => 'required|min:10|max:10|regex:/^0[^0][0-9]{8}$/',

                // 'password' => 'nullable',
            ], [
                'name.required' => 'Tên không được để trống',
                'phone_number.regex' => 'Số điện thoại không hợp lệ',
                'phone_number.min' => 'Số điện thoại phải có 10 số',
                'phone_number.max' => 'Số điện thoại phải có 10 số',
                'phone_number.required' => 'Số điện thoại không được để trống',
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
