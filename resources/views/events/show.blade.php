@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
	        <div class="col s9 m9">
	        	<h2>{{ $event->title }}</h2>
	        </div>
	        @if(Auth::check())
	        	@if(Auth::user()->is_admin)
			        <div class="col s3 m3">
				        <a href="{{ action('EventsController@edit', [$event->id]) }}">
				        	<h2>Update</h2>
				        </a>
				    </div>
				@endif
		        @if(! $ticket)
					{!! Form::open( ['action' => 'TicketController@store', "class" => "col s12 m3 right-align get_ticket_button"] ) !!}
						{!! Form::hidden('event_id', $event->id) !!}
						{!! Form::submit('Get Ticket', ['class' => 'btn btn-primary form-control']) !!}
					{!! Form::close() !!}
				@else
					<div class="col s12 m3 right-align get_ticket_button">
						<a class="btn btn-primary" href="{{ action('TicketController@show', [$ticket->id]) }}">Show ticket</a>
					</div>
				@endif
		    @endif
		</div>
		<div class="divider"></div>
	
		@include("events.details")	
@endsection