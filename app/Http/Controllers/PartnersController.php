<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partner;
use App\Location;
use Redirect;

use Crypt;
use Validator;
use Auth;

class PartnersController extends Controller
{
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
			return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
		}

		return view('partners.create', ['locations' => Location::all()]);
	}

	public function store(Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
		}

		$data = $request->only( [
					'name',
					'picture',
					'type',
					'price',
					'description',
					'location_id',
					'distance',
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
					'distance' => 'required',
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
				"distance" => $data["distance"],
				"email" => $data["email"],
				"featured_image" => $data["picture"],
				"url" => $data["url"],
				"logo" => $data["logo"]
			);

		// Create the new partner
		$newPartner = Partner::create( $newData );

		if( $newPartner ){
			return Redirect::to( 'partners' );
		}

		// If unsuccessful, return with errors
		return Redirect::back( )
					->withErrors( [
						'message' => 'We\'re sorry but partner creation failed, please try again later.'
					] )
					->withInput( );
	}

	public function edit($partnerID){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
		}

		$partner = Partner::where('id', $partnerID)
						->firstOrFail();
		return view('partners.edit', ['partner'=>$partner], ['locations' => Location::all()] );
		//return view('partners.edit')->with(['partner'=>$partner]);
	}

	public function update( $partnerID, Request $request){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
		}


		/*$data = $request->only( [
					'featured_image'
				]);*/
		//dd( $request );
		//$data = $request;

		$data = $request->only([
				'name',
				'type',
				'price',
				'location_id',
				'description',
				'distance',
				'email',
				'featured_image'
			]);

		// Validate all input
		$validator = Validator::make( $data, ['featured_image' => 'image|sometimes']);
		//dd($validator);

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



		return Redirect::route('partners.edit', [$partner->id]);
	}

	/**
	 * @param  int 		$encryptedPartnerId	The encrypted value of the Partner ID to be destroyed
	 * @return Redirect 	Back to the previous page
	 */
	public function destroy( $encryptedPartnerID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response( view('errors.403', ['error' => 'You do not have permission to edit partners']), 403 );
		}
		/*try {
		    $partnerID = Crypt::decrypt($encryptedPartnerID);
		} catch (Illuminate\Contracts\Encryption\DecryptException ) {
		    //
		}*/
		$partnerID = Crypt::decrypt($encryptedPartnerID);
		Partner::destroy($partnerID);
		return Redirect::route('partners.index');
	}
}
