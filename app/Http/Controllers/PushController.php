<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Events\UserNotification;


class PushController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'msg' => 'required|string',
        ]);


        event(new UserNotification($data['user_id'], [
            'msg' => $data['msg'],
            'time' => now()->toDateTimeString(),
        ]));


        return response()->json(['status' => 'ok']);
    }

}
