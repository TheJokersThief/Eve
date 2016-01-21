@extends('layouts.app')

@section('body-class') home-page @endsection


@section('before-page')
<header class="parallax-container welcome-page-parallax z-depth-2">
    <div class="parallax">

        @if( !isset( $event ) || $event->media()->file_location != "" )
            <video width="100%" autoplay loop style="max-width:100%">
                <source src="{{URL::to('/')}}/images/video.webm" type="video/webm">
                <source src="{{URL::to('/')}}/images/video.mp4" type="video/mp4">
                <img src="{{URL::to('/')}}/images/video.jpg">
            </video>
        @else
            <img src="{{ $event->media()->file_location }}" />
        @endif
    </div>
@endsection


@section('content')

    <div class="valign-wrapper container row welcome-page-hero">
        <div class="col s12 valign">
            <hr/>
            <div class="s12 center-align">
                @if( !isset( $event ) )
                    <h1>{{ App\Setting::where('name', 'company_name')->first()->setting }}</h1>
                    <h2>{{ App\Setting::where('name', 'description')->first()->setting }}</h2>
                @else
                    <h1>{{ $event->title }}</h1>
                    <h2>{{ $event->description }}</h2>
                    <a href="{{ URL::route('event.show', ['id' => $event->id]) }}" class="btn-large waves-effect waves-light teal lighten-1"><i class="fa fa-calendar left"></i> Learn More</a>
                @endif
            </div>
            <hr/>
        </div>
    </div>
<!-- End Parallax container -->
</header>

<div class="row">
    <div class="col s12 m8 offset-m2">
        <h2>Upcoming Events</h2>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <img src="http://placehold.it/500x500">
                    <span class="card-title">Event Title</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                </div>
                <div class="card-action">
                    <a href="#">This is a link</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
