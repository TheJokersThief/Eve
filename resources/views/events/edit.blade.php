@extends('layouts.app')

@section('body-class') edit-event @endsection
@section('title') {{_t('Edit:')}} {{_t($event->title)}} @endsection


@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>{{!! Same as create, TODO !!}}
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
				<h1>{{_t('Edit an Event')}}</h1>
			</div>
		</div>

		</hr>
		<!-- Open a form, filling it with data from the existing model, allowing file uploads -->
		{!! Form::model($event, ['method' => 'PUT', 'action' => ['EventsController@update', $event->id], 'files' => true]) !!}
			<div class="row">
				<!-- Input a title -->
				<div class="input-field col m6 s12">
					{!! Form::label('title',_t('Event Title'))	!!}
					{!! Form::text('title')	!!}
				</div>
				<!-- Input a tagline -->
				<div class="input-field col m6 s12">
					{!! Form::label('tagline',_t('Event Tagline'))	!!}
					{!! Form::text('tagline') !!}
				</div>
				<!-- Input a description -->
				<div class="input-field col m12 s12">
					<h5>{{_t('Description:')}}</h5>
					<div class="editable content" id="description">
					  <p>
					    {{_t('Start typing your description here!')}}
					  </p>
					</div>
					{!! Form::hidden('description_content', _t($event->description))	!!}
				</div>
			</div>

			<div class="row">
				<!-- Input a start date -->
				<div class="col m6 s6">
					<label for="start_date">{{_t('Start Date')}}</label>
					<input name="start_date" id="start_date" value="{{$startDate}}" type="date" class="datepicker">
				</div>
				<!-- Input an end date -->
				<div class="col m6 s6">
					<label for="input_enddate">{{_t('End Date')}}</label>
					<input name="end_date" id="input_enddate" value="{{$endDate}}" type="date" class="datepicker">
				</div>
				<!-- Input a price for tickets -->
				<div class="input-field col m6 s6">
					{!! Form::label('price',_t('Price')) !!}
					{!! Form::number('price', $event->price, ['step' => 0.01]) !!}
				</div>
				<!-- Upload a photo -->
				<div class="col m6 s6">
					<div class="file-field input-field">
						<div class="btn">
							<span>{{_t('Image')}}</span>
							<input type="file" id="featured_image" name="featured_image">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text" disabled placeholder="{{_t('Upload an image')}}">
						</div>
					</div>
				</div>

			</div>

	      	<div class="row">
	      		<!-- Select a location, or create a new one -->
		      	<div class="input-field col s6">
		    		<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();google.maps.event.trigger(map, 'resize');}">
						@foreach($locations as $location)
							@if( $location == $event->location )
								<option value="{{$location->id}}" selected>{{$location->name}}</option>
							@else
								<option value="{{$location->id}}">{{$location->name}}</option>
							@endif
						@endforeach
						<option value="-1">{{_t('Create New Location')}}</option>
		    		</select>
		    		<label>{{_t('Location Select')}}</label>
		  		</div>
		  		<!-- Sleect partner(s) for this event -->
		  		<div class="input-field col s6">
		    		<select multiple name="partner_id[]" id="partner-select">
		      			<option value="" disabled selected>{{_t('Choose partner')}}</option>
						@foreach($allPartners as $partner)
							<option value="{{$partner->id}}" {{$selected = (in_array($partner->id, $eventPartnersId) ?
									 'selected' : '')}} {{$selected}}>{{$partner->name}}</option>
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
					    <input name="start_time" type="text" class="form-control" value="{{$startTime}}" readonly>
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
				<!-- Select and end time -->
				<div class="col s4">
					<label for="end_time">{{_t('End Time')}}</label>
					<div id="end_time" class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
					    <input name="end_time" type="text" class="form-control" value="{{$endTime}}" readonly>
					    <span class="input-group-addon">
					        <span class="glyphicon glyphicon-time"></span>
					    </span>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Submit button for edited event -->
				<div class="col s2">
					<a href="{{ action('EventsController@show', [$event->id]) }}" class="waves-effect waves-light btn">{{_t('Cancel')}}</a>
				</div>
				<div class="col s2 push-s8">
					<div class='form-group'>
					{!! Form::submit( _t('Update Event'), ['class' => 'btn btn-primary form-control']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

<!-- Modal for creating a new location -->
<div id="locationForm" class="modal bottom-sheet">
	<div class="modal-content">
	  <h4>{{_t('Create New Location')}}</h4>
	  <ul id="location-errors"></ul>
		{!! Form::open( ['url' => 'events'] ) !!}
			<div class="row">
				<div class="input-field col m6 s12">
					{!! Form::label('name',_t('Location Name'))	!!}
					{!! Form::text('name')	!!}
				</div>
				<div class="input-field col m6 s12">
					{!! Form::label('capacity',_t('Location Capacity'))	!!}
					{!! Form::number('capacity') !!}
				</div>
				<div class="input-field col m5 s12">
				{!! Form::label('latitude',_t('Latitude'))	!!}
				{!! Form::text('latitude')	!!}
				</div>
				<div class="input-field col m5 s12">
					{!! Form::label('longitude',_t('Longitude'))	!!}
					{!! Form::text('longitude')	!!}
				</div>
			</div>
			<div class="row">
				<div class="input-field s12">
					{!! Form::label('move-marker', 'Search map')!!}
					{!! Form::text('move-marker')!!}
				</div>
				<div id="map" class="col s12 center-align" style="width: 40%; height: 300px;"></div>
			</div>
		{!! Form::close() !!}
	</div>
	<div class="modal-footer">
	  <a href="#!" class="orange-text modal-action waves-effect waves-green btn-flat" onClick="createLocation()">{{_t('Create')}}</a>
	  <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat" onClick="$('#location-select').val('');$('#location-select').material_select();">{{_t('Cancel')}}</a>
	</div>
</div>

@endsection
