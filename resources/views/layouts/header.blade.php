<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/') }}/images/favicon.png">

	
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/font-awesome.min.css">
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
	@yield('extra-css')

	@yield('extra-head')
</head>
<body class="@yield('body-class')">
    
    <header>
    	<nav>
			<div class="nav-wrapper container">
			  <a href="{{ URL::to('/home') }}" class="brand-logo">
				<img src="{{URL::to('/images/logo.png')}}" alt="{{ env( 'SITE_TITLE' ) }}" class="logo" width="20%">
			  </a>
			  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
			  <ul class="right hide-on-med-and-down">
			  	@if( Auth::check( ) )
			  		<li><a href="{{ URL::to( '/' ) }}">Home</a></li>
			  	@else 
					<li class="login"><a class="waves-effect waves-light modal-trigger" href="#login-modal">Login</a></li>
					<li><a href="{{ URL::to('register') }}">Register</a></li>
			  	@endif
			  </ul>
			  <ul class="side-nav" id="mobile-demo">

			  	@if( Auth::check( ) )
			  		<li><a href="{{ URL::to( 'home' ) }}">Home</a></li>
			  	@else 
					<li class="login"><a class="waves-effect waves-light modal-trigger" href="#login-modal">Login</a></li>
					<li><a href="{{ URL::to('register') }}">Register</a></li>
			  	@endif
			 
			  </ul>
			</div>
		</nav>
	</header>