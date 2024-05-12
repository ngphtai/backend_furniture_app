<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ChatRooms;;
class Users extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'uid',
        'name',
        'email',
        'avatar',
        'password',
        'user_type',
        'address',
        'phone_number'
    ];
    protected $casts = [
        'adress' => 'object',
    ];
    public function chats() :HasMany
    {
        return $this->hasMany(ChatRooms::class, 'room_id', 'pin');
    }

}
