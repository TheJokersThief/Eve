@extends('layouts.app')

@section('content')

	<ul class="collection with-header">
	    <li class="collection-header"><h4>Partners</h4></li>
	    <div class="row">
		    @foreach($partners as $partner)
		    	<div class="col s4">
		            <div class="card">
					    <div class="card-image waves-effect waves-block waves-light">
					    	<img class="activator" src="{{ URL::to('/') }}/{{$partner->media->file_location}}">
					    </div>
					    <div class="card-content">
					    	<span class="card-title activator grey-text text-darken-4">{{$partner->name}}<i class="material-icons right">more</i></span>
					      	<p><a href="{{action('PartnersController@show', [$partner->id])}}">visit page</a></p>
					    </div>
					    <div class="card-reveal">
					      <span class="card-title grey-text text-darken-4">{{$partner->name}}<i class="material-icons right">close</i></span>
					      <p><a href="{{action('PartnersController@show', [$partner->id])}}">visit page</a></p>
					      <p>{{$partner->description}}</p>
					    </div>
					</div>
	          	</div>
			@endforeach
		</div>
	</ul>

@endsection

