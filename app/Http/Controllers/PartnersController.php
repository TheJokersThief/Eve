<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partner;

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
    	return view('partners.create');
    }

    public function store(){
    	return view('partners.store');
    }

    public function edit(){
    	return view('partners.edit');
    }

    public function update(){
    	return view('partners.update');
    }
}
