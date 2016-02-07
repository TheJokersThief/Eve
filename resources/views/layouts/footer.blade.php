	<div class="row modal-row">
		<div id="login-modal" class="col s12 m4 offset-m4 modal">
		    <div class="modal-content">
		    	<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat right">&times;</a>
		    	<h3> Login</h3>
		      	@include('forms.login')
		    </div>
		</div>
	</div>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
    <script src="{{URL::to('/')}}/js/libraries.js"></script>
	<script type="text/javascript" src="{{ URL::to('/') }}/js/main.js"></script>
	@yield('extra-js')
</body>
</html>