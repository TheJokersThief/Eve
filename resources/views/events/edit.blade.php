@extends('layouts.app')

@section('body-class') edit-event @endsection
@section('title') Edit: {{$event->title}} @endsection


@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.clockpicker').clockpicker({
				placement: 'bottom',
			    align: 'left',
			    donetext: 'Done'
			});

			tinymce.init({
			  selector: 'div.editable',
			  inline: true,
			  plugins: [
			    'advlist autolink lists link image charmap print preview anchor',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media table contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			});

			if( $('input[name=description_content]').val() != '' ){
				$('.content').html($('input[name=description_content]').val());
			}
		});
	</script>
@endsection

@section('content')

<div class="row">
	<div class="col m8 offset-m2">
		<div class="row">
			<div class="col s12">
				<h1>Edit an Event</h1>
			</div>
		</div>

		</hr>
		{!! Form::model($event, ['method' => 'PUT', 'action' => ['EventsController@update', $event->id], 'files' => true]) !!}
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
					<h5>Description:</h5>
					<div class="editable content" id="description">
					  <p>
					    Start typing your description here!
					  </p>
					</div>
					{!! Form::hidden('description_content', $event->description)	!!}
				</div>
			</div>

			<div class="row">

				<div class="col m6 s6">
					<label for="start_date">Start Date</label>
					<input name="start_date" id="start_date" value="{{$startDate}}" type="date" class="datepicker">
				</div>

				<div class="col m6 s6">
					<label for="input_enddate">End Date</label>
					<input name="end_date" id="input_enddate" value="{{$endDate}}" type="date" class="datepicker">
				</div>

				<div class="input-field col m6 s6">
					{!! Form::label('price','Price') !!}
					{!! Form::number('price', $event->price, ['step' => 0.01]) !!}
				</div>

				<div class="col m6 s6">
					{!! Form::label('featured_image','Choose Image')	!!}
					{!! Form::file('featured_image') !!}
				</div>

			</div>

	      	<div class="row">
		      	<div class="input-field col s6">
		    		<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();}">
						@foreach($locations as $location)
							@if( $location == $event->location )
								<option value="{{$location->id}}" selected>{{$location->name}}</option>
							@else
								<option value="{{$location->id}}">{{$location->name}}</option>
							@endif
						@endforeach
						<option value="-1">Create New Location</option>
		    		</select>
		    		<label>Location Select</label>
		  		</div>
		  		<div class="input-field col s6">
		    		<select multiple name="partner_id[]" id="partner-select">
		      			<option value="" disabled selected>Choose partner</option>
						@foreach($allPartners as $partner)
							<option value="{{$partner->id}}" {{$selected = (in_array($partner->id, $eventPartnersId) ?
									 'selected' : '')}} {{$selected}}>{{$partner->name}}</option>
						@endforeach
		    		</select>
		    		<label>Partner Select</label>
		  		</div>
			</div>

			<div class="row">
				<div class="col s4">
					<label for="start_time">Start Time</label>
					<div id="start_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="start_time" type="text" class="form-control" value="{{$startTime}}">
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
				<div class="col s4">
					<label for="end_time">End Time</label>
					<div id="end_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="end_time" type="text" class="form-control" value="{{$endTime}}">
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s2">
					<a href="{{ action('EventsController@show', [$event->id]) }}" class="waves-effect waves-light btn">Cancel</a>
				</div>
				<div class="col s2 push-s8">
					<div class='form-group'>
					{!! Form::submit('Update Event', ['class' => 'btn btn-primary form-control']) !!}
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
		{!! Form::open( ['url' => 'events'] ) !!}
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
