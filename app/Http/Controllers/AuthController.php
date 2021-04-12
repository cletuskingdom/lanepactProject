<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;

class AuthController extends Controller
{
	public function login(Request $req)
	{
		$http = new \GuzzleHttp\Client;
	    try {
	        $response = $http->post('http://127.0.0.1:8000/oauth/token', [
	            'form_params' => [
	                'grant_type' => 'password',
	                'client_id' => 2,
	                'client_secret' => 'vvKM1NahBNa5KLUjXMvpvzTwZ9Xb4EZh5TZvEx1p',
	                'username' => $req->username,
	                'password' => $req->password,
	            ]
	        ]);
	        return $response->getBody();
	    }catch (\GuzzleHttp\Exception\BadResponseException $e) {
	        if ($e->getCode() === 400) {
	            return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
	        } else if ($e->getCode() === 401) {
	            return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
	        }

	        return response()->json('Something went wrong on the server.', $e->getCode());
	    }
	}
}