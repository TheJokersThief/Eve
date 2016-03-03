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

function initGallery( loading_image_error, loading_image_text ){
	var $grid = $('.grid').masonry({
		itemSelector: '.grid-item',
		// percentPosition: true,
		gutter:0,
		fitWidth: true,
		// containerStyle: null
	});

	setInterval(function(){
		$grid.masonry();
	}, 500);

      //popup-gallery
      $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: true,
        fixedContentPos: true,
        tLoading: loading_image_text + ' #%curr%...',
        mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
        gallery: {
          enabled: true,
          navigateByImgClick: true,
          preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
          verticalFit: true,
          tError: '<a href="%url%">'+loading_image_error+' #%curr%</a>',
          titleSrc: function(item) {
            return item.el.attr('title');
          },
        zoom: {
          enabled: true,
          duration: 300 // don't foget to change the duration also in CSS
        }
        }
      });
}
