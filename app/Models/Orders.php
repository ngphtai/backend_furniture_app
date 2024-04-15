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
        'is_done',
        'email'
    ];
    public function user()
    {
        return $this->belongsTo(Users::class);
    }

}
