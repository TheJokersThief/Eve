@extends('layouts.app')

@section('body-class') usersEvent-page usersAccount-page @endsection

@section('content')
	<main class="row">
	
		{!! Form::open([
			"route" => 'search',
			"method" => "GET"
		]) !!}

	    {!! Form::text('search', 
				null, 
				array('required',
                'class'=>'form-control',
                'placeholder'=>'Search for a user'))
	    !!}

	    {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}

		{!! Form::close() !!}
	</main>
@endsection

