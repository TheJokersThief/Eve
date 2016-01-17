$( document ).ready(function($){
	// Materialize Setup
	$(".button-collapse").sideNav();
	$('.modal-trigger').leanModal();

	$('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15 // Creates a dropdown of 15 years to control year
	});
        
	$('select').material_select();
});

function updateProgressBar( elementId, newValue ){
	$('#'+elementId).width(newValue + "%");
}

/* INSTALL FORM FUNCTIONS */

/**
 * Post form data from personalDetails section of form
 */
function createUser( ){
	var formData = new FormData($('#personalDetails-form')[0]);
	$.ajax({
		url: '/api/install/createuser',
		type: 'post',
		cache: false,
        contentType: false,
        processData: false,
        data: formData,	
        beforeSend: function( ){
        	$('#personal-details-errors').empty();
        },
		success: function(data) {
			if( data.errors ){
				// If we have validation errors, display them
				data.errors.forEach( function( error ){
					$('#personal-details-errors').append('<li>'+error+'</li>');
				});
			} else {
				// Otherwise, move to the next section
				moveToSection( 'companyDetails', 3, 4 );
			}
		},
	});
}

/**
 * Move the tab focus to the specified section
 * @param  {string} sectionId     ID of the section to focus
 * @param  {int} 	sectionNumber Number of current section
 * @param  {int} 	totalSections Total number of sections
 */
function moveToSection( sectionId, sectionNumber, totalSections ){
	window.history.pushState({},"", "#"+sectionId);
	$('ul.tabs').tabs('select_tab', sectionId);
	updateProgressBar('progressBar', (100/totalSections) * (sectionNumber - 1) );
}