<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class MessageController extends Controller
{

    public function get(Request $request, Message $message) : Collection
    {
        $time = $request->session()->get('last_get_at');
        $messages = $message->getAllAfterTimestamp($time);
        if (count($messages) > 0) {
            $request->session()->put('last_get_at', $messages[count($messages) - 1]->created_at);
        }
        $user = $request->user();
        $user->last_activity_at = now();
        $user->save();
        return $messages;
    }


    public function add(Request $request) : JsonResponse
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
