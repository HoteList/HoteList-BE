<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/',function(){
    return response()->json('Helo..');
});


Route::group(['middleware' => ['cors', 'json.response']], function () {

    // Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/login',[ApiAuthController::class, 'login']);
    Route::post('/register',[ApiAuthController::class, 'register']);
    // Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

});
