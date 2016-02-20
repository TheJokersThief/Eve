function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 53.402119, lng: -7.724075},
    zoom: 6,
    styles: [{
      featureType: 'poi',
      stylers: [{ visibility: 'off' }]  // Turn off points of interest.
    }, {
      featureType: 'transit.station',
      stylers: [{ visibility: 'off' }]  // Turn off bus stations, train stations, etc.
    }],
    disableDoubleClickZoom: true
  });
}