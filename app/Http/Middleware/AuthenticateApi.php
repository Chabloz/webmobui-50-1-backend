<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateApi extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        header('Content-Type: application/json');
        http_response_code(401);
        die(json_encode([
            'status' => 'error',
            'message' => 'Unauthenticated'
        ]));
    }
}
