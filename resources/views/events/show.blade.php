@extends('layouts.app')

@section('body-class') event-page @endsection
@section('title') {{$event->title}} @endsection

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
					<div class=" col s12 m3 right-align get_ticket_button">
						<a class="btn" href="{{ URL::route('tickets/print', ['id' => $ticket->id ]) }}">Print ticket</a>
					</div>
				@endif
		    @endif
		</div>
		<div class="divider"></div>
		@include("events.details")
        @if(count($users))
            <div class="divider"></div>
            <div class="section people-attending @if(count($users) > 6)align-center @endif">
                <h5>People attending this event:</h5>
                <div class="row">
                    @foreach($users as $user)
                        <div class="col s2 m1">
                            <a href="{{URL::route('user/show', $user->username) }}">
                                <img src="{{$user->profile_picture}}" class="circle responsive-img" alt="{{$user->name}}" data-toggle="tooltip" data-placement="top" title="{{$user->name}}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
@endsection
