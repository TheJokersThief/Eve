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
