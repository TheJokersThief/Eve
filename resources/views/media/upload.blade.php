@extends('layouts.app')

{{-- The sections detailed here are for viewing a singular page. If you wish to include this modal into another page, the appropriate sections must copied into the parent page's sections as well. Otherwise, only the "content" section will be visible --}}

@section('body-class') @parent media-upload @endsection

@section('extra-js')
	@parent
	<script type="text/javascript">
		$(document).ready(function( ){
			initDropzone( );
		});
	</script>
@endsection

@section('content')
	@parent
	<div id="media-modal" class="modal">
		<div class="modal-content">
			<div class="row ">
				<div class="col s12 m6 l6">
					<ul class="collection with-header">
						<li class="collection-header"><h4>Your Images</h4></li>
					@foreach( $images as $image )
						<li class="collection-item" id="{{ Crypt::encrypt($image->id) }}">
							<div>
								<img src="{{ $image->file_location }}" class="col s3"/>
								{{ $image->name }}
								<a href="#!" class="secondary-content">
									<i class="fa fa-times red-text"
										onclick="
											// Send the delete request
											deleteImage( '{{ Crypt::encrypt($eventID) }}', '{{ Crypt::encrypt($image->id) }}' );
											// Hide the element
											$(this).parents('a').parents('div').parents('li').hide();
										"></i>
								</a>
							</div>
						</li>
					@endforeach
					</ul>
				</div>
				<div class="col s12 m6 l6">
					<form action="{{ URL::route('api/media/upload', Crypt::encrypt( $event->id )) }}" class="dropzone center-align valign-wrapper" id="fileupload" ></form>

					<div class="col s12">
						<ul class="collection uploaded-images">

						</ul>

					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
		</div>
	</div>
@endsection
