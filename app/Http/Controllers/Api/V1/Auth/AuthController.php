<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request){
        return User::create($request->all());
    }

    public function login(LoginUserRequest $request){

        if(!Auth::attempt($request->only(['email','password']))){
            return response()->json([
                'message' => 'Wrong email or password'
            ],401);
        }

        $user = User::query()->where('email',$request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'user' => [
                'ID:' => $user->id,
                'Name:' => $user->name,
                'Email:' => $user->email,
                'Token:' => $user->createToken("Token of the user with ID : {$user->id}")->plainTextToken
            ]
        ]);

    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'user' => [
                'message:' => 'You are logged out.'
            ]
        ]);
    }

}

