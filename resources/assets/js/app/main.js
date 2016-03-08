/* CORE INIT AND GENERAL-USE FUNCTIONS */

$( document ).ready(function($){
	// Materialize Setup
	$('.modal-trigger').leanModal();
	$('.parallax').parallax();

	$('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15, // Creates a dropdown of 15 years to control year
	    format: 'yyyy-mm-dd' // Formats the date
	});

	$('select').material_select();

	// Rewrite iCal Links to be integrated to services
	if( $(".ical").length ){

		$(".ical").each(function(){
			var link = $(this).attr('href');

			var link = link.replace(window.location.protocol + "//", "webcal://");

			if(navigator.platform.toUpperCase().indexOf('LINUX')>=0 || navigator.platform.toUpperCase().indexOf('WIN')>=0){
				link = "https://www.google.com/calendar/render?cid=" + link;
			}

			$(this).attr('href', link);
		});
	}

	$( "#search" ).autocomplete({
	  source: "/user/autocomplete",
	  minLength: 1,
	  select: function(event, ui) {
	  	$('#search').val(ui.item.value);
	  }
	});
});

function updateProgressBar( elementId, newValue ){
	$('#'+elementId).width(newValue + "%");
}

function createLocation( ){
	var formData = new FormData($('#locationForm form')[0]);
	$.ajax({
		url: '/api/location/create',
		type: 'post',
		cache: false,
        contentType: false,
        processData: false,
        data: formData,
		success: function(data) {
			if( data.errors ){
				// Clear any previous errors
				$('#location-errors li').remove();
				// If we have validation errors, display them
				data.errors.forEach( function( error ){
					$('#location-errors').append('<li>'+error+'</li>');
				});
			} else {
				$newItem = $("<option value='"+ data.id + "'>"+ data.name + "</option>");
				$('#location-select').append($newItem);
				$('#location-select').val(data.id);
				$('#location-select').material_select();
				$("#locationForm").closeModal();
			}
		}
	});
}

function emailFormSubmit( ){
	var formData = new FormData($('#mail-modal form')[0]);
	var formUrl = $('#mail-modal form').attr('action')
	$.ajax({
		url: formUrl,
		type: 'post',
		data: formData,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function() {
			$('#mail-modal').closeModal();
			Materialize.toast("Your mail has been sent!", 2000);
		}
	});
}
