@extends('layouts.app')

@section('body-class') usersAccount-page @endsection

 <link href="https://fonts.googleapis.com/icon?family=Material+Icons">

@section('content')
	<main class="row">
		<div class="col m10 s12 push-m1 card white">
			<div class="col m3">
				<div class="hide-on-small-only" id="userInfo">
					<div class="collection">
						<div class="hide-on-med-and-down">
							<img src="{{$me->profile_picture}}">
						</div>
						<div class="row">
							<div class="col s10">
								<span>User Name: {{$me->name}}</span>
								<p>{{$me->bio}}</p>
							</div>
						</div>
						<div class="row">
							<div class="col s12">
								<a href="{{ URL::route('user/edit', Crypt::encrypt(Auth::user()->id)) }}"class="waves-effect waves-light btn">Edit profile</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col m9">
				<div class="flow-text"/>
					<h3 class="center-align">Attending</h3>
					@if(count($me->tickets) < 1)
						<div class="divider"></div>
						<p class="center-align">Currently not attending any events</p>
					@else
						@foreach($me->tickets as $ticket)
							<div class="divider"></div>
							<div class="section">
								{{$ticket->event->title}}
								<div class="secondary-content">
									<a class="material-icons" href="{{ action('EventsController@show', [$ticket->event->id]) }}"><i class="material-icons">today</i></a>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</main>
@endsection
