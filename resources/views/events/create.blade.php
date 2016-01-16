@extends('layouts.app')

@section('content')
	<h1>Create a New Event</h1>

</hr>
{!! Form::open(['url' => 'articles']) !!}
	@include('events.form',['submitButtonText' => 'Add Event'])
{!! Form::close() !!}

@stop