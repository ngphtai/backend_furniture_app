<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['user_id','title','content','is_read','type'];
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\Models\Users','id','id');
    }

}
