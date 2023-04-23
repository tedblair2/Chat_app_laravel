<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    function home()
    {
        return view('user.first');
    }
    function index()
    {
        $user = Auth::user();
        $users = User::all()->except(Auth::id());
        $user_id = Auth::id();
        $current_user = User::find($user_id);
        $current_user->status = "Active now";
        $current_user->save();
        return view('user.index', compact('user', 'users'));
    }
    function logout()
    {
        $user_id = Auth::id();
        $current_user = User::find($user_id);
        $current_user->status = "Offline";
        $current_user->save();
        Auth::logout();
        return redirect('/');
    }
    function get_all_users()
    {
        $userTxt = '';
        $user_id = Auth::id();
        $users = User::all()->except(Auth::id());
        foreach ($users as $user) {
            $other_id = $user->id;
            $last_msg = '';
            $latest_chat = Chat::where(function ($query) use ($user_id, $other_id) {
                $query->where('sender_id', '=', $user_id)->where('receiver_id', '=', $other_id);
            })->orWhere(function ($query) use ($user_id, $other_id) {
                $query->where('sender_id', '=', $other_id)->where('receiver_id', '=', $user_id);
            })->latest('id')->first();
            if (empty($latest_chat)) {
                $last_msg = 'No messages';
            } else if ($latest_chat->sender_id == $user_id) {
                $last_msg = "You:" . $latest_chat->message;
            } else {
                $last_msg = $latest_chat->message;
            }
            $userTxt .= '<div class="single" data-key="receiver_id" data-value="' . $user->id . '">
                    <img src="/profiles/' . $user->image . '" alt="">
                    <div class="names">
                        <h2>' . $user->name . '</h2>
                        <p>' . $last_msg . '</p>
                    </div>
                </div>';
        }
        return response()->json(['usertxt' => $userTxt]);
    }
    function search_user(Request $request)
    {
        $searchTxt = $request->search;
        $user_id = Auth::id();
        $userTxt = '';
        $users = User::where('name', 'like', '%' . $searchTxt . '%')->get()->except(Auth::id());
        foreach ($users as $user) {
            $other_id = $user->id;
            $last_msg = '';
            $latest_chat = Chat::where(function ($query) use ($user_id, $other_id) {
                $query->where('sender_id', '=', $user_id)->where('receiver_id', '=', $other_id);
            })->orWhere(function ($query) use ($user_id, $other_id) {
                $query->where('sender_id', '=', $other_id)->where('receiver_id', '=', $user_id);
            })->latest('id')->first();
            if (empty($latest_chat)) {
                $last_msg = 'No messages';
            } else if ($latest_chat->sender_id == $user_id) {
                $last_msg = "You:" . $latest_chat->message;
            } else {
                $last_msg = $latest_chat->message;
            }
            $userTxt .= '<div class="single" data-key="receiver_id" data-value="' . $user->id . '">
                    <img src="/profiles/' . $user->image . '" alt="">
                    <div class="names">
                        <h2>' . $user->name . '</h2>
                        <p>' . $last_msg . '</p>
                    </div>
                </div>';
        }
        if (empty($userTxt)) {
            return response()->json(['searchtxt' => 'No user found']);
        } else {
            return response()->json(['searchtxt' => $userTxt]);
        }
    }
}
