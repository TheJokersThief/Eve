@extends('layouts.app')

@section('content')

	<div class="container">

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

	</div>

@endsection