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
		{!! Form::open( ['route' => 'partners.store', 'id' => 'partner-form', 'files' => 'true'] ) !!}

		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('p-name', null, ['placeholder' => 'Partner Name', 'id' => 'p-name']) !!}
				{!! Form::label('p-name', 'Partner Name:') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12 m6">
				{!! Form::text('p-type', null, ['placeholder' => 'e.g. Hotel, Restaurant', 'id' => 'p-type']) !!}
				{!! Form::label('p-type', 'Partner Type:') !!}
			</div>
			<div class="input-field col s12 m6">
				{!! Form::number('p-price', null, ['id' => 'p-price', 'step' => 'any', 'min' => '0']) !!}
				{!! Form::label('p-price', 'Average Price:') !!}
			</div>
		</div>

		<div class="row">
		      	<div class="input-field col s12">
		    		<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();}">
		      			<option value="" disabled selected>Choose location</option>
						@foreach($locations as $location)
							<option value="{{$location->id}}">{{$location->name}}</option>
						@endforeach
						<option value="-1">Create New Location</option>
		    		</select>
		    		<label>Location Select</label>
		  		</div>
			</div>


		<div class="row"><!-- To be calculated by the Google API in a later version -->
			<div class="input-field col s12 m6">
				{!! Form::number('p-distance', null, ['id' => 'p-distance', 'step' => 'any', 'min' => '0']) !!}
				{!! Form::label('p-distance', 'Distance:') !!}
			</div>
			<div class="col s12 m6">
					{!! Form::label('featured_image','Choose Image')	!!}
					{!! Form::file('featured_image') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('p-email', null, ['placeholder' => 'name@host.com', 'id' => 'p-email']) !!}
				{!! Form::label('p-email', 'Contact email:') !!}
			</div>
		</div>

        <div class="row">
	{!! Form::submit('Add Partner', ['class' => 'btn btn-primary form-control', 'id' => 'partner-button']) !!}
	{!! Form::close() !!}
		</div>
	</div>
	<div id="locationForm" class="modal bottom-sheet">
	<div class="modal-content">
	  <h4>Create New Location</h4>
	  <ul id="location-errors"></ul>
		{!! Form::open( ['route' => 'events.store'] ) !!}
			<div class="row">
				<div class="input-field col m6 s12">
					{!! Form::label('name','Location Name')	!!}
					{!! Form::text('name')	!!}
				</div>
				<div class="input-field col m6 s12">
					{!! Form::label('capacity','Location Capacity')	!!}
					{!! Form::number('capacity') !!}
				</div>
				<div class="input-field col m6 s12">
					{!! Form::label('coordinates','Location Coordinates')	!!}
					{!! Form::text('coordinates') !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	<div class="modal-footer">
	  <a href="#!" class="orange-text modal-action waves-effect waves-green btn-flat" onClick="createLocation()">Create</a>
	  <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat" onClick="$('#location-select').val('');$('#location-select').material_select();">Cancel</a>
	</div>
</div>
</main>

@endsection
