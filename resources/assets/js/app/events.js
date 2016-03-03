function initEvents( ){
	$(document).ready(function(){
	  	  //initialise map
		  var map = new google.maps.Map(document.getElementById('map'), {
		    center: {lat: 55.2812223, lng: -15.3740124},
		    zoom: 6,
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
		  var myLatLng = {lat: 53.2812223, lng: -7.3740124};

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
}
