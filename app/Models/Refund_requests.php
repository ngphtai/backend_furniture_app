<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund_requests extends Model
{
    use HasFactory;
    protected $table = 'refundrequests';
    protected $fillable = ['id  ','order_id', 'reason', 'status'];


}
