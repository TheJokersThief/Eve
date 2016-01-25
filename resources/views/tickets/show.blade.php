@extends('layouts.app')
@section('body-class') info-pack @endsection

@section('content')
<main class="container">
	<div class="qr-holder">{!! $ticket->qr() !!}</div>

  <h1 class="green-text">{{$ticket->event->title}}</h1>
  <h2>{{$ticket->event->location->name}}</h2>
  <h3><em>{{$ticket->event->hrStartTime()}}</em> to <em>{{$ticket->event->hrEndTime()}}</em></h3>

  <ul class="partners">
    @foreach($ticket->event->partners as $partner)
      <li>{{$partner->name}}</li>
    @endforeach
  </ul>
</main>
@endsection