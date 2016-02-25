@extends('layouts.app')

@section('body-class') locations @endsection
@section('title') {{_t('Edit:')}} {{$item->name}} @endsection
@section('extra-js')
<script type="text/javascript">
  $(document).ready(function(){
  	  //initialise map
	  var map = new google.maps.Map(document.getElementById('map'), {
	    center: {lat: {!! $item->latitude !!}, lng: {!! $item->longitude !!}},
	    zoom: 13,
	    styles: [{
	      featureType: 'poi',
	      stylers: [{ visibility: 'off' }]  // Turn off points of interest.
	    }, {
	      featureType: 'transit.station',
	      stylers: [{ visibility: 'off' }]  // Turn off bus stations, train stations, etc.
	    }],
	    disableDoubleClickZoom: false
	  });

	  //get latitude and longitude
	  var myLatLng = {lat: {!! $item->latitude !!}, lng: {!! $item->longitude !!}};

	  //create a draggable marker
	  var marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map,
	    draggable: true,
	    title: "{!! $item->name !!}"
	  });

	  //add an info with the location name
	  var contentString = "{!! $item->name !!}";
	  var infowindow = new google.maps.InfoWindow({
	    content: contentString,
	    maxWidth: 200
	  });
	  //on clicke of marker open the info window
	  marker.addListener('click', function() {
	    infowindow.open(map, marker);
	  });

	  //create a search bar for places
	  var searchBox = new google.maps.places.SearchBox(document.getElementById('move-marker'));


	  google.maps.event.addListener(searchBox, 'places_changed', function(){

	  	var places = searchBox.getPlaces();
	  	var bounds = new google.maps.LatLngBounds();
	  	var i, place;

	  	for(i=0; place=places[i]; i++){
	  		bounds.extend(place.geometry.location);
	  		marker.setPosition(place.geometry.location);
	  	}

	  	map.fitBounds(bounds);
	  	map.setZoom(13);

	  });

	  google.maps.event.addListener(marker, 'position_changed', function(){

		  var lat = marker.getPosition().lat();
		  var lng = marker.getPosition().lng();

		  $('#latitude').val(lat);
		  $('#longitude').val(lng);
	  });


   });
</script>
@endsection
@section('content')
	<div class="row">
		<div class="col s12 m8 offset-m2 l6 offset-l3">
			<h2>{{_t('Edit Location:')}}</h2>
			{!! Form::open( ['route' => ['locations.update', $item->id], 'files' => true, 'method' => 'PUT'] ) !!}
				<div class="row">
					<div class="input-field col m5 s12">
						{!! Form::label( 'name', _t( 'Location Title' ) ) !!}
						{!! Form::text( 'name', $item->name ) !!}
					</div>
				</div>

				<div class="row">
					<div class="input-field  form-control col m5 s12">
						{!! Form::label('latitude',_t('Latitude'))	!!}
						{!! Form::number('latitude', $item->latitude) !!}
					</div>
					<div class="input-field col m5 s12">
						{!! Form::label('longitude',_t('Longitude'))	!!}
						{!! Form::number('longitude', $item->longitude)	!!}
					</div>
					<div class="input-field col m2 s12">
						{!! Form::label('capacity',_t('Capacity'))	!!}
						{!! Form::number('capacity', $item->capacity)	!!}
				</div>

				<div class="row">
					<div class="input-field col m5 s12">
						{!! Form::label('move-marker', 'Search map')!!}
						{!! Form::text('move-marker')!!}
					</div>
					<div id="map" class="col s12 center-align" style="width: 65%; height: 400px;"></div>
				</div>

				<div class="row">
					<div class="col m4">
						<img src="{{ $item->featured_image }}" />
					</div>
					<div class="file-field input-field col s12 m8">
						<div class="btn">
							<span>{{_t('Add Image')}}</span>
							{!! Form::file('featured_image') !!}
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s3 left">
						<div class='form-group'>
							<a class="waves-effect waves-light btn" href="{{ URL::route('locations.index') }}">&larr; {{_t('All Locations')}}</a>
						</div>
					</div>
					<div class="col s2 right">
						<div class='form-group'>
							{!! Form::submit('Update Location &rarr;', ['class' => 'btn btn-primary form-control', 'id' => 'news-button']) !!}
						</div>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKOjys2eW4gpc3KmoBlVOjQ-SqHWgyvwI
        &libraries=places">
	</script>
@endsection
