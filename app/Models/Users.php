<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'uid',
        'name',
        'email',
        'avatar',
        'user_type',
        'address',
        'phone_number'
    ];
    protected $casts = [
        'adress' => 'object',
    ];
}