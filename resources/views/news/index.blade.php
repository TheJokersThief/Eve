@extends('layouts.app')
@section('title') News @endsection

@section('content')
    <main class="container">
        <ul class="collection with-header">
            <li class="collection-header"><h4>News</h4></li>

            @foreach($news as $new)
                <a href="{{ action('NewsController@show', [$new->id]) }}" class="collection-item">{{ $new->title }}</a>
            @endforeach

        </ul>
    </main>

@endsection