<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partner;
use Redirect;


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

    	return view('partners.create');
    }

    public function store(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
        }

    	return view('partners.store');
    }

    public function edit(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
        }


    	return view('partners.edit');
    }

    public function update(){
        if(! Auth::check() || ! Auth::user()->is_admin ){
            return response(view('errors.403', ['error' => 'You do not have permission to edit partners.']), 403);
        }

    	return view('partners.update');
    }
}
