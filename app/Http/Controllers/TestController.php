<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon as Carbon;

class TestController extends Controller
{
    //

    public function __construct()
    {   
        // $this->middleware('auth');
    }

    public function fetchUser(){

        $redis = app()->make('redis');

        $user = Auth::user();

        $key = "key".Auth::user()->id;

        $check = $redis->get($key);

        $actual_start_at = Carbon::parse($user->last_request);
        $actual_end_at = Carbon::now();

        //compute if the last request is done less then 2 mins ago
        $last_request = $actual_end_at->diffInMinutes($actual_start_at, true);

        if($check == "" || $last_request >= 2):

            //Fetch User From Github
            $array = $this->fetchData();

            if($array['response'] != false):

                //store on redis
                $redis->set($key, json_encode($array['data']));

                //set last request
                $user->last_request = date("Y-m-d H:i:s");
                $user->save();

                return response()->json([
                    'response' => true,
                    'message' => $array['data']
                ]);

            else:

                return response()->json([
                    'response' => false,
                    'message' => $array['message']
                ]);

            endif;

        elseif(count(json_decode($check)) != 0):

            //fetch Data From Redis via Key + User id

            return response()->json([
                'response' => true,
                'message' => json_decode($check)
            ]);
            
        endif;

        
    }

    public function fetchData(){

        $url = 'https://api.github.com/users?per_page=1';

        $response = $this->myCurl($url);

        // return [
        //     'response' => false,
        //     'message' => "This is a test"
        // ];

        $data = [];
        //check if exceed limit

        if(!isset($response['messages'])):

            foreach($response as $result):

                //fetch user info

                $url = 'https://api.github.com/users/'.$result->login;
                $result1 = $this->myCurl($url);

                //check if exceed limit
                if(!isset($result1['messages'])):

                    //build user data

                    $data[] = array(
                        "name" => $result1['name'],
                        "login" => $result->login,
                        "company" => $result1['company'],
                        "no_followers" => $result1['followers'],
                        "no_repo" => $result1['public_repos'],
                        "avg_watch_per_repo" => number_format($result1['public_repos'] / $result1['followers'],4)
                    );

                else:

                   return array(
                        'response' => false,
                        'message' => $response['messages']
                   );

                endif;

            endforeach;

            $data = collect($data);

            //arrange data by name

            $sorted = $data->sortBy('name');

            $data = $sorted->values()->all();

        else:

            return array(
                'response' => false,
                'message' => $response['messages']
           );

        endif;

        return array(
            'response' => true,
            'data' => $data
       );
    }

    public function myCurl($url){

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Github API in CURL'
        ]);

        $response = curl_exec($curl);

        $array = json_decode($response);
        $response = collect($array);

        return $response;
    }

    public function logout(){
        $check = Auth::check();

        if($check){
            $tokens = Auth::user()->tokens;
            foreach($tokens as $out){
                $out->revoke();
            }
        }

        return response()->json([
            'response' => true,
            'message' => "Successfully Logged Out"
        ]);
    }
}
