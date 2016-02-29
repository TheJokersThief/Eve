<div class="section">
    {!! _t($event->tagline) !!}
</div>
<div class="parallax-container">
	<div class="parallax">
		<img src="{{ $event->featured_image }}">
	</div>
</div>
<!-- Event description -->
<div class="section">
    {!! _t($event->description )!!}
</div>
	<div class="divider"></div>
<div class="section">
    <!-- Event start and end time -->
		<div class="row">
			<div class="col s6"><h5>{{_t('Start:')}}</h5></div>
  		<div class="col s6"><h5>{{_t('End:')}}</h5></div>
	    <div class="col s6">{{ _t($event->hrStartTime()) }}</div>
  		<div class="col s6">{{ _t($event->hrEndTime()) }}</div>
  	</div>
</div>
<div class="divider"></div>
<div class="section">
    <!-- Event location -->
		<div class="row">
			<div class="col s2"><h5>{{_t('Location:')}}</h5></div>
	    <div class="col s10"><p>{{ $event->location->name }}</p></div>
	</div>
</div>
<div class="divider"></div>
<div class="section">
    <!-- Show all partners for this event -->
    <h5>{{_t('Event Partners')}}</h5>
    <div class="row">
        @foreach($event->partners as $partner)
            <div class="col s4">
        <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="{{ URL::to('/') }}/{{$partner->featured_image}}">
            </div>
            <div class="card-content">
                <span class="card-title activator grey-text text-darken-4">{{$partner->name}}<i class="material-icons right">{{_t('more')}}</i></span>
                <p><a href="{{action('PartnersController@show', [$partner->id])}}">{{_t('visit page')}}</a></p>
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4">{{$partner->name}}<i class="material-icons right">{{_t('close')}}</i></span>
              <p><a href="{{action('PartnersController@show', [$partner->id])}}">{{_t('visit page')}}</a></p>
              <p>{{_t($partner->description)}}</p>
            </div>
        </div>
    </div>
        @endforeach
    </div>
</div>

