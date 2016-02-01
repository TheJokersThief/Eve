<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Hash;
use Response;
use App\User;
use App\Ticket;
use App\Setting;

use App\Http\Controllers\MediaController;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{

    /**
     * Log out a user
     * @return REDIRECT login
     */
    public function logout( ){
        Auth::logout();
        return Redirect::back();
    }

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

        $newUser = createUser( $data );

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

    /**
     * Creates a new user
     * @param  array  $userInfo User's data
     * @return User             The newly created User object
     */
    public static function createUser( $userInfo ){
        // Hash the password
        $userInfo['password'] = Hash::make($userInfo['password']);
        
        // Create the new user
        $newUser = User::create( $userInfo );

        return $newUser;
    }

    /**
     * Updates a user's account info
     * @param  int    $userID   The ID of the user we want to update
     * @param  array  $userInfo The data to be added/updated
     * @return User             User object we just updated
     */
    public static function updateUser( $userID, $userInfo ){
        if(! Auth::check() || ! (Auth::user()->id == $userID || Auth::user()->is_admin) ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit users.']), 403);
        }


        if( isset( $userInfo['password'] ) ){
            // If the password's being updated, we need to hash it
            $userInfo['password'] = Hash::make( $userInfo['password'] );
        }

        $ignoredFields = ['password_confirmation'];

        $user = User::find( $userID );
        foreach ($userInfo as $key => $value) {
            if( !in_array($key, $ignoredFields) ){
                $user->$key = $value;
            }
        }
        $user->save();
        return $user;
    }

    /**
     * Uploads and crops user profile picture
     * @param  File    $image   File from form request
     * @return string           URL-friendly path to image
     */
    public static function uploadProfilePicture( $image, $email ){
        return MediaController::uploadImage( 
                    $image,
                    $email,
                    $directory = "uploads",
                    $bestFit = true,
                    $fitDimensions = [500, 500] 
                );
    }

    /**
     * Debug function: returns details on the currently logged in user
     * @return String:  JSON description of user or "false"
     */
    public function me(){
        return Auth::check() ? Auth::user() : "false";
    }

    /**
     *   Test function for updating user information
     */
    public function updateUserInfo(){
        $data = Request::only([
                'name',
               'email',
                'bio',
                'password'
        ]);
        $validator = Validator::make($data, [
                'name' =>  'required|unique:users|min:5|alpha_num',
               'email' => 'required',
                'bio' => 'required|max:100',
                'password' => 'required|confirmed|min:5'
        ]);
        if( $validator->fails( ) ){
            // If validation fails, redirect back to 
            // registration form with errors
            return Redirect::back( )
                    ->withErrors( $validator )
                    ->withInput( );
        }
        $update = User::update($data);
    }

    /**
     *   Returns the users personal page where they can update their info
     */
    public function index(){
        $me = Auth::user();
        return view('user.index', compact('me'));
    }

    /**
     *   Returns a users myEvents view
     */
    public function myEvents(){
        $me = Auth::user();
        return view('user.myEvents', compact('me'));
    }

    /**
     *   Returns the users pastEvents view
     */
    public function pastEvents(){
        $me = Auth::user();
        return view('user.pastEvents', compact('me'));

    }

}
