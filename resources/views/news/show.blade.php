@extends('layouts.app')

@section('body-class') show-news @endsection
@section('title') {{ _t($news->title) }} @endsection


@section('content')

	<main class="row">
		<div class="parallax-container valign-wrapper">
			<div class="parallax">
				<img src="{{ $news->featured_image }}">
			</div>
			<div class="row center-align title">
				<h1>{{ _t($news->title) }}</h1>
			</div>
		</div>
		<div class="row content">
			<div class="col l8 offset-l2 card white">
				<p class="red-text text-lighten-2">{{ date( 'M m, Y', strtotime( $news->created_at ) ) }}</p>
				{!! _t($news->content) !!}

				<div class="row">
					{{_t('Tags: ')}}
					@forelse( explode( ',', trim($news->tags) ) as $tag )
						<div class="chip">
							{{ trim( _t($tag) ) }}
						</div>
					@empty

					@endforelse

					@if( Auth::user()->is_admin )
						<a href="{{ URL::route('news.edit', [$news->id] ) }}" class="red-text text-lighten-2 right">
							{{_t('Edit')}} &rarr;
						</a>
					@endif
				</div>
			</div>
		</div>
	</main>
@endsection
