<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request) : JsonResponse
    {
        $name = $request->input('name');
        // check if the name has only alphabets
        if (!ctype_alpha($name) || strlen($name) < 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Name should contain only alphabets'
            ], 400);
        }
        // other checks ?

        // Automatically create a user if no account exists
        $user = User::firstOrCreate([
            'name' => $name,
            'password' => '',
        ]);

        Auth::login($user);

        $user->last_activity_at = now();
        $user->save();

        $request->session()->put('last_get_at', $user->last_activity_at);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
        ]);
    }

    public function online(User $modelUser) : Collection
    {
        // Get all users who has made an action in the last 5 seconds
        $users = $modelUser->getActiveUserAfterTimestamp(now()->subSeconds(5));
        return $users;
    }

    public function logout() : JsonResponse
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }
}
