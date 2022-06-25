<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\RoomDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiTransactionController extends Controller
{
    public function getAllTransactions(Request $request) {
        $transactions = Transaction::all();

        return response($transactions, 200);
    }

    public function getTransactionsByRoomIdAtTime(Request $request, $room_id, $time) {
        $transactions = DB::table('transactions')
                        ->select('id', 'room_id', 'book_date')
                        ->where([
                                ['room_id', '=', $room_id],
                                ['book_date', '=', $time],
                                ])
                        ->get();

        return response($transactions, 200);
    }

    public function getTransactionById(Request $request, $id) {
        $transaction = Transaction::where('id', $id)->first();

        return response($transaction, 200);
    }

    public function getTransactionsByUserId() {
        $transactions = Transaction::where('user_id', auth()->user()->id)->get();
        
        return response($transactions, 200);
    }

    public function getTransactionsByRoomId(Request $request, $room_id) {
        $transactions = DB::table('transactions')
        ->select('id', 'room_id', 'book_date')
        ->where([
                ['room_id', '=', $room_id],
                ])
        ->get();

        return response($transactions, 200);
    }

    public function addTransaction(Request $request) {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|integer|exists:room_details,id',
            'book_date' => 'required|date_format:Y/m/d',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['user_id'] = auth()->user()->id;

        $booked = DB::table('transactions')
                        ->select('id', 'room_id', 'book_date')
                        ->where([
                                ['room_id', '=', $request['room_id']],
                                ['book_date', '=', $request['book_date']],
                                ])
                        ->get();
        
        $totalRooms = RoomDetails::where('id', $request['room_id'])->first();

        if ($totalRooms['capacity'] <= count($booked)) 
            return response(["Errors" => "Room {$request['room_id']} at {$request['book_date']} is Full"], 422);
        
        $transactions = Transaction::create($request->toArray());
        
        return response($transactions, 200);
    }

    public function UpdateTransaction(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exist:transactions',
            'room_id' => 'required|integer|exists:room_details,id',
            'user_id' => 'required|integer|exists:users,id',
            'book_date' => 'required|date_format:Y/m/d',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $transactions = Transaction::where('id', $request['id'])
                        ->update([
                            'room_id' => $request['room_id'],
                            'user_id' => $request['user_id'],
                            'book_date' => $request['book_date']
                        ]);
        
        return response($transactions, 200);
    }

    public function deleteTransaction(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:transactions',
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $transaction = Transaction::where('id', $request['id'])->first();

        $response['transaction'] = $transaction;
        $response["message"] = "Transaction Deleted {$transaction['id']}";

        $transaction->delete();

        return response($response, 200);
    }
}
