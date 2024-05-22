<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Log;
class InforUsers extends Model
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
    public function routeNotificationForOneSignal() : array{
        return ['tags'=>['key'=>'userId','relation'=>'=', 'value'=>(string)(1)]];
    }

    public function sendNewMessageNotification(array $data) : void {
        Log::debug("from model User: " . $data['messageData']['message']);
        $this->notify(new MessageSent($data));
    }
}
