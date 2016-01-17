<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;

use Validator;
use Response;

class ApiController extends Controller
{

	///////////////////////////////
	// INSTALL PROCESS ENDPOINTS //
	///////////////////////////////

    public static function installCreateUser( Request $request ){
    	$data = $request->only([
    				'email',
    				'name',
    				'password',
    				'password_confirmation',
    				'profile_picture'
		    	]);

    	// Validate all input
        $validator = Validator::make( $data, [
                    'name'  => 'required',
                    'email'     => 'email|required|unique:users',
                    'password'  => 'required|confirmed|min:5'
                ]);

        if( $validator->fails( ) ){
        	// If validation fails, redirect back to 
        	// registration form with errors
            return Response::json(['errors' => $validator->errors()->all()]);
        }
    	
	    //////////////////////////////////////////
	    // TO-DO: REGISTER THE USER AS AN ADMIN //
	    //////////////////////////////////////////
	    return Response::json(['success' => 'YAY!']);
    }
}
