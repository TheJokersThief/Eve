@extends('layouts.app')

@section('body-class') show-news @endsection

@section('content')
	
	<main class="row">
		<div class="parallax-container valign-wrapper">
			<div class="parallax">
				<img src="{{ $news->featured_image }}">
			</div>
			<div class="row center-align title">
				<h1>{{ $news->title }}</h1>
			</div>
		</div>
		<div class="row content">
			<div class="col l8 offset-l2 card white">
				<p class="red-text text-lighten-2">{{ date( 'M m, Y', strtotime( $news->created_at ) ) }}</p>
				{!! $news->content !!}
				
				<div class="row">
					Tags: 
					@forelse( explode( ',', trim($news->tags) ) as $tag )
						<div class="chip">
							{{ trim( $tag ) }}
						</div>
					@empty

					@endforelse

					@if( Auth::user()->is_admin )
						<a href="{{ URL::route('news.edit', [$news->id] ) }}" class="red-text text-lighten-2 right">
							Edit &rarr;
						</a>
					@endif
				</div>
			</div>
		</div>
	</main>
@endsection