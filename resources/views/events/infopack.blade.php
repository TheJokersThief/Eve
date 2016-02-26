@extends('layouts.app')

@section('body-class') info-page @endsection
@section('title') {{_t('Electronic Info Pack')}} @endsection

@section('extra-js')
<script type="text/javascript">
  $(document).ready(function(){
	  var map = new google.maps.Map(document.getElementById('map'), {
	    center: {lat: {!! $ticket->event->location->latitude !!}, lng: {!! $ticket->event->location->longitude !!}},
	    zoom: 13,
	    styles: [{
	      featureType: 'poi',
	      stylers: [{ visibility: 'off' }]  // Turn off points of interest.
	    }, {
	      featureType: 'transit.station',
	      stylers: [{ visibility: 'off' }]  // Turn off bus stations, train stations, etc.
	    }],
	    disableDoubleClickZoom: true
	  });

	  var myLatLng = {lat: {!! $ticket->event->location->latitude !!}, lng: {!! $ticket->event->location->longitude !!}};
	  var marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map,
	    title: "{!! _t($ticket->event->title) !!}"
	  });

	  var contentString = "{!! _t($ticket->event->title) !!}";
	  var infowindow = new google.maps.InfoWindow({
	    content: contentString,
	    maxWidth: 200
	  });
	  marker.addListener('click', function() {
	    infowindow.open(map, marker);
	  });

	  function addPartnerMarker(latitude, longitude, partnerName){
	  	var myLatLng = {lat: latitude, lng: longitude};
		  var marker = new google.maps.Marker({
		    position: myLatLng,
		    map: map,
		    icon: "/images/partnerMarker.png",
		    title: partnerName
		  });

		  var contentString = partnerName;
		  var infowindow = new google.maps.InfoWindow({
		    content: contentString,
		    maxWidth: 200
		  });
		  marker.addListener('click', function() {
		    infowindow.open(map, marker);
		  });
		}

		@foreach($ticket->event->partners as $partner)
			addPartnerMarker({{$partner->location->latitude}},
							 {{$partner->location->longitude}},
							 "{{$partner->name}}");
		@endforeach
  });

</script>
@endsection

@section('content')

<div class="container">
	<div class="row">
		<div class="card">
			<div class="card-header red lighten-2">
				<div class="card-title" style="padding: .1%;">
					<p style="margin-left: 5%;">{!! _t($ticket->event->title) !!}</p>
				</div>
			</div>
			<div class="card-content">
				{!! _t($ticket->event->description) !!}
			</div>
		</div>
		<div class="col s12 m4 l4">
			<div class="card">
				<div class="card-header blue">
					<div class="card-title">
						<p class="center-align">{{_t('Your Ticket')}}</p>
					</div>
				</div>
				<div class="card-content">
					<div class="row">
						<div class="col s12 center-align">
							{!! $ticket->qr() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="map" class="col s12 center-align" style="width: 65%; height: 400px;"></div>
		@foreach($ticket->event->partners as $partner)
		<div class="col s4">
	      <div class="card blue-grey darken-1">
	        <div class="card-content white-text">
	          <span class="card-title">{!! $partner->name !!}</span>
	          <p>{!! $partner->description !!}</p>
	          <p>Distance: {!! $partner->pivot->distance !!}m</p>
	        </div>
	      </div>
	    </div>
	    @endforeach
	</div>
</div>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKOjys2eW4gpc3KmoBlVOjQ-SqHWgyvwI
        &libraries=visualization&callback=initMap">
</script>
@endsection
