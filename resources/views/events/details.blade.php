<div class="parallax-container">
	<div class="parallax"><img src="/images/sample_images/event_photos/{{ $event->featured_image }}"></div>
</div>
<div class="section">
    <p>{{ $event->description }}</p>
</div>
	<div class="divider"></div>
<div class="section">
		<div class="row">
			<div class="col s6"><h5>Start:</h5></div>
  		<div class="col s6"><h5>End:</h5></div>
	    <div class="col s6">{{ $event->hrStartTime() }}</div>
  		<div class="col s6">{{ $event->hrEndTime() }}</div>
  	</div>
</div>
<div class="divider"></div>
<div class="section">
		<div class="row">
			<div class="col s2"><h5>Location:<h5></div>
	    <div class="col s10"><p>{{ $event->location->name }}</p></div>
	</div>
</div>
<div class="divider"></div>
	<div class="section">
	    <h5>Event Partners</h5>
	    <div class="row">
		    @foreach($event->partners as $partner)
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
	</div>
</div>
