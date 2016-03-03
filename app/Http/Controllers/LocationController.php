<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;

use App\Location;
use App\Setting;
use Redirect;
use Auth;
use Validator;
use Crypt;
use DB;

class LocationController extends Controller
{
	private $errorMessages = [
		'incorrect_permissions' => 'You do not have permission to edit locations.',
		'incorrect_permissions_news' => 'You do not have permission to edit news.',
	];

	public function index(){
		$locations = Location::orderBy('id', 'ASC')->paginate(15);
		return view('locations.index', ['locations' => $locations]);
	}

	public function create(){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		return view('locations.create');
	}

	/**
	 * Create a news item
	 * @param  Request $request
	 * @return REDIRECT         A view of the post
	 */
	public function store( Request $request ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only( [
					'name',
					'latitude',
					'longitude',
					'capacity',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'latitude' => 'required',
					'longitude' => 'required',
					'capacity' => 'required|numeric',
					'featured_image' => 'image|sometimes'
				]);

		if( $validator->fails( ) ){
			// If validation fails, redirect back to
			// registration form with errors
			return Redirect::back( )
					->withErrors( $validator )
					->withInput( );
		}

		if( $request->hasFile('featured_image') ){
			$data['featured_image'] = MediaController::uploadImage(
											$request->file('featured_image'),
											time(),
											$directory = "location_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else {
			unset($data['featured_image']);
		}

		$location = Location::create($data);

		return Redirect::route('locations.edit', ['id' => $location->id]);
	}

	public function edit( $locationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions_news']]), 403);
		}
		$item = Location::find($locationID);

		// If no featured image, put in our default image
		$item->featured_image = ($item->featured_image == '')
									? Setting::where('name', 'default_profile_picture')->first()->setting
									: $item->featured_image;

		return view('locations.edit')->with( 'item', $item );
	}

	public function update( Request $request, $locationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only( [
					'name',
					'latitude',
					'longitude',
					'capacity',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'latitude' => 'required',
					'longitude' => 'required',
					'capacity' => 'required',
					'featured_image' => 'image|sometimes'
				]);

		if( $validator->fails( ) ){
			// If validation fails, redirect back to
			// registration form with errors
			return Redirect::back( )
					->withErrors( $validator )
					->withInput( );
		}

		if( $request->hasFile('featured_image') ){
			$data['featured_image'] = MediaController::uploadImage(
											$request->file('featured_image'),
											time(),
											$directory = "news_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else{
			unset( $data['featured_image'] );
		}

		$location = Location::find($locationID);
		$location->update( $data );

		return Redirect::route('locations.edit', [$location->id]);
	}

	public function destroy( $encryptedLocationID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}
		$locationID = Crypt::decrypt($encryptedLocationID);
		Location::destroy($locationID);
		return Redirect::back();
	}

	/**
	 * This function helps create a location for a venue when it's added via suggested partners
	 * as supplied by Google Places API
	 * @param  string $longitude	The longitude provided by the Google Places API
	 * @param  string $latitude		The latitude provided by the Google Places API
	 * @param  string $title		The title of the venue from the Google Place API
	 * @return int					The id of the newly created location
	 */
	public function createLocationForPlace( $longitude, $latitude, $title ){
		//Capacity isn't specified by Google Places so I default it to zero
		//Given that these are places like restaurants etc. it doesn't really matter
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$location = Location::create([ 'name' => $title,
										'latitude' => $latitude,
										'longitude' => $longitude,
										'capacity' => 0 ]);
		return $location->id;
	}

	public static function rad( $x ){
		return $x * pi() / 180;
	}

	public static function getDistance($p1, $p2){
		$radius = 6378137;
		$dLat =  LocationController::rad($p2->latitude - $p1->latitude);
		$dLong =  LocationController::rad($p2->longitude - $p1->longitude);
		$a = sin($dLat/2) * sin($dLat/2) +
				cos( LocationController::rad($p1->latitude)) * cos( LocationController::rad($p2->latitude)) *
				sin($dLong / 2) * sin($dLong / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		$d = $radius * $c;
		return $d;
	}

	/**
	 * Calculates the distance to travel from origin to destination using thier respective co-ordinates.
	 * This function makes use of the Google Maps Distance Matrix API and requires a valid Server API key.
	 *
	 * @param  App\Location $origin			The origin, for this project it should be the co-ordinates of the event
	 * @param  App\Location $destination	The destination, as above
	 * @return int              			The distance returned by the Google Maps Distance Matrix API
	 */
	public static function getMapsMatrixDistance($origin, $destination){

		//Try to get Distance from Google Distance Matrix API
		$response = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='
					. $origin->longitude . ',' . $origin->latitude
					. '&destinations='
					. $destination->longitude . ',' . $destination->latitude
					. '&key=' . env('GOOGLE_API_KEY'));

		$response = json_decode($response, true, 512);

		//WOO Debug code! Documenting my approach tbh
		//If we're all cool with the functional code, I'll get rid of these comments
		//
		//	var_dump($response);
		//	var_dump($response["rows"][0]["elements"][0]["distance"]["value"]);
		//echo ($response["rows"][0]["elements"][0]["distance"]["value"] == '' ? 'empty' : 'not empty');
		//if( isset($response["rows"][0]["elements"][0]["distance"]["value"]) ){echo 'not empty';} else {echo 'empty';}

		//If response contains zero results call getDistance instead
		//This will only happen (I think) when Google can't find a route between the two points
		//Or on an invalid request
		if( isset($response["rows"][0]["elements"][0]["distance"]["value"]) ){
			return $response["rows"][0]["elements"][0]["distance"]["value"];
		} else {
			return LocationController::getDistance($origin, $destination);
		}

	}

}
