@extends('layouts.app')

@section('body-class') admin-home-page @endsection

@section('content')

<div class="row admin-with-sidebar">
	<div class="col s12 m8 offset-m2">
		<div class="col push-s12 m4">
			<aside class="card">
				<div class="collection">
					<a href="#events" 	class="collection-item">Events</a>
					<a href="#partners" class="collection-item">Partners</a>
					<a href="#news" 	class="collection-item">News</a>
					<a href="#media" 	class="collection-item">Media</a>
					<a href="#staff" 	class="collection-item">Staff</a>
				</div>

			</aside>
		</div>
		<div class="col pull-s12 m8">
			<div class="row" id="events">
				<ul class="collection with-header">
					<li class="collection-header">
						<a href="#!" class="waves-effect waves-light btn right"><i class="fa fa-plus left"></i>Add New Event</a>
						<h4>Events</h4>
					</li>

					@foreach( $events as $event )
						<li class="collection-item">
							<div>
								<strong>{{ $event->title }}</strong>
								<em>({{ date('d M, Y', strtotime($event->start_datetime)) }} &rarr; {{ date('d M, Y', strtotime($event->end_datetime)) }})</em>
								<a href="#!" class="secondary-content">
									<i class="fa fa-pencil"></i> &nbsp;
									<i class="fa fa-times red-text"></i>
								</a>
							</div>
						</li>
					@endforeach
				</ul>
				<a href="#!" class="waves-effect waves-light btn right">View All Events &rarr;</a>
			</div>

			<div class="row" id="partners">
				<ul class="collection with-header">
					<li class="collection-header">
						<a href="#!" class="waves-effect waves-light btn right"><i class="fa fa-plus left"></i>Add New Partner</a>
						<h4>Partners</h4>
					</li>

					@foreach( $partners as $partner )
						<li class="collection-item">
							<div>
								<strong>{{ $partner->name }}</strong>
								<em>({{ $partner->location->name }})</em>
								<a href="#!" class="secondary-content">
									<i class="fa fa-pencil"></i> &nbsp;
									<i class="fa fa-times red-text"></i>
								</a>
							</div>
						</li>
					@endforeach
				</ul>
				<a href="#!" class="waves-effect waves-light btn right">View All Partners &rarr;</a>
			</div>
		</div>
	</div>
</div>
@endsection