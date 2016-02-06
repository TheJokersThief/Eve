@extends('layouts.app')

@section('body-class') userProfile-page @endsection

@section('content')
<main class="container">
    <div class="section">
        <div class="row">
            <div class="col s6 m4 l3">
                <img class="responsive-img circle" src="{{$user->profile_picture}}">
            </div>
            <div class="col s12 m8 l9">
                <h1>{{$user->name}}</h1>
            </div>
        </div>
    </div>
    <div class="section">
       <p class="flow-text">{{ $user->bio }}</p>
    </div>
    <div class="divider"></div>
    <div class="section">
        <div class="row">
            <div class="col s6"><h5>Email:</h5></div>
            <div class="col s6"><h5>Language:</h5></div>
            <div class="col s6">{{ $user->email }}</div>
            <div class="col s6">{{ $user->language }}</div>
        </div>
    </div>
    <div class="divider"></div>
    <div class="section">
        <div class="row">
            <div class="col s6"><h5>Country:</h5></div>
            <div class="col s6"><h5>City:</h5></div>
            <div class="col s6">{{ $user->country }}</div>
            <div class="col s6">{{ $user->city }}</div>
        </div>
    </div>
    <div class="divider"></div>

    <div class="section">
    <h2>Events Attending</h2>
        @foreach($events as $event)
            <a href="{{ action('EventsController@show', [$event->id]) }}" class="collection-item">{{ $event->title }}</a>
        @endforeach
    </div>
</main>
@endsection