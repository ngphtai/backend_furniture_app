<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Colors;
use App\Models\Products;

class ColorsController extends Controller
{

    public function edit(Request $request){
        $color = Colors::where('id', $request->id)->first();
        return response()->json($color);
    }

    public function add(Request $request)
    {

            $request->validate(
                [
                    'id' => 'nullable|integer',
                    'color_name' => [
                        'required',
                        'unique:colors,color_name',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^[0-9A-Fa-f]{6}$/', $value)) {
                                $fail('Mã màu không hợp lệ');
                            }
                        }
                    ]
                    ],[
                        'color_name.required' => 'Vui lòng nhập mã màu',
                        'color_name.unique' => 'Mã màu đã tồn tại',
                        'color_name.regex' => 'Mã màu không hợp lệ',
                    ]
            );

            $color = Colors::where('id', $request->id)->first();
            if(!is_null($color) ){
                $color->color_name = $request->color_name;
                $color->save();
                session()->flash('success', 'Chỉnh sửa màu thành công');
                return redirect() -> route('product.index');
            }else {
                $color = new Colors();
                $color->id = $request->id;
                $color->color_name = $request->color_name;
                $color->save();
            }

            session()->flash('success', 'Thêm màu thành công');
            return redirect() -> route('product.index');
            // return response()->json(['success' => 'Thêm màu thành công']);

    }


}
