@extends('layouts.app')

@section('body-class') create-news @endsection

@section('extra-css')
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/') . '/css/clockpicker.css' }}">
@endsection

@section('extra-js')
	<script src="http://cdn.tinymce.com/4/tinymce.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			tinymce.init({
			  selector: 'h2.editable',
			  inline: true,
			  toolbar: 'undo redo',
			  menubar: false
			});

			tinymce.init({
			  selector: 'div.editable',
			  inline: true,
			  plugins: [
			    'advlist autolink lists link image charmap print preview anchor',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media table contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			});

			fillInfo();
		});
	</script>
@endsection

@section('content')


<main class="row">
	<div class="col m8 offset-m2 s12">
		{!! Form::open( ['route' => 'news.store', 'id' => 'news-form', 'files' => 'true'] ) !!}
			
			<div class="row">
				<h2 class="editable title">Your Title Here</h2>
				{!! Form::hidden('title')	!!}

				<div class="editable content" placeholder="Start typing your content here!">
				  <p>
				    Start typing your content here!
				  </p>
				</div>
				{!! Form::hidden('content')	!!}
			</div>
			
			<div class="collection">
				<div class="row col m6 l4">
					<div class="input-field col m12 s12">
						{!! Form::label('tags','Tags (Comma-separated)') !!}
						{!! Form::text('tags')	!!}
					</div>
				</div>
				<div class="row col m6 l8">
					<div class="col s12 m3 offset-m3">
						<img src="{{ App\Setting::where('name', 'default_profile_picture')->first()->setting }}" id="image-preview">
					</div>

					<div class="file-field input-field col m6 s12">
						<div class="btn">
							<span>Add Image</span>
							{!! Form::file('featured_image') !!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col s2 right">
					<div class='form-group'>
						{!! Form::submit('Create News', ['class' => 'btn btn-primary form-control', 'id' => 'news-button']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</main>

@endsection