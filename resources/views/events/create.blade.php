@extends('layouts.app')

@section('body-class') create-event @endsection

@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script type="text/javascript" src="{{ URL::to('/') . '/js/clockpicker.js'}}"></script>
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

		{!! Form::open( ['url' => 'events'] ) !!}
			
			<div class="row">
				<div class="input-field col m6 s12">
					{!! Form::label('title','Event Title')	!!}
					{!! Form::text('title')	!!}
				</div>
				<div class="input-field col m6 s12">
					{!! Form::label('description','Event Description')	!!}
					{!! Form::text('description') !!}
				</div>
			</div>

			<div class="row">

				<div class="col m6 s6">
					<input name="start_date" id="start_date" type="date" class="datepicker">
					<label for="start_date">Start Date</label>
				</div>

				<div class="col m6 s6">
					<input name="end_date" id="input_enddate" type="date" class="datepicker">
					<label for="input_enddate">End Date</label>
				</div>

				<!-- <div class="col m6 s6">
					<label for"start_time">Start Time</label>
				</div>
				<div class="col m6 s6">
					<label for"end_time">End Time</label>
				</div>

				<div id="start_time" class="col m3 s3">
					{!! Form::label('start_hour','Hour')!!}
					{!! Form::selectRange('start_hour', 00, 23) !!}
				</div>

				<div id="start_time" class="col m3 s3">
					{!! Form::label('start_minute','Minute')!!}
					{!! Form::selectRange('start_minute', 00, 59) !!}
				</div>

				<div id="end_time" class="col m3 s3">
					{!! Form::label('end_hour','Hour')!!}
					{!! Form::selectRange('end_hour', 00, 23) !!}
				</div>

				<div id="end_time" class="col m3 s3">
					{!! Form::label('end_minute','Minute')!!}
					{!! Form::selectRange('end_minute', 00, 59) !!}
				</div> -->

				<div class="input-field col m12 s12">
					{!! Form::label('location_id','Location Id')!!}
					{!! Form::number('location_id')	!!}
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
				<div class="col s2 push-s10">
					<div class='form-group'>
					{!! Form::submit('Create Event', ['class' => 'btn btn-primary form-control']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>

@stop