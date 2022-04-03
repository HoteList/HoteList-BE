<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Schema;

class ApiHotelController extends Controller
{
    public function getAllHotels() {
        $hotel = Hotel::all();
        return response($hotel, 200);
    }

    public function addHotel(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:hotels',
            'description' => 'required|string|max:255',
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
        $hotel = Hotel::where('id', $request->id)->first();
        if ($request->name === $hotel->name) {
            $hotel['description'] = $request['description'];
            $hotel['capacity'] = $request['capacity'];
            $hotel['lat'] = $request['lat'];
            $hotel['lot'] = $request['lot'];
            $hotel['image'] = $request['image'];
        } else {
            if (Hotel::where('name', $request->name)->first() != NULL) {
                $response['message'] = "name already exist";
                return response($response, 422);
            } else {
                $hotel['name'] = $request['name'];
                $hotel['description'] = $request['description'];
                $hotel['capacity'] = $request['capacity'];
                $hotel['lat'] = $request['lat'];
                $hotel['lot'] = $request['lot'];
                $hotel['image'] = $request['image'];
            }
        }
        $hotel->save();

        return response($hotel, 200);
    }

    public function getOneHotel(Request $request, $hotelid) {
        $hotel = Hotel::where('id', $hotelid)->first();
        return response($hotel, 200);
    }

    public function deleteHotel(Request $request) {
        Hotel::where('id', $request->id)->delete();

        return response('hotel deleted', 200);
    }
}