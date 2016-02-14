$( document ).ready(function($){
	// Materialize Setup
	$(".button-collapse").sideNav();
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
				redirectToFirstEvent( );
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
			redirectToFirstEvent( );
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

function redirectToFirstEvent( ){
	window.location = $('#first-event-link').attr('href');
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

/* ADMIN FUNCTIONS */

function initAdmin(){
	$('.scrollspy').scrollSpy();
	$(window).on('activate.bs.scrollspy', function(e) {
		var $hash, $node;
		$hash = $("a[href^='#']", e.target).attr("href").replace(/^#/, '');
		$node = $('#' + $hash);
		if ($node.length) {
			$node.attr('id', '');
		}
		document.location.hash = $hash;
		if ($node.length) {
			return $node.attr('id', $hash);
		}
	});
}

function approveMedia( encryptedID, isApproved, elementID ){
	$.ajax({
		url: '/api/media/approve',
		type: 'post',
		cache: false,
		dataType: 'json',
        data: {
        	"encryptedID" : encryptedID,
        	"isApproved"  : isApproved
        }
	});
	$("#"+elementID).hide();
}

/* NEWS FUNCTIONS */
function fillInfo( ){
	// If we send them back with errors, fill in their info again
	if( $('[name=content]').val() != '' ){
		$('.content').html($('[name=content]').val());
	}

	if( $('[name=title]').val() != '' ){
		$('.title').text($('[name=title]').val());
	}
}

/* MEDIA */
function initDropzone( ){
	Dropzone.options.fileupload = {
		init: function(){
			this.on('addedfile', function( file ){
				var filename = file.name.replace('.', '').replace(' ', '');

				// Add the file to our list with a progress bar
				$('.uploaded-images').append(
					`
					<li class="collection-item" id="`+filename+`">
						<p>`+file.name+`</p>
						<div class="progress">
							<div class="determinate"></div>
						</div>
					</li>
					`
				);
			});

			this.on('uploadprogress', function( file, progress, bytesSent ){
				var filename = file.name.replace('.', '').replace(' ', '');
				$('#'+filename+" .determinate").width( progress + "%" );
			});

			this.on('success', function( file, response ){
				var filename = file.name.replace('.', '').replace(' ', '');

				$('#'+filename).remove();
				$('.uploaded-images').append(
					`
						<li class="collection-item avatar" id="`+filename+`">
							<img src="`+response.file_location+`" alt="" class="circle">

							<div class="image-name">
								<div class="input-field col s12">
									<input placeholder="`+file.name+` (Start typing to rename)" id="title" type="text" onchange="updateImageTitle( this.value, ` + response.media_id + ` )">
						        </div>
							</div>
							<a href="#!" class="secondary-content"><i class="fa fa-times red-text"></i></a>
						</li>
					`
				);
			});

		}
	};
}

function updateImageTitle( title, media_id ){
	$.ajax({
		url: '/api/media/rename',
		type: 'post',
		cache: false,
		dataType: 'json',
        data: {
        	"title" : title,
        	"mediaID"  : media_id
        }
	});
}
