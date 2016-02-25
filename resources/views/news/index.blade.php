@extends('layouts.app')
@section('title') {{_t('News')}} @endsection

@section('content')
    <main class="container">
        <ul class="collection with-header">
            <li class="collection-header"><h4>{{_t('News')}}</h4></li>

            @foreach($news as $new)
                <a href="{{ action('NewsController@show', [$new->id]) }}" class="collection-item">{{ _t($new->title) }}</a>
            @endforeach

        </ul>
    </main>

@endsection
