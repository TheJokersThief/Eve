@extends('layouts.app')
@section('body-class') ticket-verify @endsection
@section('title') Error! @endsection

@section('content')
	<h1 class="red-text">An error has occured!</h1>
  <h2>{{$error}}</h2>
@endsection