<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;

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
    	return view('news.create');
    }

    public function store(){
    	return view('news.store');
    }

    public function edit(){
    	return view('news.edit');
    }

    public function update(){
    	return view('news.update');
    }
}
