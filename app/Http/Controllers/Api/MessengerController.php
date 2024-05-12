<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Messengers;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use App\Events\NewMessageSent;
use App\Models\ChatRooms;
use Flasher\Prime\Translation\Messages;

class MessengerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request -> validate([
            'room_id' => 'required|exists:chatrooms,uid',
            'page' => 'required|numeric',
            'page_size' => 'nullable|numeric'
        ]);

        $messenger = Messengers::where('room_id', $request->room_id)
            ->with('user')
            ->latest('created_at')
            ->simplePaginate($request->page_size ?? 20, ['*'], 'page', $request->page);

        return response()->json(['data' => $messenger->getCollection()], 200);

    }

    public function store(Request $request){
        $request -> validate([
            // check if room_id exists in chat_rooms table with uid is room_id
            'room_id' => 'required',
            'message' => 'required|string',
        ]);

        $existRoom = ChatRooms::where('uid', $request->room_id)->first();

        if($existRoom == null){
            $room = ChatRooms::create([
            'uid' => $request->room_id,
            'pin' => null,
            ]);
            // $room->refresh()->load('lastMessenger.user');
            // return response()->json(['message' => 'Room created successfully!', 'data' => $room], 201);
        } else {
            // $existRoom->load('lastMessenger.user');
            // return response()->json([ 'data' => $existRoom-> load('lastMessenger.user')], 200);
        }

        $messenger = Messengers::create([
            'room_id' => $request->room_id,
            'message' => $request->message,
            'type'    => 'user',
        ]);
        return response()->json(['data' => $messenger], 200);
        $messenger -> load('user');

        //TODO send notification event to pusher and send notification to onesingal services

        $this -> sendNotificationToOther($messenger);
        return response()->json(['messenger' => 'send messenger successfully','data' => $messenger], 200);
    }

    private function sendNotificationToOther(Messengers $message){
        $room_id = $message['room_id'];
        Broadcast(new NewMessageSent($message))->toOthers();
    }

    public function storeWithAdmin(Request $request){
        $request -> validate([
            // check if room_id exists in chat_rooms table with uid is room_id
            'room_id' => 'required|exists:chatrooms,uid',
            'message' => 'required|string',
        ]);
        if(!ChatRooms::where('uid', $request->room_id)->exists()){
            return response()->json(['error' => 'Room not found'], 404);
        }
        $messenger = Messengers::create([
            'room_id' => $request->room_id,
            'message' => $request->message,
            'type'    => 'admin',
        ]);
        //TODO send notification event to pusher and send notification to onesingal services
        $this -> sendNotificationToOther($messenger);
        return  response()->json(['data' => $messenger], 200);
    }
}
