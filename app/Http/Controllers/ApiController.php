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

        try {
            User::where('email', $data['email'] )->firstOrFail();
            // Don't require password if user has filled out
            // information before
            $passwordRequired = "required|";

            $userExists = true;
        } catch (ModelNotFoundException $e) {
            $passwordRequired = "";
            $userExists = false;
        }

    	// Validate all input
        $validator = Validator::make( $data, [
                    'name'  => 'required',
                    'email'     => 'email|required',
                    'password'  => $passwordRequired.'confirmed|min:5',
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
        } elseif( !$userExists ) {
            // If they didn't upload a picture, set it to the default picture
            $data['profile_picture'] = Setting::where('name', 'default_profile_picture')->first()->setting;
        }

        if( $userExists ) {
            $allUsers = User::all()->skip(1);
            if( !empty($allUsers) ){
                foreach ($allUsers as $user) {
                    $user->delete();
                }
            }

            UserController::updateUser( $user->id, $data );
        } else {
            UserController::createUser( $data );
            // Make this first User staff and admin.
            $user = User::first();
            $user->is_admin = 1;
            $user->is_staff = 1;
            $user->save();
        }
        

	    return Response::json(['success' => 'YAY!']);
    }

    public static function getInstallUserInfo( ){
        return Response::json( User::first()->toArray() );
    }
}
