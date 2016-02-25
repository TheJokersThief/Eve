@extends('layouts.app')

@section('title') {{ _t('Login') }} @endsection


@section('content')
    <main class="container">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col m10 offset-m1 offset-l1">
                        <span class="card-title">{{_t('Login')}}</span>
                        @include("forms.login")
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
