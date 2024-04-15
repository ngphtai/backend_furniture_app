<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = ['uid','products'];

    protected $casts = [
        'products' => 'json',
    ];
    public function product()
    {
        return $this->belongsTo('App\Models\Products');
    }
}
