@extends('layouts.app')

@section('body-class') create-event @endsection

@section('title') Create an Event @endsection


@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.clockpicker').clockpicker({
				placement: 'bottom',
			    align: 'left',
			    donetext: 'Done'
			});
		});
	</script>
@endsection

@section('content')


<div class="row">
	<div class="col m8 offset-m2">
		<div class="row">
			<div class="col s12">
				<h1>Create a New Event</h1>
			</div>
		</div>

		</hr>

		{!! Form::open( ['route' => 'events.store', 'files' => true] ) !!}
			
			<div class="row">
				<div class="input-field col m6 s12">
					{!! Form::label('title','Event Title')	!!}
					{!! Form::text('title')	!!}
				</div>
				<div class="input-field col m6 s12">
					{!! Form::label('tagline','Event Tagline')	!!}
					{!! Form::text('tagline') !!}
				</div>
				<div class="input-field col m12 s12">
					{!! Form::label('description','Event Description')	!!}
					{!! Form::text('description') !!}
				</div>
			</div>

			<div class="row">

				<div class="col m6 s6">
					<label for="start_date">Start Date</label>
					<input name="start_date" id="start_date" type="date" value="Start Date" class="datepicker">
				</div>

				<div class="col m6 s6">
					<label for="input_enddate">End Date</label>
					<input name="end_date" id="input_enddate" type="date" value="End Date" class="datepicker">
				</div>

				<div class="col m6 s6">
					{!! Form::label('featured_image','Choose Image')	!!}
					{!! Form::file('featured_image') !!}
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

			<div class="row">
				<div class="col s4">
					<label for="start_time">Start Time</label>
					<div id="start_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="start_time" type="text" class="form-control" value="08:30">
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
				<div class="col s4">
					<label for="end_time">End Time</label>
					<div id="end_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="end_time" type="text" class="form-control" value="16:00">
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
			</div>

				<!-- <div class="input-field col m6 s12">
					{!! Form::label('start_datetime', 'Start') !!}
					{!! Form::text('start_datetime' ) !!}
				</div>

				<div class="input-field col m6 s12">
					{!! Form::label('end_datetime', 'End') !!}
					{!! Form::text('end_datetime' ) !!}
				</div> -->

			<!-- <button class="btn waves-effect waves-light right" type="button" name="action" onclick='createEvent();'>Next
				<i class="mdi-content-send right"></i>
			</button> -->
			<div class="row">
				<div class="col s2">
					<a href="{{ action('EventsController@index') }}" class="waves-effect waves-light btn">Cancel</a>
				</div>
				<div class="col s2 push-s8">
					<div class='form-group'>
					{!! Form::submit('Create Event', ['class' => 'btn btn-primary form-control']) !!}
					</div>
				</div>
			</div>
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


@endsection