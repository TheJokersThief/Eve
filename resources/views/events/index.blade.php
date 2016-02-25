@extends('layouts.app')

@section('title') Events @endsection


@section('content')

	<!-- <div class="container">

		<ul class="collection with-header">
			<div class="row">
			    <div class="col s11">
			    	<li class="collection-header"><h4>Events</h4></li>
			    </div>
				<div class="col s1"><a href="{{ URL::route('events.create') }}"class="btn-floating btn-large waves-effect waves-light red">
					<h5 class="material-icons">+</h5></a>
				</div>
			</div>
			<div class="row">
	  	@foreach($events as $event)
			<a href="{{ action('EventsController@show', [$event->id]) }}" class="collection-item">{{ $event->title }}</a>
		@endforeach
			</div>

		</ul>

	</div> -->

<div class="container">
	<div class="row">
		<div class="valign-wrapper">
			<div class="col s10 m10">
				<h4>{{_t('Events')}}</h4>
			</div>
			<div class="col s2 m2">
				<a href="{{ action('EventsController@create') }}" class="waves-effect waves-light btn">{{_t('Create')}}</a>
			</div>
		</div>
	    @foreach($events as $event)
	    	<div class="col s4">
	            <div class="card">
	            	<div class="card-image waves-effect waves-block waves-light">
				    	<img class="activator" src="{{$event->featured_image}}">
				    </div>
				    <div class="card-content">
				    	<span class="card-title activator grey-text text-darken-4">{{_t($event->title)}}<i class="material-icons right">{{_t('more')}}</i></span>
				      	<p><a href="{{action('EventsController@show', [$event->id])}}">{{_t('visit page')}}</a></p>
				    </div>
				    <div class="card-reveal">
				      <span class="card-title grey-text text-darken-4">{{_t($event->title)}}<i class="material-icons right">{{_t('close')}}</i></span>
				      <p><a href="{{action('EventsController@show', [$event->id])}}">{{_t('visit page')}}</a></p>
				      <p>{!! _t($event->description) !!}</p>
				    </div>
				</div>
	      	</div>
		@endforeach
	</div>
</div>

@endsection
