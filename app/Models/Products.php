<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'category_id',
        'promotion_id',
        'rating_id',
        'rating_count',
        'product_image',
        'description',
        'quantity',
        'price',
        'sold',
        'is_show',
    ];


     // $casts là một mảng chứa các cặp key-value, key là tên cột trong database, value là kiểu dữ liệu mà chúng ta muốn chuyển đổi khi lấy dữ liệu từ database  ra
     protected $casts = [
        'product_image' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories');
    }
    public function promotion()
    {
        return $this->belongsTo('App\Models\Promotions');
    }

    // public function setFilenamesAttribute($value) // setFilenamesAttribute là hàm set giá trị cho thuộc tính product_image trong model để lưu vào database dưới dạng json
    // {
    //     $this->attributes['product_image'] = json_encode($value);
    // }
}
