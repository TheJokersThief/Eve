</div>

<footer class="page-footer">
  <div class="footer-copyright">
    <div class="container">
    	&copy; {{ date('Y') }} {{_t('Copyright')}}.
	    <a href="#mail-modal" class="modal-trigger white-text" alt="{{_t('Language Preferences')}}"><i class="material-icons">email</i> {{_t('Email us')}}.</a>
    </div>
  </div>
</footer>

	@if(!Auth::check())
		<div class="row modal-row">
			<div id="login-modal" class="col s12 m4 offset-m4 modal">
			    <div class="modal-content">
			        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">&times;</a>
			        <h3> {{_t('Log in')}}</h3>
			        @include('forms.login')
			    </div>
			</div>
		</div>
	@endif

	<div class="row modal-row">
		<div id="language-modal" class="col s12 m4 offset-m4 modal">
		    <div class="modal-content">
		        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">&times;</a>
		        <h3> {{_t('Language')}}</h3>
		        @include('forms.language')
		    </div>
		</div>
	</div>
	<div class="row modal-row">
		<div id="mail-modal" class="col s12 m4 offset-m4 modal">
			<div class="modal-content">
				<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">&times;</a>
				<h3>{{_t('Email the Organisers')}}</h3>
				<form method="POST" class="row" action="//formspree.io/{{\App\User::where('is_admin', 1)->first()->email}}">
					<div class="input-field col s6">
						<input type="text" name="name" id="name" />
						<label for="name">Name</label>
					</div>
					<div class="input-field col s6">
						<input type="email" name="_replyto" id="_replyto">
						<label for="_replyto">Email</label>
					</div>
					<div class="input-field col s12">
						<textarea name="message" class="materialize-textarea" id="message" rows="5"></textarea>
						<label for="message">Message</label>
					</div>
					<input type="text" name="_gotcha" id="_gotcha" style="display:none">
					<button type="button" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="emailFormSubmit(); return false;">Send</button>
					<button type="button" onclick="return false;" class="modal-action modal-close waves-effect waves-green btn-flat">Close</button>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	<script src="{{URL::to('/')}}/js/libraries.js"></script>
	<script type="text/javascript" src="{{ URL::to('/') }}/js/main.js"></script>
	@yield('extra-js')

	@if(session('message'))
		<script>Materialize.toast('{!! session('message') !!}', 3000);</script>
	@endif
	</body>
</html>
