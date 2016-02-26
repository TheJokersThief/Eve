@section('extra-js')
<script type="text/javascript">
  $(document).ready(function(){
  	  //initialise map
	  var map = new google.maps.Map(document.getElementById('map'), {
	    center: {lat: 53.3442, lng: 6.2675},
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
	  var myLatLng = {lat: 53.3442, lng: 6.2675};

	  //create a draggable marker
	  var marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map,
	    draggable: true,
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
<div id="locationForm" class="modal bottom-sheet">
	<div class="modal-content">
		<h4>{{_t('Create New Location')}}</h4>
		<ul id="location-errors"></ul>
		{!! Form::open( ['route' => 'events.store', 'files' => true] ) !!}
		<div class="row">
			<div class="input-field col m6 s12">
				{!! Form::label('name',_t('Location Name'))	!!}
				{!! Form::text('name')	!!}
			</div>
			<div class="input-field col m6 s12">
				{!! Form::label('capacity',_t('Location Capacity'))	!!}
				{!! Form::number('capacity') !!}
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('latitude',_t('Latitude'))	!!}
				{!! Form::text('latitude')	!!}
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('longitude',_t('Longitude'))	!!}
				{!! Form::text('longitude')	!!}
			</div>

			<div class="row">
				<div class="input-field col m5 s12">
					{!! Form::label('move-marker', 'Search map')!!}
					{!! Form::text('move-marker')!!}
				</div>
				<div id="map" class="col s12 center-align" style="width: 65%; height: 400px;"></div>
			</div>
			
			<div class="file-field input-field col m6 s12">
				<div class="btn">
					<span>{{_t('Feature Image')}}</span>
					{!! Form::file('featured_image') !!}
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('latitude','Latitude')	!!}
				{!! Form::number('latitude')	!!}
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('longitude','Longitude')	!!}
				{!! Form::number('longitude')	!!}
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="modal-footer">
		<a href="#!" class="orange-text modal-action waves-effect waves-green btn-flat" onClick="createLocation()">{{_t('Create')}}</a>
		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat" onClick="$('#location-select').val('');$('#location-select').material_select();">{{_t('Cancel')}}</a>
	</div>
</div>
	<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKOjys2eW4gpc3KmoBlVOjQ-SqHWgyvwI
        &libraries=places">
	</script>
