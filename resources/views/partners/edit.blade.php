@extends('layouts.app')

@section('body-class') edit-partner @endsection
@section('title') Editing Partner: {{$partner->name}} @endsection

@section('extra-css')
@endsection

@section('extra-js')
@endsection

@section('content')


<main class="container row">
	<div class="col m8 offset-m2 s12">
		{!! Form::open( ['method' => 'PUT', 'route' => ['partners.update', $partner->id] , 'id' => 'partner-form', 'files' => 'true'] ) !!}

			<div class="col s2 right">
				<div class='form-group'>
					{!! Form::submit('Update Partner', ['class' => 'btn btn-primary form-control', 'id' => 'partner-button']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</main>

@endsection
