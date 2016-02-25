<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use Auth;
use Image;
use Hash;
use View;
use Crypt;
use Response;
use App\User;
use App\Media;
use App\Ticket;
use App\Setting;
use App\Event;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MediaController extends Controller
{

	private static $errorMessages = [
		'no_permission' => 'You do not have permission to edit media.'
	];

	/**
	 * Render view with unapproved media for all events
	 * @return VIEW
	 */
	public function viewUnprocessedMedia( ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
		   return response(view('errors.403', ['error' => $this->errorMessages['no_permission']]), 403);
		}

		$media = Media::where('processed', false)->get()->chunk(6);
		return View::make('media.unprocessed')->with('media', $media);
	}

	/**
	 * View to allow users to upload photos to an event
	 * @param  Request $request
	 * @param  string  $encryptedEventID
	 * @return array The data necessary to pass to the view
	 */
	public static function uploadFiles( $encryptedEventID ){
		$data['eventID'] = Crypt::decrypt( $encryptedEventID );
		$data['event'] = Event::find( $data['eventID'] );

		if( Auth::check() ){
			$data['images'] = Auth::user()->media->where('event_id', $data['eventID'])->sortBy('id');
		}


		return $data;
	}

	/**
	 * View unprocessed images for a particular event
	 * @param  integer $eventID
	 * @return VIEW
	 */
	public function viewUnprocessedMediaForEvent( $eventID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
		   return response(view('errors.403', ['error' => $this->errorMessages['no_permission']]), 403);
		}

		$media = Media::where('event_id', $eventID)->where('processed', false)->get()->chunk(6);
		return View::make('media.unprocessed')->with('media', $media);
	}

	/**
	 * Approve a photo for the front page
	 * @param  integer $mediaID
	 * @param  boolean $isApproved
	 * @return VIEW
	 */
	public static function approveMedia( $mediaID, $isApproved ){
		$media = Media::find( $mediaID );
		$media->approved = $isApproved;
		$media->processed = true;
		$media->save();
	}

	/**
	 * Move an image from a user's browser to our server
	 * @param  Image  	$image
	 * @param  string  	$hashSeed
	 * @param  string  	$directory
	 * @param  boolean 	$bestFit
	 * @param  boolean 	$fitDimensions
	 * @return string  	URL to the image
	 */
	public static function uploadImage( $image, $hashSeed, $directory = "uploads", $bestFit = false, $fitDimensions = false ){
		// Get the file from the request
		$file = $image;

		$destination_path = storage_path() . '/'. $directory .'/';
		// Create a filename by hashing the user's username. This
		// will mean each user only has one profile picture residing
		// on our filesystem
		$file_name = hash('ripemd160', $hashSeed ) .'_picture.'. $file->getClientOriginalExtension();
		// Move the file to our server
		$movement = $image->move($destination_path, $file_name);

		// Perform an image intervention, getting best fit from image
		// and saving it again
		$image = Image::make( storage_path(). '/'. $directory .'/' . $file_name);
		if( $bestFit ){
			$image->fit( $fitDimensions[0], $fitDimensions[1] );
		}
		$image->save(storage_path(). '/'. $directory .'/' . $file_name);

		return (string) '/'. $directory .'/'. $file_name;
	}

	/**
	 * Upload a company logo during the installation process
	 * @param  Image $image
	 * @return string        The URLs for the normal and white versions of the logo
	 */
	public static function uploadLogo( $image ){
		// Get the file from the request
		$file = $image;
		$folder = '/company/';

		$destination_path = storage_path() . $folder;

		$file_name = 'company_logo.'. $file->getClientOriginalExtension();
		$file_name_white = 'company_logo_white.'. $file->getClientOriginalExtension();
		// Move the file to our server
		$movement = $image->move($destination_path, $file_name);

		MediaController::whiteOverlay( $destination_path . $file_name, $destination_path . $file_name_white );

		return [ "normal" => (string) $folder. $file_name, "white" => (string) $folder. $file_name_white ];
	}

	/**
	 * Completely fill the company logo with white
	 * @param  string $source
	 * @param  string $destination
	 */
	public static function whiteOverlay( $source, $destination ){
		$image = Image::make( $source );
		$image->colorize( 100, 100, 100 );
		$image->save( $destination );
	}
}
