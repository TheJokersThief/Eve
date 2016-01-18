<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use Redirect;

class UserController extends Controller
{

    /**
     * Creates a new user.
     * This is a generic user.store function adapted from a previous project
     * and should definitely be brought up to date with this project /
     * adapted so that we can use Laravel Socialite with it.
     *
     * 
     * 	Data should be POSTed to this function only
     * @return REDIRECT home
     */
    public function store( ){
    	// Only allow following fields to be submitted
        $data = Request::only( [
                    'name',
                    'password',
                    'password_confirmation',
                    'email'
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
            return Redirect::back( )
                    ->withErrors( $validator )
                    ->withInput( );
        }

        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        // Create the new user
        $newUser = User::create( $data );
        if( $newUser ){
            Auth::login($newUser);
        	// If successful, go to home
        	return Redirect::route( 'home' );
        }
        
        // If unsuccessful, return with errors
        return Redirect::back( )
                    ->withErrors( [
                    	'message' => 'We\'re sorry but registration failed, please try again later.' 
                    ] )
                    ->withInput( );
    }
}
