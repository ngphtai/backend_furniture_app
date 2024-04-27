<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'total_price',
        'products',
        'address',
        'phone',
        'name',
        'type_payment',
        'status',
        'note',
        'is_done', //is_done = 0: chưa xác nhận , 1: đã xác nhận, 2: đã giao hàng, 3: giao thành công, 4 yêu caauf hoàn tiền, -1 huỷ hoá đơn
        'email',
    ];
    public function user()
    {
        return $this->belongsTo(Users::class);
    }


}
