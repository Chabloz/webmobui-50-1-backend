<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function get(Request $request, Message $message)
    {
        $user = $request->user();
        $now = $user->last_activity_at ?? now();
        $user->last_activity_at = now();
        $user->save();
        return $message->getAllAfterTimestamp($now);
    }


    public function add(Request $request)
    {
        $msg = $request->input('msg');
        if (strlen($msg) < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message should contain at least 1 characters'
            ], 400);
        }

        $user = $request->user();
        $user->messages()->create(['msg' => $msg]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message added successfully',
        ]);
    }
}
