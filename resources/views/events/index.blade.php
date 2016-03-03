@extends('layouts.app')

@section('title') Events @endsection


@section('content')

<div class="container">
	<div class="row">
		<div class="valign-wrapper">
			@if (  Auth::check() && Auth::user()->is_admin )
			<div class="col s10 m10 left-align">
				<h4>{{_t('Events')}}</h4>
			</div>
			<div class="col s2 m2">
				<a href="{{ action('EventsController@create') }}" class="waves-effect waves-light btn">{{_t('Create')}}</a>
			</div>
			@else
			<div class="col s12 m12">
				<h4>{{_t('Events')}}</h4>
			</div>
			@endif
		</div>
		<!-- Show all events -->
	    @foreach($events as $event)
	    	<div class="col s4">
	            <div class="card">
	            	<div class="card-image waves-effect waves-block waves-light">
				    	<img class="activator" src="{{$event->featured_image}}">
				    </div>
				    <!-- Display title -->
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
