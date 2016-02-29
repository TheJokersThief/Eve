<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
	<link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	@yield('extra-css')

	@yield('extra-head')
</head>
<body class="@yield('body-class')">
	@include('layouts.facebook-sdk')
    @yield('before-page')
	@if(!Auth::check() || ( Auth::user()->username != Auth::user()->facebook_id ) )
	{{-- We need this check to prevent a usernameless user from navigating away --}}
     <header>
		{!! Form::open([
			"route" => 'search',
			"method" => "GET"
		]) !!}
    	<nav>
			<div class="nav-wrapper container">

				<!-- User Search Box -->
				<div class="left input-field hide-on-med-and-down">
				  {!! Form::text('search',
						null,
						['id' => 'search',
				        'placeholder'=> str_limit( _t('Search for a user'), 20 ) ])
				  !!}
				  <label for="search"><i class="material-icons">search</i></label>
				</div>
			  <a href="{{ URL::to('/home') }}" class="brand-logo">

			  	@if( ($logo = App\Setting::where('name', 'company_logo')->first()->setting) != '' )

			  		@if( ! method_exists(Route::current(), "getName") || ! Route::current()->getName() == null )
						<img src="{{URL::to($logo)}}" alt="{{ env( 'SITE_TITLE' ) }}" class="logo" width="20%">
					@else
						<img src="{{URL::to( App\Setting::where('name', 'company_logo_white')->first()->setting )}}" alt="{{ env( 'SITE_TITLE' ) }}" class="logo" width="20%">
					@endif
				@else
					<img src="{{URL::to('/images/logo.png')}}" alt="{{ env( 'SITE_TITLE' ) }}" class="logo" width="20%">
				@endif
			  </a>
			  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
			  <ul class="right hide-on-med-and-down">
			  	@if( Auth::check( ) )
			  		@if( Auth::user()->is_admin )
						<li><a href="{{ URL::route('admin.home') }}">{{_t('Admin')}}</a></li>
			  		@endif
			  		@if( Auth::user()->is_staff )
						<li><a href="{{ URL::route('staff.home') }}">{{_t('Staff')}}</a></li>
			  		@endif
			  		<li><a href="{{ URL::to( 'home' ) }}">{{_t('Home')}}</a></li>
			  		<li><a href="{{ URL::route('me') }}"><i class="material-icons">perm_identity</i></a></li>
			  		<li><a href="{{ URL::route('myEvents') }}"><i class="material-icons">today</i></a></li>
			  		<li><a href="{{ URL::route('logout') }}"><i class="material-icons">input</i></a></li>
			  	@else
					<li class="login">
						<a class="btn waves-effect waves-light modal-trigger" href="#login-modal">{{_t('Login')}}</a>
					</li>
					<li class="register">
						<a href="{{ URL::to('register') }}" class="btn">{{_t('Signup')}}</a>
					</li>
			  	@endif
			  	<li><a href="#language-modal" class="modal-trigger" alt="{{_t('Language Preferences')}}"><i class="material-icons">language</i></a></li>
			  </ul>
			  <ul class="side-nav" id="mobile-demo">
			  <div class="input-field">
				  <label for="search"><i class="material-icons">search</i></label>
			  </div>
			  	@if( Auth::check( ) )
			  		@if( Auth::user()->is_admin )
						<li><a href="{{ URL::route('admin.home') }}">{{_t('Admin')}}</a></li>
			  		@endif
			  		@if( Auth::user()->is_staff )
						<li><a href="{{ URL::route('staff.home') }}">{{_t('Staff')}}</a></li>
			  		@endif
			  		<li><a href="{{ URL::to( 'home' ) }}">{{_t('Home')}}</a></li>
			  		<li><a href="{{ URL::route('me') }}"><i class="material-icons">perm_identity</i> {{_t('User Account')}}</a></li>
			  		<li><a href="{{ URL::route('myEvents') }}"><i class="material-icons">today</i> {{_t('My Events')}}</a></li>
			  		<li><a href="{{ URL::route('logout') }}"><i class="material-icons">input</i> {{_t('Logout')}}</a></li>
			  	@else
					<li class="login">
						<a class=" waves-effect waves-light modal-trigger" href="#login-modal">{{_t('Login')}}</a>
					</li>
					<li class="register">
						<a href="{{ URL::to('register') }}" class="">{{_t('Signup')}}</a>
					</li>
			  	@endif
			  	<li><a href="#language-modal" class="modal-trigger" alt="{{_t('Language Preferences')}}"><i class="material-icons left">language</i> {{_t('Language')}} </a></li>

			  </ul>
			  <div class="hide">
					{!! Form::submit('Search') !!}
			  </div>
			  {!! Form::close() !!}
			</div>
		</nav>
		@if(isset($errors) && !empty($errors->all()))
			<div class="container">
		      <div class="row">
		        <div class="col s12 m6">
		          <div class="card red darken-1">
		            <div class="card-content white-text">
		              <span class="card-title">{{_t('Errors')}}</span>
		              <p>
		              	@foreach($errors->all() as $error)
							<li>{{$error}}</li>
						@endforeach
					  </p>
		            </div>
		          </div>
		        </div>
		      </div>
			</div>
		@endif
	</header>
	@endif
	<div class="body-wrapper">
