<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MediaController;

use App\News;
use Redirect;
use Auth;
use Validator;

class NewsController extends Controller
{
    public function index(){
        $news = News::orderBy('id', 'ASC')->get();
    	return view('news.index', ['news' => $news]);
    }

    public function show($id){
        $new = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    public function create(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
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
            return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
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
                                            $directory = "news", 
                                            $bestFit = true, 
                                            $fitDimensions = [1920, 500]
                                        );
        }

        $news = News::create($data);

    	return Redirect::route('news.show', ['id' => $news->id]);
    }

    public function edit(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
        }

    	return view('news.edit');
    }

    public function update(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
        }

    	return view('news.update');
    }
}
