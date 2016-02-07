@extends('layouts.app')

@section('body-class') usersAccount-page @endsection

 <link href="https://fonts.googleapis.com/icon?family=Material+Icons">

@section('content')
	<main class="row">
		<div class="col m10 s12 push-m1">
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
				<h3 class="center-align">Attending</h3>
				<div class="divider"></div>
				@foreach($me->tickets as $ticket)
					<div class="col s12 m4">
	                    <div class="card dimmed-card-image">
	                        <div class="card-image">
	                            <img src="{{ $ticket->event->featured_image }}">
	                            <span class="card-title">{{$ticket->event->title}}.</span>
	                        </div>
	                        <div class="card-content">
	                            <p>{{strip_tags(str_limit($ticket->event->description,250))}}</p>
	                        </div>
	                        <div class="card-action">
	                            <a href="{{ URL::route('events.show', $ticket->event->id) }}" class="red-text text-lighten-2">View Event &rarr;</a>
	                        </div>
	                    </div>
	                </div>
				@endforeach
			</div>
		</div>
	</main>
@endsection
