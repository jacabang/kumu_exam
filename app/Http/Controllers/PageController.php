<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User as User;

class PageController extends Controller
{
    //
    public function register(Request $request){

        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        if($validation->fails()){
            $error = $validation->messages()->first();
            return response()->json([
                'response' => false,
                'message' => $error
            ]);
        }

        $user = User::create([
            "name" =>$request->get('name'),
            "email" =>$request->get('email'),
            "password" => bcrypt($request->get('password')),
            ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'response' => true,
            'message' => "Logging in successful",
            'user' => $user,
            'access_token' => $accessToken
        ]); 
    }

    public function unauthorize(){
        return response()->json([
            'response' => false,
            'message' => 'Unauthorize Access'
        ]);
    }

    public function login(Request $request){

        $validation = Validator::make($request->all(), [
            'email'=>'required',
            'password' => 'required',
        ]);

        if($validation->fails()){
            $error = $validation->messages()->first();
            return response()->json([
                'response' => false,
                'message' => $error
            ]);
        }

        $credential = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($credential, 1)) {

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return response()->json([
                'response' => true,
                'message' => "Logging in successful",
                'user' => Auth::user(),
                'access_token' => $accessToken
            ]); 
        
        } else {
            return response()->json([
                'response' => false,
                'message' => "Wrong Access"
            ]);
        }
    }
}
