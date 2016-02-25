@extends('layouts.app')
@section('title') {{ App\Setting::where('name', 'company_name')->first()->setting }} @endsection
@section('body-class') home-page @endsection

@section('before-page')
<header class="parallax-container welcome-page-parallax z-depth-2">
	<div class="parallax">

		@if( !isset( $event ) || $event->featured_image == "" )
			<video width="100%" autoplay loop style="max-width:100%">
				<source src="{{URL::to('/')}}/images/video.webm" type="video/webm">
				<source src="{{URL::to('/')}}/images/video.mp4" type="video/mp4">
				<img src="{{URL::to('/')}}/images/video.jpg">
			</video>
		@else
			<img src="{{ $event->featured_image }}" />
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
					<h2>{{ _t(App\Setting::where('name', 'description')->first()->setting) }}</h2>
				@else
					<h1>{{ _t($event->title) }}</h1>
					<h2>{{ _t($event->tagline) }}</h2>
					<br />
					<a href="{{ URL::route('events.show', ['id' => $event->id]) }}" class="btn-large waves-effect waves-light teal lighten-1"><i class="fa fa-calendar left"></i> {{ _t('Learn More') }}</a>
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
			<h3>{{_t('Upcoming Events')}}</h3>
			@foreach(App\Event::take(3)->get() as $event)
				<div class="col s12 m4">
					<div class="card">
						<div class="card-image">
							<img src="{{ $event->featured_image }}">
							<span class="card-title">{{ _t($event->title) }}.</span>
						</div>
						<div class="card-content">
							<p>{{strip_tags(str_limit(_t($event->description),250))}}</p>
						</div>
						<div class="card-action">
							<a href="{{ URL::route('events.show', $event->id) }}" class="red-text text-lighten-2"> {{ _t('View Event') }} &rarr;</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

<?php $event = App\Event::first(); ?>
<div class="row" id="venues">
	<div class="parallax-container valign-wrapper">
		<div class="parallax"><img src="{{ $event->location->featured_image }}"></div>
		<div class="col s12 m10 offset-m1 valign center">
			<h2 class="white-text">{{ _t($event->location->name) }}</h2>
			<h4 class="white-text">{{ _t(date( 'g:iA, D jS F ', strtotime($event->hrStartTime()))) }} &rarr; {{ _t(date( 'g:iA, D jS F ', strtotime($event->hrEndTime()))) }}</h4>
		</div>
	</div>
</div>

<div class="row" id="latest">
	<div class="parallax-container">
		<div class="parallax"><img src="{{ URL::to('/') . '/images/gray-geometric-background.jpg'}}"></div>

		<div class="col s12 m10 offset-m1">
			<h3 class="card">{{_t('Latest News')}}</h3>

			@foreach($news as $item)
				<div class="col s6 m4">
					<div class="card">
						<div class="card-content">
							<h5>{{ _t($item->title) }}</h5>
							<p class="red-text text-lighten-2">{{ _t(date( 'M m, Y', strtotime($item->created_at))) }}</p>
							<p>{{  strip_tags(str_limit( _t($item->content), 250 )) }}</p>
							<a href="{{ URL::route('news.show', $item->id ) }}" class="waves-effect waves-light btn red lighten-1">{{_t('Read More')}}</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>

	</div>
</div>

<div class="row remove-col-padding" id="photos">
	@foreach($media as $item)
		<div class="col s6 m3">
			<div class="card hoverable">
				<div class="card-image center-cropped" style="background-image: url('{{ $item->file_location }}');">
					<img src="{{ $item->file_location }}" />
				</div>
			</div>
		</div>
	@endforeach
</div>
@endsection
