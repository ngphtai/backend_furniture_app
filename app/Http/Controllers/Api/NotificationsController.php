<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifications;

class NotificationsController extends Controller
{
    public function create(Request $request)
    {
        try{
            $request->validate([
                'user_id' => 'required',
                'title' => 'required',
                'content' => 'required',
                'is_read' => 'required | boolean',
                'type' => 'required'
            ]);
            $notifi = new Notifications();
            $notifi->user_id = $request->user_id;
            $notifi->title = $request->title;
            $notifi->content = $request->content;
            $notifi->is_read = $request->is_read;
            $notifi->type = $request->type;
            $notifi->save();
            return response()->json(['message' => 'Notification created successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'An error occurred while processing your request'], 500);
        }
    }


    public function show(Request $request)
    {
        try{
            $notifications = Notifications::where('user_id', $request-> uid)->orderBy('created_at', 'desc')->get();
            return response()->json(['data' => $notifications], 200);
        }catch(\Exception $e){
            return response()->json(['data' => 'An error occurred while processing your request'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request)
    {
        try{
            $notifi = Notifications::findOrFail($request ->id);
            $notifi->is_read = 1;
            $notifi->save();
            return response()->json(['message' => 'Notification updated successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'An error occurred while processing your request'], 500);
        }
    }
}
