<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Permissions\Abilities;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use ApiResponses;


    public function login(LoginUserRequest $request)  {
       
        $request->validated($request->all());
        //$request->validated(); //i think this work // just return the datas in rulse
       //if(!Auth::attempt($request->validated())){
       if(!Auth::attempt($request->only('email' , 'password'))){
            return $this->error('invalid ceridentials', 401);
       }

       $user = User::firstWhere('email' , $request->email);


       return $this->ok(
        'Authenticated',
        [
            'token' => $user->createToken(
                'Api token for '.$user->email,
                Abilities::getAbilities($user),//assign abilites to user when it wants token
                )->plainTextToken
        ]
       );
    }


    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();


        return $this->ok('');
    }















    
    // public function register() {
    //     return $this->ok('register');
    // }

}
