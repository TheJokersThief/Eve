@extends('layouts.app')

@section('body-class') usersAccount-page @endsection
@section('title') Edit your details @endsection


@section('content')


	<main class="row">
		<div class="col s12 m8 offset-m2">
			<div class="col l4 m4, hide-on-small-only">
				<div id="profile-card" class="card hide-on-small-only">
					<div class="card-image waves-effect waves-block waves-light">
						<img class="activator" src="{{ URL::to('/') . '/images/red-geometric-background.png'}}" alt="user background">
					</div>
					<div class="card-content">
						<img src="{{$me->profile_picture}}" alt="" class="circle responsive-img activator card-profile-image">

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

			{!! Form::open([
				"route" => array('user', Crypt::encrypt($me->id)),
				"method" => "POST",
				"files" => true
			]) !!}

			<div class="col l7 m7 s12"/>
				<ul class="collection flow-text input-field">
					@if(Auth::user()->username == Auth::user()->facebook_id && isset($errors) && !empty($errors->all()))
						<li class="collection-item red darken-1 white-text"><strong>Errors:</strong>
							<ul>
								@foreach($errors->all() as $error)
									<li class="white-text">{{$error}}</li>
								@endforeach
							</ul>
						</li>
					@endif
					<li class="collection-item"><strong>Name:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('name', $me->name, ["class" => "example validate"])!!}
					</li>
					@if(!$me->username)
						<li class="collection-item"><strong>Username:</strong>
							<div class="secondary-content">
								<i class="fa fa-pencil teal-text"></i>
							</div>
							{!! Form::text('username', "", ["class" => "example validate"])!!}
						</li>
					@endif
					<li class="collection-item"><strong>Bio:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::textarea('bio', $me->bio, ["class" => "materialize-textarea"])!!}
					</li>
					<li class="collection-item"><strong>Language:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('language', $me->language, ["class" => "example validate"])!!}
					</li>
					<li class="collection-item"><strong>City:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('city', $me->city, ["class" => "example validate"])!!}
					</li>
					<li class="collection-item"><strong>Country:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('country', $me->country, ["class" => "example validate"])!!}
					</li>
				</ul>
				<ul class="collection flow-text">
					<li class="collection-item"><strong>Change password:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::password('password', null, ["class" => "example validate"] ) !!}
					</li>
				</ul>
				<ul class="collection flow-text file-field input-field">
					<li class="collection-item"><strong>Change Profile Picture</strong>
						<div class="secondary-content">
						    <div class="btn">
    							<span>File</span>
   								{!! Form::file('profile_picture')!!}
  							</div>
  							<div class="file-path-wrapper">
						        <input class="file-path validate" type="text">
						    </div>
						</div>
					</li>
				</ul>
				{!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</main>
@endsection
