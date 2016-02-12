<main class="row">
	<div class="grid popup-gallery">
		{{-- <div class="row"> --}}
		<div class="grid-sizer col s6 m3"></div>
		@foreach( $event->media as $item )
			<a class="col s6 m3 grid-item no-padding" id="{{ 'media_'.$item->id }}" href="{{ $item->file_location }}" title="{{ $item->name }}">
				<img src="{{ $item->file_location }}">
			</a>
		@endforeach
		{{-- </div> --}}
	</div>
</main>

@section('extra-js')
<script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
	<script type="text/javascript">

jQuery(document).ready(function($){
	$(document).ready(function(){
			var $grid = $('.grid').masonry({
				itemSelector: '.grid-item',
				// percentPosition: true,
				gutter:0,
				fitWidth: true,
				// containerStyle: null
			});

			setInterval(function(){
				$grid.masonry();
			}, 500);
		});

      //popup-gallery
      $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: true,
        fixedContentPos: true,
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
          verticalFit: true,
          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
          titleSrc: function(item) {
            return item.el.attr('title');
          },
        zoom: {
          enabled: true,
          duration: 300 // don't foget to change the duration also in CSS
        }
        }
      });
});

</script>
@endsection
