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

<div class="row z-depth-2" id="events">
    <div class="parallax-container">
        <div class="parallax"><img src="{{ URL::to('/') . '/images/red-geometric-background.png'}}"></div>
        <div class="col s12 m10 offset-m1">
            <h3>Upcoming Events</h3>
            @foreach(App\Event::take(3)->get() as $event)
                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ URL::to('/') . '/images/sample_images/event_photos/event'.$event->id.'.jpg' }}">
                            <span class="card-title">{{$event->title}}.</span>
                        </div>
                        <div class="card-content">
                            <p>{{$event->description}}</p>
                        </div>
                        <div class="card-action">
                            <a href="{{ action('EventsController@show', $event->id) }}" class="red-text text-lighten-2">View Event &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row remove-col-padding" id="venues">
    <h3>Latest Venues</h3>

    @for( $i = 1; $i < 9; $i++)
        <div class="col s6 m3">
            <div class="card hoverable">
                <div class="card-image">
                    <a href="#!">
                        <img src="{{ URL::to('/') . '/images/sample_images/hotels/'.$i.'.jpg' }}" />
                        <span class="card-title">Venue {{ $i }}</span>
                    </a>
                </div>
            </div>
        </div>
    @endfor
</div>

<div class="row" id="latest">
    <div class="parallax-container">
        <div class="parallax"><img src="{{ URL::to('/') . '/images/gray-geometric-background.jpg'}}"></div>

        <div class="col s12 m10 offset-m1">
            <h3 class="card">Latest News</h3>

            @for( $i = 1; $i < 7; $i++)
                <div class="col s6 m4">
                    <div class="card">
                        <div class="card-content">
                            <h5>News Title {{ $i }}</h5>
                            <p class="red-text text-lighten-2">{{ date( 'M m, Y') }}</p>
                            <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
                            <a href="#!" class="waves-effect waves-light btn red lighten-1">Read More</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

    </div>
</div>

<div class="row remove-col-padding" id="photos">
    @for( $i = 1; $i <= 12; $i++)
        <div class="col s6 m3">
            <div class="card hoverable">
                <div class="card-image center-cropped" style="background-image: url('{{ URL::to('/') . '/images/sample_images/event_photos/'.$i.'.jpg' }}');">
                    <img src="{{ URL::to('/') . '/images/sample_images/event_photos/'.$i.'.jpg' }}" id="{{$i}}-image" />
                </div>
            </div>
        </div>
    @endfor
</div>
@endsection
