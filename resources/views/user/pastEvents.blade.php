@extends('layouts.app')

@section('body-class') usersEvent-page usersAccount-page @endsection
@section('title') Past events @endsection

@section('content')
	<main class="row">
		<nav class="oldEvents">
	    	<div class="nav-wrapper" >
	      			<div class="col s12">
	      				<a href="{{ URL::route('myEvents') }}" class="breadcrumb">Upcoming Events</a>
	       				<a href="{{ URL::route('pastEvents') }}" class="breadcrumb">Past Events</a>
	      			</div>
	   			</div>
	  		</nav>
		<div class="col m10 s12 push-m1">
			<div class="col m3">
				<div id="profile-card" class="card hide-on-small-only">
	                <div class="card-image waves-effect waves-block waves-light">
	                    <img class="activator" src="{{ URL::to('/') . '/images/red-geometric-background.png'}}" alt="user background">
	                </div>
	                <div class="card-content">
	                    <img src="{{$me->profile_picture}}" alt="" class="circle responsive-img activator card-profile-image">
	                    <a href="{{ URL::route('user/edit', Crypt::encrypt($me->id)) }}" class="btn-floating btn-move-up waves-effect waves-light darken-2 right">
	                        <i class="mdi-action-account-circle"></i>
	                    </a>

	                    <span class="card-title activator grey-text text-darken-4">{{ $me->name }}</span>
	                    <p><i class="mdi-communication-email cyan-text text-darken-2"></i> {{ $me->email }}</p>
	                    <p><i class="fa fa-map-marker cyan-text text-darken-2"></i> {{ $me->city }}, {{ $me->country }}</p>
	                    <p><i class="fa fa-language cyan-text text-darken-2"></i> {{ $me->language }}</p>
	                </div>
	                <div class="card-reveal">
		                    <span class="card-title grey-text text-darken-4">Roger Waters <i class="mdi-navigation-close right"></i></span>
		                    <p>{{ str_limit( $me->bio, 300 ) }}</p>
		                </div>
	            </div>
			</div>
				<div id="upComingEvents" class="col m9 s12">
					<div class="">
						<h3 class="center-align">Past Events</h3>
						<div class="divider"></div>
							<div class="row">
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
				</div>
			</div>
		</div>
	</main>
@endsection

