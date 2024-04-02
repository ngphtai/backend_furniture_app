<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Products;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['user_id', 'order_id', 'product_id', 'rating', 'content'];

    public function user()
    {
        return $this->belongsTo('App\Models\Users');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }

}
