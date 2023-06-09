<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $data = ['some example data', 'some other data'];
    return view('vuetest', [
        'data' => $data
    ]);
});

/* API ROUTES */
Route::get(
    '/api/user/login',
    [App\Http\Controllers\UserController::class, 'login'
]);

// route group for authenticated users only
Route::group(['middleware' => ['auth.api']], function () {
    Route::get(
        '/api/user/logout',
        [App\Http\Controllers\UserController::class, 'logout']
    );

    Route::get(
        '/api/msg/add',
        [App\Http\Controllers\MessageController::class, 'add']
    );


});

