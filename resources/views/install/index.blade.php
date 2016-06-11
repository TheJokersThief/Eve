@extends('layouts.app')

@section('body-class') install-page @endsection
@section('title') Installing Eve @endsection


@section('extra-js')
	<script type="text/javascript">
		$(document).ready(function(){
			checkProgress( );
			autofillInformation( );

			// Add event listener for "back" button
			window.addEventListener('popstate', function(event){
				var sectionNumber = 0;
				var totalSections = 4;
				switch( window.location.hash ){
					case '#personalDetails':
						sectionNumber = 2;
						break;

					case '#companyDetails':
						sectionNumber = 3;
						break;

					case '#firstEvent':
						sectionNumber = 4;
						break;

					default:
						sectionNumber = 1;
						break;
				}
				console.log( window.location.hash.replace('#', ''), sectionNumber, totalSections );
			    moveToSection( window.location.hash.replace('#', ''), sectionNumber, totalSections, true );
			});
		});
	</script>
@endsection

@section('content')
	<main class="row">
		<div class="col s12 l8 offset-l2 card white">
			<div class="col s12">
				<ul class="tabs">
					<li class="tab col s3" onclick="moveToSection('info', 1, 4, false );">
						<a href="#info">{{_t('Info')}}</a>
					</li>
					<li class="tab col s3" onclick="moveToSection('personalDetails', 2, 4, false );">
						<a href="#personalDetails">{{_t('Your Details')}}</a>
					</li>
					<li class="tab col s3" onclick="moveToSection('companyDetails', 3, 4, false );">
						<a href="#companyDetails">{{_t('Company Details')}}</a>
					</li>
					<li class="tab col s3" onclick="moveToSection('firstEvent', 4, 4, false );">
						<a href="#firstEvent">{{_t('Your First Event')}}</a>
					</li>
				</ul>
				<div class="progress">
				      <div class="determinate" id="progressBar"></div>
				</div>
			</div>
			<div id="info" class="col s12">
				<div class="row">
					<h2>{{_t('Welcome To Project Eve!')}}</h2>
					<p class="flow-text">{{_t("This is the installation process we need to go through before you can start advertising your events. First, we'll get details about your new Administrator account. Next, we'll setup some information about your company. Then, finally, we'll show you how to create your first event!")}}</p>

					<div class="row col s12 red lighten-3">
						<figure class="col s12 m6 offset-m3">
							<img src="/images/logo_full.png"/>
						</figure>
					</div>

					<button class="btn waves-effect waves-light right" type="button" onclick="moveToSection('personalDetails', 2, 4, false);">{{_t('Next')}}
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
						{!! Form::label('email',_t('Email'))									!!}
						{!! Form::text('email')	!!}
					</div>

					<div class="input-field col m6 s12">
						{!! Form::label('username', _t('Username')) !!}
						{!! Form::text('username' ) !!}
					</div>

					<div class="input-field col m6 s12">
						{!! Form::label('name',_t('Full Name'))									!!}
						{!! Form::text('name')	!!}
					</div>

					<div class="input-field col m6 s12">
						{!! Form::label('password',_t('Password'))								!!}
						{!! Form::password('password')	!!}
					</div>

					<div class="input-field col m6 s12">
						{!! Form::label('password_confirmation', _t('Confirm Password')) !!}
						{!! Form::password('password_confirmation' ) !!}
					</div>

					<div class="col s12 m3">
						<img src="/images/default_profile_image.png" id="profle-picture-preview">
					</div>

					<div class="file-field input-field col m9 s12">
						<div class="btn">
							<span>{{_t('Upload A Profile Picture')}}</span>
							{!! Form::file('profile_picture')	!!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>


				<button class="btn waves-effect waves-light right" type="button" name="next" onclick='createUser();'>Next
					<i class="mdi-content-send right"></i>
				</button>

				{!! Form::close() 													!!}
			</div>
			<div id="companyDetails" class="col s12">
				<h3>{{_t('Company Details')}}</h3>

				<ul id="company-details-errors" class="errors-list red-text">

				</ul>

				{!! Form::open( array('url' => '#!', 'id' => 'companyDetails-form', 'method' => 'post', 'class' => 'row col s12', 'enctype'=>"multipart/form-data" ) ) 		!!}

				<div class="row">
					<div class="input-field col s12">
						{!! Form::label('company_name',_t('Company Name')) !!}
						{!! Form::text('company_name')	!!}
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						{!! Form::textarea('description', null, ['class' => 'materialize-textarea', 'length' => '250'] ) !!}
						{!! Form::label('description', _t('Description')) !!}
					</div>
				</div>

				<div class="row">
					<div class="col s12 m3">
						<img src="{{ App\Setting::where('name', 'default_profile_picture')->first()->setting }}" id="company-logo-preview">
					</div>

					<div class="file-field input-field col m9 s12">
						<div class="btn">
							<span>{{_t('Upload A Company Logo')}}</span>
							{!! Form::file('company_logo')	!!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>


				<button class="btn waves-effect waves-light right" type="button" name="next" onclick='createCompany();'>Next
					<i class="mdi-content-send right"></i>
				</button>

				{!! Form::close() !!}
			</div>
			<div id="firstEvent" class="col s12">
				<a href="{{ URL::route('events.create') }}" id="first-event-link">{{_t('Go create your first event!')}}</a>
			</div>
		</div>
	</main>
@endsection
