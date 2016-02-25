<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;

use App\News;
use App\Setting;
use Redirect;
use Auth;
use Validator;
use Crypt;

class NewsController extends Controller
{
	private $errorMessages = [
		'incorrect_permissions' => _t('You do not have permission to edit news.')
	];

	public function index(){
		$news = News::orderBy('id', 'ASC')->get();
		return view('news.index', ['news' => $news]);
	}

	public function show($id){
		$news = News::findOrFail($id);
		return view('news.show')->with('news', $news);
	}

	public function create(){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		return view('news.create');
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
					'mce_0', // Title
					'mce_1', // Content
					'tags',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'mce_0' => 'required', // Title
					'mce_1' => 'required', // Content
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
		}

		$data['title'] = $data['mce_0'];
		$data['content'] = $data['mce_1'];

		$news = News::create($data);

		return Redirect::route('news.show', ['id' => $news->id]);
	}

	public function edit( $newsID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}
		$item = News::find($newsID);

		// If no featured image, put in our default image
		$item->featured_image = ($item->featured_image == '')
									? Setting::where('name', 'default_profile_picture')->first()->setting
									: $item->featured_image;

		return view('news.edit')->with( 'item', $item );
	}

	public function update( Request $request, $newsID ){
		if(! Auth::check() || ! Auth::user()->is_admin ){
			return response(view('errors.403', ['error' => $this->errorMessages['incorrect_permissions']]), 403);
		}

		$data = $request->only( [
					'mce_0', // Title
					'mce_1', // Content
					'tags',
					'featured_image'
				]);

		// Validate all input
		$validator = Validator::make( $data, [
					'mce_0' => 'required', // Title
					'mce_1' => 'required', // Content
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

		$data['title'] = $data['mce_0'];
		$data['content'] = $data['mce_1'];

		$news = News::find($newsID);
		$news->update( $data );

		return Redirect::route('news.edit', [$news->id]);
	}

	public function destroy( $encryptedNewsID ){
		$newsID = Crypt::decrypt($encryptedNewsID);
		News::destroy($newsID);
		return Redirect::back();
	}
}
