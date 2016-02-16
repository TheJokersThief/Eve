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
