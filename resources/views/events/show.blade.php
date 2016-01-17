@extends('layouts.app')

@section('content')

	<div class="container">
        <div class="col s12">
        	<h1>{{ $event->title }}</h1>
        </div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{{ $event->description }}</p>
		</div>
      	<div class="divider"></div>
  			<div class="section">
  			<div class="row">
  			<div class="col s6">Start:</div>
      		<div class="col s6">End:</div>
		    <div class="col s6">{{ $event->start_datetime }}</div>
      		<div class="col s6">{{ $event->end_datetime }}</div>
	      	</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{{ $event->location_id }}</p>
		</div>
	</div>

@endsection