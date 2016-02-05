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

use Illuminate\Http\Request;
use App\Http\Requests;
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
    public function updateUserInfo(Request $request, User $user){
        
        $data = $request->only([
                'name',
                'bio',
                'password',
                'profile_picture',
                'language',
                'city',
                'country'
        ]);
        $validator = Validator::make($data, [
                'name' =>  'required|min:3|alpha_num',
                'bio' => 'required',
                'password' => 'sometimes|min:5',
                'profile_picture' => 'sometimes',
                'language' => 'required',
                'city' => 'required',
                'country' => 'required'
        ]);

        if( $validator->fails( ) ){
        // If validation fails, redirect back to 
        // registration form with errors
        return Redirect::back( )
                ->withErrors( $validator )
                ->withInput( );
        }

        if($request->hasFile('profile_picture')){
            $data['profile_picture'] = MediaController::uploadImage(
                $request->file('profile_picture'),
                time(),
                $directory = "user",
                $bestFit = true,
                $fitDimensions = [500, 500]
            );
        }else{
            $data['profile_picture'] = Auth::user()->profile_picture;
        }
        
        if(isset($data['password'])){
            $data['password'] = Hash::make( $data['password'] );
        }else{
            $data['password'] = $user->password;
        }


        $update = $user->update($data);

        return Redirect::route('me');
    }

    public function index(){
        $me = Auth::user();
        return view('user.index', compact('me'));
    }

    public function userAccount($name){
        $me = User::where( 'name', $name )
                  ->firstorfail();
        return view('user.index', compact('me'));
    }

    /**
     *   Returns the users personal page where they can update their info
     */
    public function edit($name){
       if(! Auth::check() || ! (Auth::user()->name == $name || Auth::user()->is_admin) ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit users.']), 403);
        }
        $me = User::where( 'name', $name )
          ->firstorfail();
        return view('user.edit', compact('me'));
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
