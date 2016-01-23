<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use App\User;
use App\Ticket;
use App\Setting;
use App\Location;
use Response;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
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
            $user = User::where('email', $data['email'] )->firstOrFail();
            $userExists = true;
            $passwordRequired = "";
        } catch (ModelNotFoundException $e) {
        	// Don't require password if user has filled out
            // information before
            $passwordRequired = "required|";
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
            $allUsers = User::all();
            if( !count($allUsers) == 1 ){
            	$allUsers->skip(1);
                foreach ($allUsers as $indivUser) {
                    $indivUser->delete();
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
	    return Response::json(['success']);
    }

    public static function getInstallUserInfo( ){
    	$user = User::first();

    	$fields = [
                    'company_name',
                    'description',
                    'company_logo'
                    ];

        foreach ($fields as $field) {
        	$setting = Setting::where('name', $field)->first();
        	$user->$field = $setting->setting;
        }


        return Response::json( $user->toArray() );
    }

    public static function createCompany( Request $request ){
        
        $fields = [
                    'company_name',
                    'description',
                    'company_logo',
                    'company_logo_white'
                    ];

        $data = $request->only($fields);

        // Validate all input
        $validator = Validator::make( $data, [
                    'company_name'  => 'required',
                    'description'   => 'required',
                    'company_logo'  => 'sometimes|image|max:10240' // Limit filesize to 10MB
                ]);

        if( $validator->fails( ) ){
        	// If validation fails, redirect back to 
        	// registration form with errors
            return Response::json(['errors' => $validator->errors()->all()]);
        }

        if ($request->hasFile('company_logo')){
        	$logo_path = MediaController::uploadLogo( $request->file('company_logo') );
            $data['company_logo'] = $logo_path["normal"];
            $data['company_logo_white'] = $logo_path["white"];
        } else {
        	$data['company_logo'] = Setting::where('name', 'company_logo')->first()->setting;
            $data['company_logo_white'] = Setting::where('name', 'company_logo_white')->first()->setting;
        }


        foreach ($fields as $field) {
        	if( isset( $data[$field] ) ){
        		$setting = Setting::where('name', $field)->first();
	        	$setting->setting = $data[$field];
	        	$setting->save();
        	}
        }

        // Mark software as installed
        $installed = Setting::where('name', 'is_installed')->first();
        $installed->setting = "yes";
        $installed->save();

        // Log the user in as the user created in the last step
        Auth::login( User::first() );

        return Response::json( ['success'] );
    }

    ///////////////////////
    /// CREATE LOCATION ///
    ///////////////////////

    public static function createLocation( Request $request ){
        $data = $request->only([
                    'name',
                    'coordinates',
                    'capacity'
                ]);

        $validator = Validator::make( $data, [
                    'name'  => 'required',
                    'coordinates'   => 'required',
                    'capacity'  => 'required|numeric'
                ]);

        if( $validator->fails( ) ){
            // If validation fails, return json array of errors 
            return Response::json(['errors' => $validator->errors()->all()]);
        }

        $location = Location::firstOrCreate($data);

        return Response::json( $location->toArray() );
    }

}
