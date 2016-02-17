@extends('layouts.app')

@section('title') Upload Files @endsection
@section('body-class') media-upload @endsection

@section('extra-js')
	<script type="text/javascript">
		$(document).ready(function( ){
			initDropzone( );
		});
	</script>
@endsection

@section('content')
	<main class="row container">
		<div class="col s12 m6 l6">
			<ul class="collection with-header">
				<li class="collection-header"><h4>First Names</h4></li>
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
	</main>
@endsection
