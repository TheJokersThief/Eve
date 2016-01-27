@extends('layouts.app')

@section('body-class') usersEvent-page @endsection

@section('content')
	<main class="row">
		<nav class="oldEvents">
	    	<div class="nav-wrapper" >
	      			<div class="col s12">
	      				<a href="http://softwareproject.dev/user/myEvents" class="breadcrumb">Upcoming Events</a>
	       				<a href="http://softwareproject.dev/user/pastEvents" class="breadcrumb">Past Events</a>
	      			</div>
	   			</div>
	  		</nav>
	  		<div class="col l10 push-l1 s12 card white">
				<div id="upComingEvents" class="col 12">
					<div class="collection with-header, flow-text">
						<h3 class="center-align">Past Events</h3>
							<!--temporarily not linked to users registered events-->
						<div class="row">
				            @for($i=1; $i <= 3; $i++ )
				                <div class="col m4 s12">
				                    <div class="card">
				                        <div class="card-image">
				                            <img src="{{ URL::to('/') . '/images/sample_images/event_photos/event'.$i.'.jpg' }}">
				                            <span class="card-title">Lorem ipsum Est quis dolor ex fugiat veniam tempor ullamco incididunt quis id in eiusmod ut quis Excepteur.</span>
				                        </div>
				                        <div class="card-content">
				                            <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
				                        </div>
				                        <div class="card-action">
				                            <a href="#" class="red-text text-lighten-2">View Event &rarr;</a>
				                        </div>
				                        <div class="card-action">
				                            <a href="#" class="red-text text-lighten-2">View Info Pack &rarr;</a>
				                        </div>
				                    </div>
				                </div>
				            @endfor
				        </div>
				        <div class="row">
				            @for($i=1; $i <= 2; $i++ )
			                <div class="col m4 s12">
			                    <div class="card">
			                        <div class="card-image">
			                            <img src="{{ URL::to('/') . '/images/sample_images/event_photos/event'.$i.'.jpg' }}">
			                            <span class="card-title">Lorem ipsum Est quis dolor ex fugiat veniam tempor ullamco incididunt quis id in eiusmod ut quis Excepteur.</span>
			                        </div>
			                        <div class="card-content">
			                            <p>Lorem ipsum Ut in eiusmod pariatur reprehenderit minim esse reprehenderit ea in sunt ad cupidatat commodo enim id voluptate in eu Duis sint reprehenderit quis sed magna dolor do irure qui sit eu reprehenderit aliqua enim.</p>
			                        </div>
			                        <div class="card-action">
			                            <a href="#" class="red-text text-lighten-2">View Event &rarr;</a>
			                        </div>
			                        <div class="card-action">
			                            <a href="#" class="red-text text-lighten-2">View Info Pack &rarr;</a>
			                        </div>
			                    </div>
			                </div>
			           		 @endfor
		           		</div>
					</div>
				</div>
			</div>
	</main>
@endsection

