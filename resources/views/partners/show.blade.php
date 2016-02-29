@extends('layouts.app')
@section('title') {{$partner->name}} @endsection
@section('content')

	<div class="container">
        <div class="col s12">
        	<h1>{{ $partner->name }}</h1>
        </div>
        <div class="parallax-container">
			<div class="parallax">
				<img src="{{ $partner->featured_image }}">
			</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{!! _t($partner->description) !!}</p>
		</div>
      	<div class="divider"></div>
		<div class="section">
			<div class="row">
				<div class="col s6"><h5>{{_t('Type:')}}</h5></div>
				<div class="col s6"><h5>{{_t('Price:')}}</h5></div>
			    <div class="col s6">{{ _t($partner->type) }}</div>
		  		<div class="col s6">{{ $partner->price }}</div>
	  		</div>
	  		<div class="row">
		  		<div class="divider"></div>
		  		<div class="col s6"><h5>{{_t('Location:')}}</h5></div>
				<div class="col s6"><h5>{{_t('Email:')}}</h5></div>
		  		<div class="col s6">{{ $partner->location->name }}</div>
		  		<div class="col s6">{{ $partner->email }}</div>
	      	</div>
		</div>
	</div>

@endsection
