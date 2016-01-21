@extends('layouts.app')

@section('content')

	<div class="container">
        <div class="col s12">
        	<h1>{{ $partner->name }}</h1>
        </div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{{ $partner->description }}</p>
		</div>
      	<div class="divider"></div>
  			<div class="section">
  			<div class="row">
		    <div class="col s3">Type: {{ $partner->type }}</div>
      		<div class="col s3">Price: {{ $partner->price }}</div>
      		<div class="col s3">Distance: {{ $partner->distance }}</div>
      		<div class="col s3">Email: {{ $partner->email }}</div>
	      	</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
		    <p>Location id: {{ $partner->location_id }}</p>
		</div>
	</div>

@endsection