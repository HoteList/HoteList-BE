<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ApiHotelController extends Controller
{
    public function getAllHotels() {
        $hotel = Hotel::all();
        return response($hotel, 200);
    }

    public function addHotel(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:hotels',
            'description' => 'required|string',
            'capacity' => 'required|integer',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $hotel = Hotel::create($request->toArray());

        return response($hotel, 200);
    }

    public function updateHotel(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',Rule::unique('hotels')->ignore($request->id),
            'description' => 'required|string',
            'capacity' => 'required|integer',
            'image' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $hotel = Hotel::where('id', $request->id)->first();
        $hotel['name'] = $request['name'];
        $hotel['description'] = $request['description'];
        $hotel['capacity'] = $request['capacity'];
        $hotel['lat'] = $request['lat'] == NULL ? "" : $request['lat'];
        $hotel['lot'] = $request['lot'] == NULL ? "" : $request['lot'];
        $hotel['image'] = $request['image'];

        $hotel->save();

        return response($hotel, 200);
    }

    public function getOneHotel($hotelid) {
        $hotel = Hotel::where('id', $hotelid)->first();
        return response($hotel, 200);
    }

    public function deleteHotel(Request $request) {
        Hotel::where('id', $request->id)->delete();

        return response('hotel deleted', 200);
    }
}