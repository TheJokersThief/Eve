$(document).ready(function(){
	$(".facebook-login-button").click(function(){
		FB.login(function() {
			window.location.href='/facebook/jsAuth?from=' + window.location.pathname; // If only there was a way to get URL:to('/') in JS :(
		}, {scope: 'public_profile,email,user_about_me,user_friends,user_location'});
	});
});