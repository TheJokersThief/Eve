@extends('layouts.app')

@section('title') {{_t('Register')}} @endsection

@section('content')
<div class="container">
    <div class="row">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{_t('Register')}}</span>
                    <div class="row">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="input-field{{ $errors->has('name') ? ' has-error' : '' }}">

                                <div class="">
                                    <label class="control-label" for="name">{{_t('Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-field{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="">
                                    <label class="control-label" for="email">{{_t('E-Mail Address')}}</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-field{{ $errors->has('username') ? ' has-error' : '' }}">

                                <div class="">
                                    <label class="control-label" for="username">{{_t('Username')}}</label>
                                    <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}">

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-field{{ $errors->has('password') ? ' has-error' : '' }}">

                                <div class="">
                                    <label class="control-label" for="password">{{_t('Password')}}</label>
                                    <input type="password" class="form-control" name="password" id="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-field{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                <div class="">
                                    <label class="control-label" for="password_confirmation">{{_t('Confirm Password')}}</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-field">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user left"></i> {{_t('Register')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
