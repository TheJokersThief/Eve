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
		<div class="col s12">
			<form action="{{ URL::route('api/media/upload', Crypt::encrypt( $event->id )) }}" class="dropzone center-align valign-wrapper" id="fileupload" ></form>
		</div>
		<div class="col s12">
			<ul class="collection uploaded-images">

			</ul>

		</div>
	</main>
@endsection
