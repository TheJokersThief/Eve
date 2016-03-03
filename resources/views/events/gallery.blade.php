<main class="row">
	<div class="grid popup-gallery">
		{{-- <div class="row"> --}}
		<div class="grid-sizer col s6 m3"></div>
		@foreach( $event->media as $item )
			<a class="col s6 m3 grid-item no-padding" id="{{ 'media_'.$item->id }}" href="{{ $item->file_location }}" title="{{ _t($item->name) }}">
				<img src="{{ $item->file_location }}">
			</a>
		@endforeach
		{{-- </div> --}}
	</div>
</main>
