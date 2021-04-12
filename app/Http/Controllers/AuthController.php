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
	        $response = $http->post(config('service.passport.login_endpoint'), [
	            'form_params' => [
	                'grant_type' => 'password',
	                'client_id' => config('service.passport.client_id'),
	                'client_secret' => config('service.passport.client_secret'),
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