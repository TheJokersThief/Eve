@extends('layouts.app')

@section('body-class') userProfile-page @endsection
@section('title') {{$user->name}} @endsection

@section('content')
<main>
	<div class="z-depth-1">
		<div class="container">
			<div class="section">
				<div class="row">
					<div class="col s6 m4 l3">
						<img class="responsive-img circle hide-on-small-only" src="{{$user->profile_picture}}">
					</div>
					<div class="col s12 m7 l8 offset-m1 offset-l1">
						<div class="row">
							<h3 class="col s12">{{$user->username}}</h3>
	                        <h5 class="col s12">({{$user->name}})</h5>
	                    </div>
	                    <div class="row col s12">
	                        <p class="flow-text">{{ $user->bio }}</p>
	                    </div>
                    </div>
                    @unless(!Auth::check() || ! (Auth::user()->id == $user->id || Auth::user()->is_admin))
                    	<div class="col s12">
							<a href="{{ URL::route('user/edit', Crypt::encrypt($user->id)) }}"class="waves-effect waves-light btn">Edit profile</a>
						</div>
                    @endunless
                </div>
            </div>
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s6"><h5>Email:</h5></div>
					<div class="col s6"><h5>Language:</h5></div>
					<div class="col s6">{{ $user->email }}</div>
					<div class="col s6">{{ $user->language }}</div>
				</div>
			</div>
			<div class="divider"></div>
			<div class="section">
				<div class="row">
					<div class="col s6"><h5>Country:</h5></div>
					<div class="col s6"><h5>City:</h5></div>
					<div class="col s6">{{ $user->country }}</div>
					<div class="col s6">{{ $user->city }}</div>
				</div>
			</div>
			<div class="divider"></div>
		</div>
	</div>
	@if( count($events) > 0 )
		<div class="section row">
			<div class="parallax-container">
				<div class="parallax"><img src="{{ URL::to('/') . '/images/gray-geometric-background.jpg'}}"></div>

				<div class="container">
					<h4 class="off-black white-text center card">Attending: </h4>
					@foreach($events as $event)
						<div class="col s12 m4">
							<div class="card dimmed-card-image">
								<div class="card-image">
									<img src="{{ $event->featured_image }}">
									<span class="card-title">{{$event->title}}.</span>
								</div>
								<div class="card-content">
									<p>{{strip_tags(str_limit($event->description,250))}}</p>
								</div>
								<div class="card-action">
									<a href="{{ URL::route('events.show', $event->id) }}" class="red-text text-lighten-2">View Event &rarr;</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@else
	    <div class="section">
			<div class="section">
				<h5 class="center-align">Oh bother.</h5>
			</div>
			<h5 class="center-align">{{$user->name}} is not attending any events soon</h5>
			<div class="section">
				<div class="center-align">
					<div class="col s3 m3">
						<a href="{{ action('EventsController@index') }}" class="waves-effect waves-light btn">See Events</a>
					</div>
				</div>
			</div>
		</div>
	@endif
</main>
@endsection
