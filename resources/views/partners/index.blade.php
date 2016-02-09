@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
    <div class="col s10 m10 center-align"><h4>Partners</h4></div>
    <div class="col s2 m2 valign-wrapper">
	    <a href="#!" class="center-align waves-effect waves-circle waves-light btn-floating secondary-content">
			<i class="material-icons">add</i>
		</a>
	</div>
</div>
    <div class="row">
	    @foreach($partners as $partner)
	    	<div class="col s4">
	            <div class="card">
				    <div class="card-image waves-effect waves-block waves-light">
				    	<img class="activator" src="{{ URL::to('/') }}/{{$partner->featured_image}}">
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
</div>

@endsection

