@extends('layouts.app')
@section('title') {{$partner->name}} @endsection
@section('content')

	<div class="container">
        <div class="col s12">
        	<h1>{{ $partner->name }}</h1>
        </div>
        <div class="parallax-container">
			<div class="parallax">
				<img src="{{ $partner->media->file_location }}">
			</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{!! $partner->description !!}</p>
		</div>
      	<div class="divider"></div>
		<div class="section">
			<div class="row">
				<div class="col s6"><h5>Type:</h5></div>
				<div class="col s6"><h5>Price:</h5></div>
			    <div class="col s6">{{ $partner->type }}</div>
		  		<div class="col s6">{{ $partner->price }}</div>
	  		</div>
	  		<div class="row">
		  		<div class="divider"></div>
		  		<div class="col s6"><h5>Distance:</h5></div>
				<div class="col s6"><h5>Email:</h5></div>
		  		<div class="col s6">{{ $partner->distance }}</div>
		  		<div class="col s6">{{ $partner->email }}</div>
	      	</div>
		      	<div class="divider"></div>
		  		<div class="col s2"><h5>Location:<h5></div>
		    	<div class="col s10">{{ $partner->location->name }}</div>
			</div>
		</div>
	</div>

@endsection