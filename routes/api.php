<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Hotel\ApiHotelController;
use App\Http\Controllers\RoomDetails\ApiRoomDetailsController;
use App\Http\Controllers\User\ApiUserController;

// use App\Http\Controllers\RoomDetails\ApiRoomDetailsController;

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

    // Get all rooms by hotel id
    Route::get('/roomDetails/{hotelid}',[ApiRoomDetailsController::class, 'getAllRoomsByHotelId']);
    
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::get('/user',[ApiUserController::class, 'getAllUsers']);
    Route::put('/user',[ApiUserController::class, 'updateUser']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::get('/getAllHotels', [ApiHotelController::class, 'getAllHotels']);
    Route::get('/getHotel/{hotelid}', [ApiHotelController::class, 'getOneHotel']);
    Route::post('/addHotel', [ApiHotelController::class, 'addHotel']);
    Route::put('/updateHotel', [ApiHotelController::class, 'updateHotel']);
    Route::delete('/deleteHotel', [ApiHotelController::class, 'deleteHotel']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::post('/roomDetails',[ApiRoomDetailsController::class, 'addRoomDetails']);
    Route::put('/roomDetails',[ApiRoomDetailsController::class, 'updateRoomDetails']);
    Route::delete('/roomDetails',[ApiRoomDetailsController::class, 'deleteRoomDetails']);
});