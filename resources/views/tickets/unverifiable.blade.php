@extends('layouts.app')
@section('body-class') ticket-verify @endsection

@section('content')
	<h1 class="green-text">An error has occured!</h1>
  <h2>{{$error}}</h2>
@endsection