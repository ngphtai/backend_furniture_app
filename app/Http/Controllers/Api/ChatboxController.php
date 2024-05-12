<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ChatRooms;
use Illuminate\Http\Request;

class ChatboxController extends Controller
{
     public function index(){
        $info = ChatRooms::whereHas('messenger')->with('lastMessenger.user')->latest('updated_at')->get();
        return view('page.chatbox', compact('info'));
     }
}
