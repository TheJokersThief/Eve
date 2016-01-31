@extends('layouts.app')
@section('body-class') info-pack @endsection

@section('content')
<main class="container">
	<div class="row">
		<div class="qr-holder col s12 m3 center-align">{!! $ticket->qr() !!}</div>
		<div class="col s12 m9">
			<h1 class="green-text">{{$ticket->event->title}}</h1>
			<h2 class="teal-text">{{$ticket->user->name}}</h2>
		</div>
	</div>

	@include("events.details")
</main>
@endsection