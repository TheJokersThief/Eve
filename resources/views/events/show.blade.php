@extends('layouts.app')

@section('body-class') event-page @endsection
@section('title') {{$event->title}} @endsection

@section('content')

	<div class="container">
		<div class="row">
			<div class="valign-wrapper">
			<div class="col s8 m8">
				<h2>{{ $event->title }}</h2>
			</div>
			@if(Auth::check())
				@if(Auth::user()->is_admin)
					<div class="col s2 m2 center-align">
							<a href="{{ action('EventsController@edit', [$event->id]) }}" class="waves-effect waves-light btn">Update</a>
						</div>
				@endif
				@if(! $ticket)
					{!! Form::open( ['action' => 'TicketController@store', "class" => "col s12 m3 right-align get_ticket_button"] ) !!}
						{!! Form::hidden('event_id', $event->id) !!}
						@if(!$event->price)
							{!! Form::submit('Get Ticket', ['class' => 'btn btn-primary form-control']) !!}
						@else
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
							        data-key="{{env('STRIPE_KEY')}}"
							        data-logo="{{URL::to('/images/logo.png')}}"
							        data-description="{{$event->title}}"
							        data-amount="{{$event->price * 100}}"
							        data-locale="auto"
									data-currency="EUR"
									data-email="{{Auth::user()->email}}"></script>
						@endif
					{!! Form::close() !!}
				@else
					<div class="col s12 m2 right-align get_ticket_button">
						<a class="btn btn-primary" href="{{ action('TicketController@show', [$ticket->id]) }}">Show ticket</a>
					</div>
					<div class=" col s12 m2 right-align get_ticket_button">
						<a class="btn" href="{{ URL::route('tickets/print', ['id' => $ticket->id ]) }}">Print ticket</a>
					</div>
				@endif
			@else
				<a class="btn waves-effect waves-light modal-trigger" href="#login-modal">Login</a>
				<a href="{{ URL::to('register') }}" class="btn">Signup</a>
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
