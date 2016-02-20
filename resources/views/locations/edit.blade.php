@extends('layouts.app')

@section('body-class') locations @endsection
@section('title') Edit: {{$item->name}} @endsection


@section('content')
	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3">
			<h2>Edit Location:</h2>
			{!! Form::open( ['route' => ['locations.update', $item->id], 'files' => true, 'method' => 'PUT'] ) !!}
				<div class="row">
					<div class="input-field col m5 s12">
						{!! Form::label('name','Location Title')	!!}
						{!! Form::text('name', $item->name)	!!}
					</div>
					<div class="input-field col m5 s12">
						{!! Form::label('latitude','Latitude')	!!}
						{!! Form::number('latitude', $item->latitude)	!!}
					</div>
					<div class="input-field col m5 s12">
						{!! Form::label('longitude','Longitude')	!!}
						{!! Form::number('longitude', $item->longitude)	!!}
					</div>
					<div class="input-field col m2 s12">
						{!! Form::label('capacity','Capacity')	!!}
						{!! Form::number('capacity', $item->capacity)	!!}
					</div>
				</div>

				<div class="row">
					<div class="col m4">
						<img src="{{ $item->featured_image }}" />
					</div>
					<div class="file-field input-field col s12 m8">
						<div class="btn">
							<span>Add Image</span>
							{!! Form::file('featured_image') !!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s3 left">
						<div class='form-group'>
							<a class="waves-effect waves-light btn" href="{{ URL::route('locations.index') }}">&larr; All Locations</a>
						</div>
					</div>
					<div class="col s2 right">
						<div class='form-group'>
							{!! Form::submit('Update Location &rarr;', ['class' => 'btn btn-primary form-control', 'id' => 'news-button']) !!}
						</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

@endsection
