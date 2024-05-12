<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messengers extends Model
{
    use HasFactory;
    protected $table = 'messengers';
    protected $guarded = ['id'];
    protected $touches = ['ChatRoom']; // khi có sự thay đổi ở bảng messengers thì sẽ cập nhật updated_at ở bảng chatrooms

    public function user()
    {
        return $this->belongsTo(InforUsers::class, 'room_id', 'uid');
    }
    public function chatRoom()
    {
        return $this->belongsTo(ChatRooms::class, 'room_id', 'uid');
    }
}
