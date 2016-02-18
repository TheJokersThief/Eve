@extends('layouts.app')

@section('body-class') usersEvent-page usersAccount-page @endsection
@section('title') Results Page @endsection

@section('content')

	<main class="row">
		<div class="col l8 s12 offset-l2">
			<ul class="collection with-header">
				<li class="collection-header">
					<h2 class="center-align flow-text">Search Results</h2>
				</li>
				@if(count($users) > 0)
					@foreach($users as $user)
						<li class="collection-item avatar">
								<img src="{{ $user->profile_picture }}" alt="" class="circle">
								<strong class="title">{{ $user->name }}</strong>
								<p>
									{{ $user->city }}, {{ $user->country }}
								</p>
								<a href="{{ URL::route('user/show', [$user->username]) }}" class="secondary-content"><i class="fa fa-external-link red-text text-lighten-2"></i></a>
						</li>
					@endforeach
				@else
					<li class="collection-item">
						We can't find any users with that name, Sorry!
					</li>
				@endif
			</ul>
		</div>
	</main>

@endsection