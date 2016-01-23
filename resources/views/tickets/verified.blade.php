@extends('layouts.app')

@section('content')
	<h1 class="green-text">Ticket verified!</h1>
  <div class="row">
    <div class="col s12 m6">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">{{$ticket->user()->name}}</span>
          <p>{{$ticket->event()->name}}</p>
          <p>{{$ticket->event()->name}}</p>
        </div>
      </div>
    </div>
  </div>
@endsection