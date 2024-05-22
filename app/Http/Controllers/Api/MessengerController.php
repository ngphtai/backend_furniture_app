<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Messengers;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use App\Events\NewMessageSent;
use App\Events\UpdateChatRoom;
use App\Models\ChatRooms;
use Flasher\Prime\Translation\Messages;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Users;

class MessengerController extends Controller
{

    public function isRead(Request $request){
        $room = ChatRooms::where('uid', $request->uid)-> first();
        if($room->is_read ==0 ){
            DB::statement('UPDATE chatrooms SET is_read = 1 WHERE uid = ?', [$request->uid]);
        }
        return response()->json(['message' => 'Update success'], 200);
    }
    public function index2(Request $request)
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

        return  $messenger->getCollection();

    }




    //api
    public function index(Request $request)
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

    //send by client
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
            'uidsender'    => $request->room_id,
        ]);
        DB::statement('UPDATE chatrooms SET is_read = 0 WHERE uid = ?', [$request->room_id]);
        $messenger -> load('user');

        //TODO send notification event to pusher and send notification to onesingal services

        $this -> sendNotificationToOther($messenger);
        return response()->json(['messenger' => 'send messenger successfully','data' => $messenger], 200);
    }

    private function sendNotificationToOther(Messengers $message){

        $room_id = $message['room_id'];

        Log::debug($message);
        //new messenger
        Broadcast(new NewMessageSent($message))->toOthers();
         // update chat room
        Broadcast(new UpdateChatRoom( $message))->toOthers();
        Log::debug("sendNotificationToOther");
    }

    // private function sendToOneSignal(Messengers $data){
    //     //send to one signal uid user receiver
    //     $room_id = $data['room_id'];
    //     $uid = $room_id;
    //     $user = Users::where('uid', $uid)->first();
    //     Log::debug($user);
    //     $messenger = $data;
    //     //check data
    //     Log::debug('from OneSignal : ' .$messenger);
    //     $user->sendNewMessageNotification([
    //         'messageData'=>[
    //             'senderName'=>'supporter',
    //             'message'=>$messenger->message,
    //             'chatId'=>$messenger->room_id,
    //         ]
    //     ]);
    //     Log::debug("sendToOneSignal");
    // }
     //send by admin
    public function storeWithAdmin(Request $request){
        $request -> validate([
            // check if room_id exists in chat_rooms table with uid is room_id
            'room_id' => 'required',
            'message' => 'required|string',

        ]);
        if(!ChatRooms::where('uid', $request->room_id)->exists()){
            return response()->json(['error' => 'Room not found'], 404);
        }
        $messenger = Messengers::create([
            'room_id' => $request->room_id,
            'message' => $request->message,
            'uidreceiver'    => $request->room_id,
        ]);
        //TODO send notification event to pusher and send notification to onesingal services
        $this -> sendNotificationToOther($messenger);

        $messenger -> load('user');
        return  response()->json(['data' => $messenger], 200);


    }
}
