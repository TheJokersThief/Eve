@extends('layouts.app')

@section('content')

	<ul class="collection with-header">
	    <li class="collection-header"><h4>Events</h4></li>

  	@foreach($events as $event)
		<a href="{{ action('EventsController@show', [$event->id]) }}" class="collection-item">{{ $event->title }}</a>
	@endforeach

	</ul>

@endsection