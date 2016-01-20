@extends('layouts.app')

@section('body-class') install-page @endsection

@section('extra-js')
	<script type="text/javascript">
		$(document).ready(function(){
			checkProgress( );
		});
	</script>
@endsection

@section('content')
	<main class="row">
		<div class="col s12 l8 offset-l2 card white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s3" onclick="moveToSection( 'info', 1, 4 );">
						<a href="#info">Info</a>
					</li>
					<li class="tab col s3" onclick="moveToSection( 'personalDetails', 2, 4 );">
						<a href="#personalDetails">Your Details</a>
					</li>
					<li class="tab col s3" onclick="moveToSection( 'companyDetails', 3, 4 );">
						<a href="#companyDetails">Company Details</a>
					</li>
					<li class="tab col s3" onclick="moveToSection( 'firstEvent', 4, 4 );">
						<a href="#firstEvent">Your First Event</a>
					</li>
				</ul>
				<div class="progress">
				      <div class="determinate" id="progressBar"></div>
				</div>
			</div>
			<div id="info" class="col s12">
				<div class="row">
					<h2>Welcome To Project Eve!</h2>
					<p class="flow-text">This is the installation process we need to go through before you can start advertising your events. First, we'll get details about your new Administrator account. Next, we'll setup some information about your company. Then, finally, we'll show you how to create your first event!</p>
					
					<div class="row col s12 red lighten-3">
						<figure class="col s12 m6 offset-m3">
							<img src="/images/logo.png"/>
						</figure>
					</div>

					<button class="btn waves-effect waves-light right" type="button" onclick="moveToSection('personalDetails', 2, 4);">Next
						<i class="mdi-content-send right"></i>
					</button>
				</div>

			</div>
			<div id="personalDetails" class="col s12">
				<ul id="personal-details-errors" class="errors-list red-text">

				</ul>

				{!! Form::open( array('url' => '#!', 'id' => 'personalDetails-form', 'method' => 'post', 'class' => 'row col s12', 'enctype'=>"multipart/form-data" ) ) 		!!}

				<div class="row">
					<div class="input-field col m6 s12">
						{!! Form::label('email','Email')									!!}
						{!! Form::text('email')	!!}
					</div>
					<div class="input-field col m6 s12">
						{!! Form::label('name','Full Name')									!!}
						{!! Form::text('name')	!!}
					</div>
				</div>

				<div class="row">
					<div class="input-field col m6 s12">
						{!! Form::label('password','Password')								!!}
						{!! Form::password('password')	!!}
					</div>

					<div class="input-field col m6 s12">
						{!! Form::label('password_confirmation', 'Confirm Password') !!}
						{!! Form::password('password_confirmation' ) !!}
					</div>
				</div>
				
				<div class="row">
					<div class="col s12 m3">
						<img src="/images/default_profile_image.png" id="profle-picture-preview">
					</div>

					<div class="file-field input-field col m9 s12">
						<div class="btn">
							<span>Upload A Profile Picture</span>
							{!! Form::file('profile_picture')	!!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>


				<button class="btn waves-effect waves-light right" type="button" name="action" onclick='createUser();'>Next
					<i class="mdi-content-send right"></i>
				</button>

				{!! Form::close() 													!!}
			</div>
			<div id="companyDetails" class="col s12">Company Details</div>
			<div id="firstEvent" class="col s12">Your First Event</div>
		</div>
	</main>
@endsection