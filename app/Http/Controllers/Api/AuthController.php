<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
   
    public function resgister(Request $request)
    {
        $validatedData = $request->validate([
            'name'      =>  'required|max:55',
            'email'     =>  'email|required|unique:users',
            'password'  =>  'required|confirmed'
        ]);

        $validatedData['password']  = bycrypt($request->password);

        $user = User::create($validatedData);

        $acessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user,'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {

        $loginData = $request->validade([
            'email'         => 'email|required',
            'password'      => 'required'
        ]);

        if(auth()->attempt($loginData)){
            return response(['message'=>'Invalid Credentials']);
        }    

        $accessToken = $user->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(),'access_token' => $accessToken]);

    }

}
