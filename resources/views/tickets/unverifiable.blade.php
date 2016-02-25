@extends('layouts.app')
@section('body-class') ticket-verify @endsection
@section('title') {{_t('Error!')}} @endsection

@section('content')
	<h1 class="red-text">{{_t('An error has occured!')}}</h1>
  <h2>{{$error}}</h2>
@endsection
