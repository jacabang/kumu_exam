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

    public function hmd(Request $request){

        $validation = Validator::make($request->all(), [
            'data1'=>'required|integer',
            'data2'=>'required|integer'
        ]);

        if($validation->fails()){
            $error = $validation->messages()->first();
            return response()->json([
                'response' => false,
                'message' => $error
            ]);
        }

        $data1 = decbin($request->get('data1'));
        $data2 = decbin($request->get('data2'));

        $max_length = strlen($data1) + strlen($data2);

        $data1 = str_pad($data1, $max_length, "0", STR_PAD_LEFT);
        $data1_array = str_split($data1);

        $data2 = str_pad($data2, $max_length, "0", STR_PAD_LEFT);
        $data2_array = str_split($data2);

        $y = 0;

        for($x = 0; $x < $max_length; $x++):
            if($data1_array[$x] != $data2_array[$x]):
                $y++;
            endif;
        endfor;

        $data = array(
                "integer_bit1" => $data1,
                "integer_bit2" => $data2,
                "distance" => $y
                );

        return response()->json([
                'response' => true,
                'data' => $data
            ]);
    }
}
