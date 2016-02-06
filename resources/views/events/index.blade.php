@extends('layouts.app')

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

	<ul class="collection with-header">
	    <li class="collection-header"><h4>events</h4></li>
	    <div class="row">
		    @foreach($events as $event)
		    	<div class="col s4">
		            <div class="card">
		            	<div class="card-image waves-effect waves-block waves-light">
					    	<img class="activator" src="{{$event->featured_image}}">
					    </div>
					    <div class="card-content">
					    	<span class="card-title activator grey-text text-darken-4">{{$event->title}}<i class="material-icons right">more</i></span>
					      	<p><a href="{{action('EventsController@show', [$event->id])}}">visit page</a></p>
					    </div>
					    <div class="card-reveal">
					      <span class="card-title grey-text text-darken-4">{{$event->title}}<i class="material-icons right">close</i></span>
					      <p><a href="{{action('EventsController@show', [$event->id])}}">visit page</a></p>
					      <p>{!! $event->description !!}</p>
					    </div>
					</div>
	          	</div>
			@endforeach
		</div>
	</ul>

@endsection