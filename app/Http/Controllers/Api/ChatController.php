<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRooms;
use Encore\Admin\Actions\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Js;
use App\Events\check;
use App\Models\InforUsers;
use Pusher\Pusher;
class ChatController extends Controller
{
    // get all chat rooms
    public function index(Request $request)
    {

        $rooms = ChatRooms::whereHas('messenger')->with('lastMessenger.user')->latest('updated_at')->get();

        foreach($rooms as $room){
            $room->pin = InforUsers::where('uid',$room->pin)->first();
        }
        return  $rooms;
    }

    // store chat room for user
    public function show(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
        ]);
        $existRoom = ChatRooms::where('uid', $request->uid)->first();
        $existRoom->load('lastMessenger.user');
         return $existRoom-> load('lastMessenger.user');
    }

    public function setPin(Request $request){
        $request->validate([
            'uid' => 'required|string',
            'pin' => 'required|string',
        ]);
        ChatRooms::where('uid', $request->uid)->update(['pin' => $request->pin]);

        return response()->json(['message' => 'Update success'], 200);
    }

}


