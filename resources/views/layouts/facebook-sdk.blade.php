<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : {{ env("FACEBOOK_APP_ID") }},
			xfbml      : true,
			version    : 'v2.5',
			cookie     : true
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>