@extends('layouts.app')

@section('body-class') locations @endsection
@section('title') Creating a location @endsection


@section('content')

	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3">
			<h2>Add New Location:</h2>
			{!! Form::open( ['route' => 'locations.store', 'files' => true] ) !!}
				<div class="row">
					<div class="input-field col m5 s12">
						{!! Form::label('name','Location Title')	!!}
						{!! Form::text('name')	!!}
					</div>
					<div class="input-field col m5 s12">
						{!! Form::label('coordinates','Coordinates')	!!}
						{!! Form::text('coordinates')	!!}
					</div>
					<div class="input-field col m2 s12">
						{!! Form::label('capacity','Capacity')	!!}
						{!! Form::number('capacity')	!!}
					</div>
				</div>

				<div class="row">
					<div class="file-field input-field col s12">
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
					<div class="col s2 right">
						<div class='form-group'>
							{!! Form::submit('Create Location &rarr;', ['class' => 'btn btn-primary form-control', 'id' => 'news-button']) !!}
						</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>

@endsection
