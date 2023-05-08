<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $name = $request->input('name');
        // check if the name has only alphabets
        if (!ctype_alpha($name) || strlen($name) < 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Name should contain only alphabets'
            ], 400);
        }
        // other checks todo

        // Automatically create a user if no account exists
        $user = User::firstOrCreate([
            'name' => $name,
            'password' => '',
        ]);

        Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
