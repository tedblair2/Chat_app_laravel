<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    function get_messages(Request $request)
    {
        $user_id = Auth::id();
        $other_id = $request->id;
        $chatTxt = '';
        $chats = Chat::where(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', '=', $user_id)->where('receiver_id', '=', $other_id);
        })->orWhere(function ($query) use ($user_id, $other_id) {
            $query->where('sender_id', '=', $other_id)->where('receiver_id', '=', $user_id);
        })->get();
        foreach ($chats as $chat) {
            if ($chat->receiver_id == $other_id) {
                $chatTxt .= '<div class="sent">
                    <p>' . $chat->message . '</p>
                </div>';
            } else {
                $chatTxt .= '<div class="received">
                    <p>' . $chat->message . '</p>
                </div>';
            }
        }
        return response()->json(['chattxt' => $chatTxt]);
    }
    function set_session(Request $request)
    {
        $id = $request->input('data');
        $request->session()->put('receiver_id', $id);
        $user = User::find($id);
        $user_name = $user->name;
        $user_image = $user->image;
        $user_status = $user->status;
        return response()->json(['name' => $user_name, 'image' => $user_image, 'status' => $user_status]);
    }
    function send_message(Request $request)
    {
        $receiver_id = $request->session()->get('receiver_id');
        $sender_id = Auth::id();
        $chat = new Chat;
        $chat->sender_id = $sender_id;
        $chat->receiver_id = $receiver_id;
        $chat->message = $request->message;
        $chat->save();
        return response()->json(['msg' => 'message sent successfully']);
    }
}
