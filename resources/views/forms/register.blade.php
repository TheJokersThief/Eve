@foreach ($errors->all() as $message)
    <li>{{ _t($message) }}</li>
@endforeach

{!! Form::open([
	"route" => ['user/store'],
	"method" => "POST",
	'class' => 'row col s12'
]) !!}

<div class="row">
	<div class="input-field">
		{!! Form::label('name', _t('First Name')) !!}
		{!! Form::text('name', null, ["class" => "example"] ) !!}
	</div>
</div>

<div class="row">
    <div class="input-field">
        {!! Form::label('username', _t('Username')) !!}
        {!! Form::text('username', null, ["class" => "example"] ) !!}
    </div>
</div>

<div class="row">
	<div class="input-field">
		{!! Form::label('email', _t('Email')) !!}
		{!! Form::email('email', null, ["class" => "example"] ) !!}
	</div>
</div>

<div class="row">
	<div class="input-field">
		{!! Form::label('password', _t('Password')) !!}
		{!! Form::password('password', null, ["class" => "example"] ) !!}
	</div>
</div>
<div class="row">
	<div class="input-field">
		{!! Form::label('password_confirmation', _t('Confirm Password')) !!}
		{!! Form::password('password_confirmation', null, ["class" => "example"] ) !!}
	</div>
</div>
<button class="btn waves-effect waves-light" type="submit" name="action">{{_t('Register')}}
	<i class="mdi-content-send right"></i>
</button>
{!! Form::close() !!}
