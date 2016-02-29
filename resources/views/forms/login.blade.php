{!! Form::open( array('url' => 'login', 'method' => 'post', 'class' => 'row col s12') ) 		!!}

<div class="row">
	<div class="input-field">
		{!! Form::label('email',_t('Email'))									!!}
		{!! Form::text('email', null,array('class' => 'twelve columns'))	!!}
	</div>
</div>

<div class="row">
	<div class="input-field">
		{!! Form::label('password',_t('Password'))								!!}
		{!! Form::password('password',array('class' => 'twelve columns'))	!!}
	</div>
</div>

<button class="btn waves-effect waves-light login-button" type="submit" name="action">{{_t('Login')}}
	<i class="mdi-content-send right"></i>
</button>

<a href="#" class="btn waves-effect waves-light blue darken-3 facebook-login-button">{{_t('Login with Facebook')}}
	<i class="fa fa-facebook-square right"></i>
</a>

{!! Form::close() 													!!}

<p>
	<a href="{{ URL::to('/password/email') }}"> {{_t('Forgot password?')}}</a>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="{{ URL::to('register') }}"> {{_t('Want to register?')}}</a>
</p>
