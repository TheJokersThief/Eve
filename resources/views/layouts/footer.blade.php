
	<div id="login-modal" class="modal">
	    <div class="modal-content">
	    	<h3> Login</h3>
	      	@include('forms.login')
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">&times;</a>
	    </div>
	</div>

	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
	<script type="text/javascript" src="{{ URL::to('/') }}/js/compiled/main.js"></script>
	@yield('extra-js')
</body>
</html>