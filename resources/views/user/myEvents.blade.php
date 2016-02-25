@extends('layouts.app')

@section('body-class') usersEvent-page usersAccount-page @endsection
@section('title') {{_t('Upcoming events')}} @endsection


@section('content')
	<main class="row">
		<nav class="oldEvents">
	    	<div class="nav-wrapper" >
      			<div class="col s12">
      				<a href="{{ URL::route('myEvents') }}" class="breadcrumb"><span class="grey-text text-darken-4">{{_t('Upcoming Events')}}</span></a>
       				<a href="{{ URL::route('pastEvents') }}" class="breadcrumb">{{_t('Past Events')}}</a>
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
		                    <span class="card-title grey-text text-darken-4">{{$me->name}} <i class="mdi-navigation-close right"></i></span>
		                    <p>{{ str_limit( $me->bio, 300 ) }}</p>
		                </div>
	            </div>
			</div>
			<div class="col m9">
				<h3 class="center-align">{{_t('Attending')}}</h3>
				<div class="divider"></div>
				@forelse($me->tickets as $ticket)
					<div class="col s12 m4">
	                    <div class="card dimmed-card-image">
	                        <div class="card-image">
	                            <img src="{{ $ticket->event->featured_image }}">
	                            <span class="card-title">{{_t($ticket->event->title)}}.</span>
	                        </div>
	                        <div class="card-content">
	                            <p>{{strip_tags(str_limit(_t($ticket->event->description),250))}}</p>
	                        </div>
	                        <div class="card-action">
	                            <a href="{{ URL::route('events.show', $ticket->event->id) }}" class="red-text text-lighten-2">{{_t('View Event')}} &rarr;</a>
	                        </div>
	                    </div>
	                </div>
				@empty
	            	<div class="section">
	            		<div class="section">
							<h5 class="center-align">{{_t("Oh bother.")}}</h5>
						</div>
						<h5 class="center-align">{{_t("You're not attending any events soon,")}}</h5>
						<h5 class="center-align">{{_t("maybe you want to check out some other events?")}}</h5>
						<div class="section">
							<div class="center-align">
								<div class="col s3 m3">
									<a href="{{ action('EventsController@index') }}" class="waves-effect waves-light btn">{{_t("See Events")}}</a>
								</div>
							</div>
						</div>
					</div>
	            @endforelse
			</div>
		</div>
	</main>
@endsection

