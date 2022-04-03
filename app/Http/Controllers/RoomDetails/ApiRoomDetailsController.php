<?php

namespace App\Http\Controllers\RoomDetails;

use App\Http\Controllers\Controller;
use App\Models\RoomDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiRoomDetailsController extends Controller
{
    public function getAllRoomsByHotelId(Request $request,$hotelId){
        $rooms = RoomDetails::where('hotel_id',$hotelId)->get();

        return response($rooms, 200);
    }

    public function addRoomDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'hotel_id' => 'required|exists:hotels,id', 
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $roomDetails = RoomDetails::create($request->toArray());

        return response($roomDetails,200);
    }

    public function updateRoomDetails(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:room_details,id',
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'hotel_id' => 'required|exists:hotels,id',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $roomDetails = RoomDetails::where('id', $request->id)->first();

        $roomDetails['name']=$request['name'];
        $roomDetails['price']=$request['price'];
        $roomDetails['description']=$request['description'];
        $roomDetails['image']=$request['image'];

        $roomDetails->save();

        return response($roomDetails, 200);
    }

    public function deleteRoomDetails(Request $request) {
        RoomDetails::where('id', $request->id)->delete();

        return response('room details deleted', 200);
    }
}
