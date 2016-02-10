@extends('layouts.app')

@section('body-class') edit-partner @endsection
@section('title') Editing Partner: {{$partner->name}} @endsection

@section('extra-css')
@endsection

@section('extra-js')
	<script type="text/javascript">
		fillInfo();
	</script>
@endsection

@section('content')


<main class="container row">
	<div class="col m8 offset-m2 s12">
		{!! Form::open( ['method' => 'PUT', 'route' => ['partners.update', $partner->id] , 'id' => 'partner-form', 'files' => true] ) !!}

		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('name', $partner->name, ['placeholder' => 'Partner Name', 'id' => 'name']) !!}
				{!! Form::label('name', 'Partner Name:') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12 m6">
				{!! Form::text('type', $partner->type, ['placeholder' => 'e.g. Hotel, Restaurant', 'id' => 'type']) !!}
				{!! Form::label('type', 'Partner Type:') !!}
			</div>
			<div class="input-field col s12 m6">
				{!! Form::number('price', $partner->price, ['id' => 'price', 'step' => 'any', 'min' => '0']) !!}
				{!! Form::label('price', 'Average Price:') !!}
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<select name="location_id" id="location-select" onChange="if(this.value==-1){$('#locationForm').openModal();}">
					<option value="" disabled selected>Choose location</option>
					@foreach($locations as $location)
						<option value="{{$location->id}}"
@if($location->id == $partner->location->id)
selected
@endif
						>{{$location->name}}</option>
					@endforeach
				</select>
				<label>Location Select</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				{!! Form::textarea('description', $partner->description, ['id' => 'description', 'class' => 'materialize-textarea']) !!}
				{!! Form::label('description', 'Partner Description:') !!}
			</div>
		</div>

		<div class="row"><!-- To be calculated by the Google API in a later version -->
			<div class="input-field col s12 m6">
				{!! Form::number('distance', $partner->distance, ['id' => 'distance', 'step' => 'any', 'min' => '0'] ) !!}
				{!! Form::label('distance', 'Distance:') !!}
			</div>
			<div class="file-field input-field col s12 m6">
				<div class="btn">
					<span>Feature Image</span>
					{!! Form::file('picture') !!}
					<!--<input type="file">-->
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				{!! Form::text('email', $partner->email, ['placeholder' => 'name@host.com', 'id' => 'email']) !!}
				{!! Form::label('email', 'Contact email:') !!}
			</div>
		</div>
			<div class="col s2 right">
				<div class='form-group'>
					{!! Form::submit('Update Partner', ['class' => 'btn btn-primary form-control', 'id' => 'partner-button']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</main>

@endsection
