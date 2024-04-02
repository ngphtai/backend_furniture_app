<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForbiddenKeywords extends Model
{
    use HasFactory;
    protected $table = 'forbidden_keywords';
    protected $fillable = ['keyword'];
}
