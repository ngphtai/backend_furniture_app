<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatRooms extends Model
{
    use HasFactory;


    protected $table = 'chatrooms';
    protected $quarded = ['uid']; // không cho phép thay đổi giá trị của cột này
    protected $fillable = ['uid','pin'];
    // protected $primaryKey = 'uid';
    // thiếu quan hệ khoá ngoại với bảng messengers nên k thể dùng function này
        public function messenger() : HasMany
        {
            return $this->hasMany(Messengers::class, 'room_id', 'uid'); // 'room_id' là khóa ngoại của bảng messengers, 'id' là khóa chính của bảng chat_rooms
        }
    public function  lastMessenger() : HasOne
    {
        return $this->hasOne(Messengers::class, 'room_id', 'uid')->latest();
    }
    public function pin()
    {
        return $this->belongsTo(InforUsers::class, 'pin', 'uid');
    }
}
