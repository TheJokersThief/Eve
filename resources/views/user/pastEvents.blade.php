@extends('layouts.app')

@section('body-class') usersEvent-page @endsection

@section('content')
	<main class="row">
		<nav class="oldEvents">
	    	<div class="nav-wrapper" >
	      			<div class="col s12">
	      				<a href="{{ URL::route('myEvents') }}" class="breadcrumb">Upcoming Events</a>
	       				<a href="{{ URL::route('pastEvents') }}" class="breadcrumb">Past Events</a>
	      			</div>
	   			</div>
	  		</nav>
	  		<div class="col l10 push-l1 s12 card white">
				<div id="upComingEvents" class="col 12">
					<div class="collection with-header flow-text">
						<h3 class="center-align">Past Events</h3>
							<!--temporarily not linked to users registered events-->
						<div class="row">
					            @foreach($me->tickets as $ticket)
					            	@if($ticket->event->end_datetime < date(time()))
					                <div class="col s12 m6 l4">
					                    <div class="card dimmed-card-image">
					                        <div class="card-image">
					                            <img src="{{ URL::to('/') . '/images/sample_images/event_photos/event'.$ticket->event->id.'.jpg' }}">
					                            <span class="card-title">{{$ticket->event->title}}</span>
					                        </div>
					                        <div class="card-content">
					                            <p>{{$ticket->event->description}}</p>
					                        </div>
					                        <div class="card-action">
					                            <a href="{{action('EventsController@show', $ticket->event->id)}}" class="red-text text-lighten-2">View Event &rarr;</a>
					                        </div>
					                        <div class="card-action">
					                            <a href="{{action('TicketController@show', $ticket->id)}}" class="red-text text-lighten-2">View Info Pack &rarr;</a>
					                        </div>
					                    </div>
					                </div>
					                @endif
					            @endforeach
				        </div>
		           		</div>
					</div>
				</div>
			</div>
	</main>
@endsection

