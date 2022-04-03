<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiUserController extends Controller
{
    //
    public function getAllUsers() {
        $user = User::all();
        return response($user, 200);
    }

    public function updateUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:users,id',
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',Rule::unique('users')->ignore($request->id),
            'email' => 'required','string','email','max:255',Rule::unique('users')->ignore($request->id),
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('id', $request->id)->first();

        $user['full_name']=$request['full_name'];
        $user['username']=$request['username'];
        $user['email']=$request['email'];
        $user['image']=$request['image'] == NULL ? "" : $request['image'];

        $user->save();

        return response($user, 200);
    }
}
