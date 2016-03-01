<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partner;
use App\Location;
use App\Event;
use Redirect;
use DB;
use LocationController;

use Crypt;
use Validator;
use Auth;

class PartnersController extends Controller
{
	private $errorMessages = [
		'incorrect_permissions' => 'You do not have permission to edit partners.',
		'partner_creation_failed' => 'We\'re sorry but partner creation failed, please try again later.',
		'incorrect_permissions_partners' => 'You do not have permission to edit partners',
	];

	public function index(){
		$partners = Partner::orderBy('id', 'ASC')->get();
		return view('partners.index', ['partners' => $partners]);
	}

	public function show($id){
		$partner = Partner::findOrFail($id);
		return view('partners.show', compact('partner'));
	}

	public function create(){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		return view('partners.create', ['locations' => Location::all(), 'events' => Event::all()]);
	}

	public function store(Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only( [
					'name',
					'picture',
					'type',
					'price',
					'description',
					'location_id',
					'event_id',
					'email',
					'logo',
					'url'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'name' => 'required',
					'picture' => 'required|image',
					'type' => 'required',
					'price' => 'required',
					'description' => 'required',
					'location_id' => 'required',
					'event_id'	=> 'required',
					'email' => 'required',
					'logo' => 'required|image',
					'url' => 'required'
				]);

		if( $validator->fails( ) ){
			// If validation fails, redirect back to
			// registration form with errors
			return Redirect::to( 'partners/create' )
					->withErrors( $validator )
					->withInput( );
		}

		if( $request->hasFile('picture' ) ){
			$data['picture'] = MediaController::uploadImage(
											$request->file('picture'),
											time(),
											$directory = "partner_photos",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		}


		if( $request->hasFile('logo' ) ){
			$data['logo'] = MediaController::uploadImage(
											$request->file('logo'),
											time(),
											$directory = "partner_logos"
										);
		}

		$newData = array(
				"name" => $data["name"],
				"description" => $data["description"],
				"type" => $data["type"],
				"price" => $data["price"],
				"location_id" => $data["location_id"],
				"email" => $data["email"],
				"featured_image" => $data["picture"],
				"url" => $data["url"],
				"logo" => $data["logo"]
			);

		// Create the new partner
		$newPartner = Partner::create( $newData );

		if( $newPartner ){
			// Attach events to model
			$distance;
			foreach($data['event_id'] as $event_id){
				$distance = getMapsMatrixDistance(Event::find($event_id)->location, $newPartner->location);
				$newPartner->events()->attach($event_id, ['distance' => $distance]);
			}
			return Redirect::to( 'partners' );
		}

		// If unsuccessful, return with errors
		return Redirect::back( )
					->withErrors( [
						'message' => $this->errorMessages['partner_creation_failed']
					] )
					->withInput( );
	}

	public function edit($partnerID){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$partner = Partner::where('id', $partnerID)
						->firstOrFail();
		return view('partners.edit', ['partner'=>$partner], ['locations' => Location::all()] );
		//return view('partners.edit')->with(['partner'=>$partner]);
	}

	public function update( $partnerID, Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only([
				'name',
				'type',
				'price',
				'location_id',
				'description',
				'email',
				'featured_image'
			]);

		// Validate all input
		$validator = Validator::make( $data, ['featured_image' => 'image|sometimes']);

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
											$directory = "partner_images",
											$bestFit = true,
											$fitDimensions = [1920, 1080]
										);
		} else{
			unset( $data['featured_image'] );
		}

		$partner = Partner::find($partnerID);
		$partner->update( $data );

		$partner->events()->detach();

		$distance;
		foreach($data['event_id'] as $event_id){
			$distance = getMapsMatrixDistance(Event::find($event_id)->location, $partner->location);
			$partner->events()->attach($event_id, ['distance' => $distance]);
		}

		return Redirect::route('partners.edit', [$partner->id]);
	}

	/**
	 * @param  int 		$encryptedPartnerId	The encrypted value of the Partner ID to be destroyed
	 * @return Redirect 	Back to the previous page
	 */
	public function destroy( $encryptedPartnerID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response( view('errors.403', ['error' => $this->errorMessages['incorrect_permissions_partners']]), 403 );
		}
		$partnerID = Crypt::decrypt($encryptedPartnerID);
		DB::delete('delete from event_partners where partner_id = ?', [$partnerID]);
		Partner::destroy($partnerID);
		return Redirect::route('partners.index');
	}

	public function addSuggestedPartner( $encryptedPlaceID ){
		//decrypt place id
		$placeID = Crypt::decrypt($encryptedPlaceID);

		//Find from google places
		$result = file_get_contents('https://maps.googleapis.com/maps/api/place/details/json?placeid='
									. $placeID
									. '&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o');

		//store the location (call location.createLocationForPlace( $longitude, $latitude, $title ))

		$result = json_decode($result, true);
		$longitude = $result['result']['geometry']['location']['lng'];
		$latitude = $result['result']['geometry']['location']['lat'];
		$title = $result['result']['name'];

		$locationID = LocationController::createLocationForPlace( $longitude, $latitude, $title );

		//Create new partner in db
		$price = 0;
		if( isset($result['result']['price_level']) ){
			$price = 5 * $result['result']['price_level'];
		}

		//Create new photo?
		//https://maps.googleapis.com/maps/api/place/photo?photoreference=CmRcAAAAZw9XPwA2umHBbeRdWLRYE8LzOuqZ6fvLdMayjX6JDZ3NMH3YZ0GvSYX-ONy6m2-J-NG9C05OfZHQBMyJoiVSXEEyjoKsBauT23e8-S9REhdogQgP3MLfYRaRZPIpLr2iEhAoculQNM5RaF_9lTHoM5htGhS022Frq-fLwPlLIRbk_UaBLwS6QA&maxwidth=1600&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o
		//$photo = file_get_contents('https://maps.googleapis.com/maps/api/place/photo?photoreference='
		//							. $result['result']['photos']['photo_reference']
		//							. '&maxwidth=1600'
		//							. '&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o');
		//file_put_contents( URL::to('/').'partner_image'.$placeID, $photo); //plz help, @colm2

		$newData = array(
				"name" => $title,
				"description" => $title,
				"type" => $result['result']['types'][0],
				"price" => $price,
				"location_id" => $locationID,
				"email" => " ",
				"featured_image" => "",
				"url" => $result['result']['website'],
				"logo" => ""
			);

		// Create the new partner
		$newPartner = Partner::create( $newData );

		//associate partner with event
	}

	// Returns the argument in radians
	function rad( $x ){
		return $x * pi() / 180;
	}

	// Gets the distance as the crow flies between two points
	function getDistance($p1, $p2){
		$radius = 6378137;
		$dLat = rad($p2->latitude - $p1->latitude);
		$dLong = rad($p2->longitude - $p1->longitude);
		$a = sin($dLat/2) * sin($dLat/2) +
				cos(rad($p1->latitude)) * cos(rad($p2->latitude)) *
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
	function getMapsMatrixDistance($origin, $destination){

		//Try to get Distance from Google Distance Matrix API
		$response = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='
					. $origin->longitude . ',' . $origin->latitude
					. '&destinations='
					. $destination->longitude . ',' . $destination->latitude
					. '&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o');
					//TODO: Update key to be fetched dynamically from the .env
		$response = json_decode($response, true, 512, JSON_BIGINT_AS_STRING);

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
			return getDistance($origin, $destination);
		}

	}

}
