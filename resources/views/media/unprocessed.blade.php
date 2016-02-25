@extends('layouts.app')

@section('body-class') unprocessed-media-page @endsection
@section('title') {{_t('Unprocessed Media')}} @endsection


@section('extra-js')
	<script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
	<script type="text/javascript">
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
	</script>
@endsection

@section('content')
	<main class="grid row">
		@foreach($media as $row)
			{{-- <div class="row"> --}}
			<div class="grid-sizer col s6 m3"></div>
			@foreach( $row as $item )
				<div class="col s6 m3 grid-item" id="{{ 'media_'.$item->id }}">
					<div class="card">
						<div class="card-image">
							<img src="{{ $item->file_location }}">
							<span class="card-title">{{ {{_t('$item->name')}} }}

								<div class="col s12 valign-wrapper">
									<a href="#!" class="valign btn-floating green lighten-4">
										<i alt="Approve" class="fa fa-check green-text left" onclick="approveMedia('{{ Crypt::encrypt( $item->id ) }}', 'true', '{{ 'media_'.$item->id }}' );"></i>
									</a>&nbsp;
									<a href="#!" class="valign btn-floating red lighten-4">
										<i alt="Reject" class="fa fa-times red-text right left" onclick="approveMedia('{{ Crypt::encrypt( $item->id ) }}', 'false', '{{ 'media_'.$item->id }}' );"></i>
									</a>
								</div>
							</span>
						</div>
					</div>
				</div>
			@endforeach
			{{-- </div> --}}
		@endforeach
	</main>
@endsection
