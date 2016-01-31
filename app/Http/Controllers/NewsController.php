<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;
use Redirect;

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

    public function store(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit news.']), 403);
        }

    	return view('news.store');
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
