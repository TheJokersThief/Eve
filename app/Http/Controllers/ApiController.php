<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use App\User;
use App\Ticket;
use App\Setting;
use Response;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                    'password'  => 'required|confirmed|min:5',
                    'profile_picture' => 'sometimes|image|max:10240' // Limit filesize to 10MB
                ]);

        if( $validator->fails( ) ){
        	// If validation fails, redirect back to 
        	// registration form with errors
            return Response::json(['errors' => $validator->errors()->all()]);
        }

        // Image intervention ftw
        if ($request->hasFile('profile_picture')){
            $data['profile_picture'] =  UserController::uploadProfilePicture( 
                                            $request->file('profile_picture'),
                                            $data['email']
                                        );
        }

        try {
            $user = User::where('email', $data['email'] )->firstOrFail();
            UserController::updateUser( $user->id, $data );
        } catch (ModelNotFoundException $e) {
            UserController::createUser( $data );
        }
    	
	    //////////////////////////////////////////
	    // TO-DO: REGISTER THE USER AS AN ADMIN //
	    //////////////////////////////////////////
	    return Response::json(['success' => 'YAY!']);
    }
}
