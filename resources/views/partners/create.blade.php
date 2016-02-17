@extends('layouts.app')

@section('body-class') create-partner @endsection
@section('title') Add a new Partner @endsection


@section('extra-css')
@endsection

@section('extra-js')
@endsection

@section('content')


<main class="container row">
	<div class="col m8 offset-m2 s12">
		<div class="row">
			<div class="col s12">
				<h1>Add a New Partner</h1>
			</div>
		</div>
		{!! Form::open( ['route' => 'partners.store', 'id' => 'partner-form', 'files' => true] ) !!}

		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('name', null, ['id' => 'name']) !!}
				{!! Form::label('name', 'Partner Name:') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12 m6">
				{!! Form::text('type', null, ['placeholder' => 'e.g. Hotel, Restaurant', 'id' => 'type']) !!}
				{!! Form::label('type', 'Partner Type:') !!}
			</div>
			<div class="input-field col s12 m6">
				{!! Form::number('price', null, ['id' => 'price', 'step' => 'any', 'min' => '0']) !!}
				{!! Form::label('price', 'Average Price:') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s6">
				<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();}">
					<option value="" disabled selected>Choose location</option>
					@foreach($locations as $location)
						<option value="{{$location->id}}">{{$location->name}}</option>
					@endforeach
				</select>
				<label>Location Select</label>
			</div>
			<div class="input-field col s6">
	    		<select multiple name="event_id[]" id="event-select">
	      			<option value="" disabled selected>Choose event</option>
					@foreach($events as $event)
						<option value="{{$event->id}}">{{$event->title}}</option>
					@endforeach
	    		</select>
	    		<label>Event Select</label>
	  		</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				{!! Form::textarea('description', null, ['id' => 'description', 'class' => 'materialize-textarea']) !!}
				{!! Form::label('description', 'Partner Description:') !!}
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				{!! Form::label('url', 'Website: ') !!}
				{!! Form::text('url', null, ['placeholder'=>'http://www.example.com']) !!}
			</div>
		</div>
		<div class="row">
			<div class="file-field input-field col s12 m6">
				<div class="btn">
					<span>Logo</span>
					{!! Form::file('logo') !!}
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
			</div>
			<div class="file-field input-field col s12 m6">
				<div class="btn">
					<span>Feature Image</span>
					{!! Form::file('picture') !!}
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12"><!-- To be calculated by the Google API in a later version -->
				{!! Form::number('distance', null, ['id' => 'distance', 'step' => 'any', 'min' => '0'] ) !!}
				{!! Form::label('distance', 'Distance:') !!}
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('email', null, ['placeholder' => 'name@host.com', 'id' => 'email']) !!}
				{!! Form::label('email', 'Contact email:') !!}
			</div>
		</div>

		<div class="row">
	{!! Form::submit('Add Partner', ['class' => 'btn btn-primary form-control', 'id' => 'partner-button']) !!}
	{!! Form::close() !!}
		</div>
	</div>
</main>
@include("forms.locationmodal")
@endsection
