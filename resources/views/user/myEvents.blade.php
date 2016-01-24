@extends('layouts.app')

@section('body-class') usersEvent-page @endsection

@section('content')
	<main class="row">
		<div class="col l10 push-l1 s12 card white">
			<div class="row">
				<div class="col m3 s12" id="userInfo">
					<div class="card white">
						<div class="hide-on-med-and-down">
							<img src="https://placehold.it/254x255" >
						</div>

						<div class="row">
							<div class="col s10">
								<span class="card-title">User Name:</span>
								<p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
							</div>
						</div>
					</div>
				</div>
				<div id="upComingEvents" class="col m9 s12">
					<div class="collection with-header, flow-text">
						<h3 class="center-align">Upcoming Events</h3>
						<a href="#!linkToEventOrInfoPack" class="collection-item">Super cool event 1</a>
						<a href="#!linkToEventOrInfoPack" class="collection-item">Super cool event 2</a>
						<a href="#!linkToEventOrInfoPack" class="collection-item">Super cool event 3</a>
						<a href="#!linkToEventOrInfoPack" class="collection-item">Super cool event 4</a>
						<a href="#!linkToEventOrInfoPack" class="collection-item">Super cool event 5</a>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection

