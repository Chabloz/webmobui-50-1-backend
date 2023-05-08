<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function add(Request $request)
    {
        $msg = $request->input('msg');
        // ??? todo check ???
        if (strlen($msg) < 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message should contain at least 2 characters'
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
