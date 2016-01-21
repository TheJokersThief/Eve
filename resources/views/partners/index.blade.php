@extends('layouts.app')

@section('content')

	<ul class="collection with-header">
	    <li class="collection-header"><h4>Partners</h4></li>

  	@foreach($partners as $partner)
		<a href="{{ action('PartnersController@show', [$partner->id]) }}" class="collection-item">{{ $partner->name }}</a>
	@endforeach

	</ul>

@endsection