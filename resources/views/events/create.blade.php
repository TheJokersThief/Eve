@extends('layouts.app')

@section('body-class') create-event @endsection

@section('title') {{_t('Create an Event')}} @endsection


@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKOjys2eW4gpc3KmoBlVOjQ-SqHWgyvwI&libraries=places"></script>
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

			initEvents();

			// Scroll to top of modal to view errors
			$("#submitButton").click(function(){
				setTimeout(function(){
					$('#locationForm').scrollTop(0);
				}, 1000);
			});
		});
	</script>
@endsection

@section('content')

<!-- Create a new event title -->
<div class="row">
	<div class="col m8 offset-m2">
		<div class="row">
			<div class="col s12">
				<h1>{{_t('Create a New Event')}}</h1>
			</div>
		</div>

		</hr>

		<!-- Open a new form, allowing for file uploads -->
		{!! Form::open( ['route' => 'events.store', 'files' => true] ) !!}

			<div class="row">
				<!-- Input title -->
				<div class="input-field col m6 s12">
					{!! Form::label('title',_t('Event Title'))	!!}
					{!! Form::text('title')	!!}
				</div>
				<!-- Input tagline -->
				<div class="input-field col m6 s12">
					{!! Form::label('tagline',_t('Event Tagline'))	!!}
					{!! Form::text('tagline') !!}
				</div>
				<!-- Input description -->
				<div class="input-field col m12 s12">
					<h5>{{_t('Description:')}}</h5>
					<div class="editable content" id="description">
					  <p>
					    {{_t('Start typing your description here!')}}
					  </p>
					</div>
				</div>
			</div>

			<div class="row">
				<!-- Select start date -->
				<div class="col m6 s6">
					<label for="start_date">{{_t('Start Date')}}</label>
					<input name="start_date" id="start_date" type="date" value="" class="datepicker">
				</div>
				<!-- Select end date -->
				<div class="col m6 s6">
					<label for="input_enddate">{{_t('End Date')}}</label>
					<input name="end_date" id="input_enddate" type="date" value="" class="datepicker">
				</div>
				<!-- Input price if ticket -->
				<div class="input-field col m6 s6">
					{!! Form::label('price',_t('Price')) !!}
					{!! Form::number('price', '5.00', ['step' => 0.01]) !!}
				</div>
				<!-- Upload feature image -->
				<div class="file-field input-field col s12 m6">
					<div class="btn">
						<span>{{_t('Feature Image')}}</span>
						{!! Form::file('featured_image') !!}
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>

			</div>

	      	<div class="row">
	      		<!-- Select location or create a new location -->
		      	<div class="input-field col s6">
		    		<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();google.maps.event.trigger(map, 'resize');}">
		      			<option value="" disabled selected>{{_t('Choose location')}}</option>
						@foreach($locations as $location)
							<option value="{{$location->id}}">{{ $location->name }}</option>
						@endforeach
						<option value="-1" >{{_t('Create New Location')}}</option>
		    		</select>
		    		<label>{{_t('Location Select')}}</label>
		  		</div>
		  		<!-- Choose a partner for the event -->
		  		<div class="input-field col s6">
		    		<select multiple name="partner_id[]" id="partner-select">
		      			<option value="" disabled selected>{{_t('Choose partner')}}</option>
						@foreach($partners as $partner)
							<option value="{{$partner->id}}">{{$partner->name}}</option>
						@endforeach
		    		</select>
		    		<label>{{_t('Partner Select')}}</label>
		  		</div>
			</div>

			<div class="row">
				<!-- Select a start time -->
				<div class="col s4">
					<label for="start_time">{{_t('Start Time')}}</label>
					<div id="start_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="start_time" type="text" class="form-control" readonly>
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
				<!-- Select an end time -->
				<div class="col s4">
					<label for="end_time">{{_t('End Time')}}</label>
					<div id="end_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="end_time" type="text" class="form-control" readonly>
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
			</div>

			<div class="row">
				<!-- Button for submitting the new event -->
				<div class="col s6">
					<a href="{{ action('EventsController@index') }}" class="waves-effect waves-light btn">{{_t('Cancel')}}</a>
				</div>
				<div class="col s6">
					<div class='form-group'>
					{!! Form::submit( _t('Create Event'), ['class' => 'btn btn-primary form-control']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

@include("forms.locationmodal")

@endsection
