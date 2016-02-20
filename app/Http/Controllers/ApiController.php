<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Crypt;
use Hash;
use App\User;
use App\Ticket;
use App\Setting;
use App\Location;
use App\Media;
use Response;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiController extends Controller
{
	private $errorMessages = [
		'incorrect_permissions' => 'You do not have permission to edit this image',
		'not_an_image' => 'File isn\'t an image!',
		'no_file' => 'No file was received',
	];

	///////////////////////////////
	// INSTALL PROCESS ENDPOINTS //
	///////////////////////////////

	public static function installCreateUser( Request $request ){
		$data = $request->only([
					'email',
					'name',
					'password',
					'password_confirmation',
					'profile_picture',
					'username'
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
					'email'     => 'email|sometimes',
					'password'  => $passwordRequired.'confirmed|min:5',
					'profile_picture' => 'sometimes|image|max:10240', // Limit filesize to 10MB,
					'username' => 'alpha_num|required'
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
            'latitude',
			'longitude',
            'capacity',
            'featured_image'
        ]);

		$validator = Validator::make( $data, [
					'name'  => 'required',
					'latitude' => 'required',
					'longitude' => 'required',
					'capacity'  => 'required|numeric',
					'featured_image'  => 'image|sometimes'
				]);

		if( $validator->fails( ) ){
			// If validation fails, return json array of errors
			return Response::json(['errors' => $validator->errors()->all()]);
		}

		$location = Location::firstOrCreate($data);

		return Response::json( $location->toArray() );
	}

	///////////
	// MEDIA //
	///////////
	/**
	 * Handle API request to approve media for front page
	 * @param  Request $request
	 */
	public static function approveMedia( Request $request ){
		$data = $request->only([
					'encryptedID',
					'isApproved'
				]);

		$mediaID = Crypt::decrypt( $data["encryptedID"] );
		$isApproved = ( $data["isApproved"] == 'true' ? true : false );

		MediaController::approveMedia( $mediaID, $isApproved );
	}

	/**
	 * Process an API upload request for images
	 * @param  Request $request
	 * @param  string  $encryptedEventID
	 * @return JSON
	 */
	public function uploadMedia( Request $request, $encryptedEventID ){
		$eventID = Crypt::decrypt( $encryptedEventID );

		$data = $request->only(['file']);

		// Validate all input
		$validator = Validator::make( $data, [
					'file'  => 'image',
				]);

		// If validation fails;
		if( $validator->fails( ) ){
			// Redirect back to registration form with errors
			return Response::json(['error' => $this->errorMessages['not_an_image']]);
		}

		if( $request->hasFile('file') ){
			$file_location = MediaController::uploadImage(
								$request->file('file'),
								$data['file']->getClientOriginalName().time(), // Seed with time to ensure name is unique
								$directory = "event-photos/". hexdec( Hash::make( $eventID ) )
							);
			$media = Media::create([
				'file_location' => $file_location,
				'event_id' => $eventID,
				'name' => $data['file']->getClientOriginalName(),
				'user_id' => Auth::user()->id
			]);
			return Response::json(['file_location' => $file_location, 'media_id' => $media->id]);
		}
		return Response::json(['error' => $this->errorMessages['no_file']]);
	}

	/**
	 * Rename an image
	 * @param  Request $request
	 * @return JSON
	 */
	public function renameMedia( Request $request ){
		$data = $request->only(['mediaID', 'title']);
		$media = Media::find( $data['mediaID'] );

		if( Auth::user()->id == $media->user->id ){
			// Ensure the user owns the image
			$media->name = $data['title'];
			$media->save();
			return Response::json('success');
		} else {
			return Response::json(['error' => $this->errorMessages['incorrect_permissions']]);
		}
	}

	/**
	 * Delete an image from an event
	 * @param  Request $request
	 * @return JSON
	 */
	public function deleteMedia( Request $request ){
		$data = $request->only(['encryptedEventID', 'encryptedMediaID']);
		$eventID = Crypt::decrypt($data['encryptedEventID']);
		$mediaID = Crypt::decrypt($data['encryptedMediaID']);
		$media = Media::find( $mediaID );

		if( $media->event_id == $eventID
				&& $media->user_id == Auth::user()->id ){
			// Ensure 1) media belongs to relevant event
			// 2) The user owns that image
			$media->delete();
			return Response::json(['success']);
		}

		return Response::json(['error' => $this->errorMessages['no_permission']]);
	}
}
