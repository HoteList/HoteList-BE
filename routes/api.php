<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\Hotel\ApiHotelController;
use App\Http\Controllers\RoomDetails\ApiRoomDetailsController;
use App\Http\Controllers\Transaction\ApiTransactionController;
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

Route::get('/',function(){
    return response()->json('Helo..');
});


Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login',[ApiAuthController::class, 'login']);
    Route::post('/register',[ApiAuthController::class, 'register']);
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:sanctum']], function () {

    // Route::middleware('auth:sanctum')->get('/auth/user', function (Request $request) {
    //     return auth()->user();
    // });

    Route::get('/auth/user', function (Request $request) {
        return auth()->user();
    });

    // Get all rooms by hotel id
    Route::get('/roomDetails/hotel/{hotelid}',[ApiRoomDetailsController::class, 'getAllRoomsByHotelId']);
    
    // get one room by id
    Route::get('/roomDetails/{id}',[ApiRoomDetailsController::class, 'getOneRoomById']);
    
    // Get All Hotels
    Route::get('/hotel', [ApiHotelController::class, 'getAllHotels']);
    
    // Get Hotel By ID 
    Route::get('/hotel/{hotelid}', [ApiHotelController::class, 'getOneHotel']);

    // Get Transaction by ID
    Route::get('/transaction/id/{id}', [ApiTransactionController::class, 'getTransactionById']);

    // Get Transaction by User ID
    Route::get('/transaction/user', [ApiTransactionController::class, 'getTransactionsByUserId']);

    // Get Transaction By RoomID at Date
    Route::get('/transaction/room/{room_id}/time/{time}', [ApiTransactionController::class, 'getTransactionsByRoomIdAtTime']);

    // Get Transaction By Room ID
    Route::get('/transaction/room/{room_id}',[ApiTransactionController::class, 'getTransactionsByRoomId']);

    // Post Transaction
    Route::post('/transaction', [ApiTransactionController::class, 'addTransaction']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::get('/user',[ApiUserController::class, 'getAllUsers']);
    Route::put('/user',[ApiUserController::class, 'updateUser']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::post('/hotel', [ApiHotelController::class, 'addHotel']);
    Route::put('/hotel', [ApiHotelController::class, 'updateHotel']);
    Route::delete('/hotel', [ApiHotelController::class, 'deleteHotel']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::post('/roomDetails',[ApiRoomDetailsController::class, 'addRoomDetails']);
    Route::put('/roomDetails',[ApiRoomDetailsController::class, 'updateRoomDetails']);
    Route::delete('/roomDetails',[ApiRoomDetailsController::class, 'deleteRoomDetails']);
});

Route::group(['middleware' => ['auth:sanctum', 'is_admin', 'cors', 'json.response']], function () {
    Route::get('/transaction',[ApiTransactionController::class, 'getAllTransactions']);
    Route::get('/transaction/admin/{hotel_id}',[ApiTransactionController::class, 'getTransactionsByHotelId']);
    Route::put('/transaction',[ApiTransactionController::class, 'updateTransaction']);
    Route::delete('/transaction',[ApiTransactionController::class, 'deleteTransaction']);
});