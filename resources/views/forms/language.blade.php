{!! Form::open( array('url' => 'language', 'method' => 'post', 'class' => 'row col s12') ) 		!!}

<div class="input-field col s12">
    {!! Form::select('language', getTranslationLocales( ), Request::cookie('locale'), ['onchange' => "this.form.submit()"]) !!}
</div>



{!! Form::close() 													!!}
