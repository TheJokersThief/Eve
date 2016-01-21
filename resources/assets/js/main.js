$( document ).ready(function($){
	// Materialize Setup
	$(".button-collapse").sideNav();
	$('.modal-trigger').leanModal();

	$('.datepicker').pickadate({
	    selectMonths: true, // Creates a dropdown to control month
	    selectYears: 15, // Creates a dropdown of 15 years to control year
	    format: 'yyyy-mm-dd' // Formats the date
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
				autofillInformation( );
			}
		},
	});
}

function createCompany( ){
	var formData = new FormData($('#companyDetails-form')[0]);
	$.ajax({
		url: '/api/install/createCompany',
		type: 'post',
		cache: false,
        contentType: false,
        processData: false,
        data: formData,	
        beforeSend: function( ){
        	$('#company-details-errors').empty();
        },
		success: function(data) {
			if( data.errors ){
				// If we have validation errors, display them
				data.errors.forEach( function( error ){
					$('#company-details-errors').append('<li>'+error+'</li>');
				});
			} else {
				// Otherwise, move to the next section
				moveToSection( 'firstEvent', 4, 4 );
				autofillInformation( );
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
function moveToSection( sectionId, sectionNumber, totalSections, fromBackButton ){
	if( window.location.hash != '#' + sectionId || fromBackButton ){
		if( !fromBackButton ){
			window.history.pushState({},"", "#"+sectionId);
		}
		$('ul.tabs').tabs('select_tab', sectionId);
		updateProgressBar('progressBar', (100/totalSections) * (sectionNumber - 1) );
	}
}

/**
 * When a user reloads the page, ensure the progress bar is
 * at the correct position
 */
function checkProgress( ){
	switch( window.location.hash ){
		case '#personalDetails':
			updateProgressBar( 'progressBar', 25 );
			break;

		case '#companyDetails':
			updateProgressBar( 'progressBar', 50 );
			break;

		case '#firstEvent':
			updateProgressBar( 'progressBar', 75 );
			break;

		default:
			updateProgressBar( 'progressBar', 0 );
			break;
	}
}

function autofillInformation( ){
	$.ajax({
		url: '/api/install/getInstallUserInfo',
		type: 'get',
		cache: false,
        contentType: false,
        processData: false,
        beforeSend: function( ){
        	
        },
		success: function(data) {
			for( var key in data ){

				if( key == 'profile_picture' ){
					$('#profle-picture-preview').attr( 'src', data.profile_picture );
				} else if( key == 'company_logo') {
					$('#company-logo-preview').attr( 'src', data.company_logo );
				} else{
					$('[name='+key+']').val( data[key] );

					// registers as filled with materializecss
					$('label[for='+key+']').addClass('active');
				}

				if( key == 'email' && data[key] != "" ){
					$("[name=email]").attr('disabled', "true");
				}
			}
		},
	});
}