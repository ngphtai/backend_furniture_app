<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRooms;
use Encore\Admin\Actions\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Js;

class ChatController extends Controller
{
    // get all chat rooms
    public function index(Request $request)
    {
        $rooms = ChatRooms::whereHas('messenger')->with('lastMessenger.user')->latest('updated_at')->get();
        return  $rooms;
    }

    //store chat room for user
    public function store(Request $request)
    {
       try{
        $request->validate([
            'uid' => 'required|string',
        ]);
        $existRoom = ChatRooms::where('uid', $request->uid)->first();
        if($existRoom == null){
            $room = ChatRooms::create([
            'uid' => $request->uid,
            'pin' => null,
            ]);
            $room->refresh()->load('lastMessenger.user');
            return response()->json(['message' => 'Room created successfully!', 'data' => $room], 201);
        } else {
            $existRoom->load('lastMessenger.user');
            return $existRoom-> load('lastMessenger.user');
        }

       }
       catch(\Exception $e){
           return response()->json(['error' => $e->getMessage()], 500);
       }
    }

    //get single chat room
    public function show(ChatRooms $rooms)
    {
        $rooms ->load('lastMessenger.user');
        return response()->json(['data' => $rooms], 200);
    }
}
