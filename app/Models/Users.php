<?php

namespace App\Models;

use App\Events\NewMessageSent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ChatRooms;
use Illuminate\Support\Facades\Broadcast;
use App\Notifications\MessageSent;
use Illuminate\Notifications\Notifiable; // Add this line

use Illuminate\Support\Facades\Log;
class Users extends Authenticatable
{
    use HasFactory;
    use Notifiable; // Add this line
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
    public function routeNotificationForOneSignal() : array{
        return ['tags'=>['key'=>'userId','relation'=>'=', 'value'=>(string)(1)]];
    }

    public function sendNewMessageNotification(array $data) : void {
        Log::debug("from model User: " . $data['messageData']['message']);
        $this->notify(new MessageSent($data));
    }

}
