<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    use HasFactory;

    protected $fillable = ['promotion_name', 'description', 'discount', 'start_date', 'end_date', 'is_show'];
}
