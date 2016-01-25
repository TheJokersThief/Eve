@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
	        <div class="col s12 m10">
	        	<h2>{{ $event->title }}</h2>
	        </div>
	        @if(Auth::check())
				{!! Form::open( ['url' => 'tickets', "class" => "col s12 m2 get_ticket_button"] ) !!}
					{!! Form::hidden('event_id', $event->id) !!}
					{!! Form::submit('Get Ticket', ['class' => 'btn btn-primary form-control']) !!}
				{!! Form::close() !!}
			@endif
		</div>
		<div class="divider"></div>
  			<div class="section">
		    <p>{{ $event->description }}</p>
		</div>
      	<div class="divider"></div>
  			<div class="section">
  			<div class="row">
	  			<div class="col s6"><h5>Start:</h5></div>
	      		<div class="col s6"><h5>End:</h5></div>
			    <div class="col s6">{{ $event->start_datetime }}</div>
	      		<div class="col s6">{{ $event->end_datetime }}</div>
	      	</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
  			<div class="row">
  				<div class="col s2"><h5>Location:<h5></div>
			    <div class="col s10"><p>{{ $event->location->name }}</p></div>
			</div>
		</div>
		<div class="divider"></div>
  			<div class="section">
			    <h5>Event Partners</h5>
			    <div class="row">
				    @foreach($event->partners as $partner)
				    	<div class="col s4">
							<div class="card small">
					            <div class="card-image">
					              	<img src="{{ URL::to('/') }}/{{$partner->media->file_location}}">
					              	<span class="card-title">{{$partner->name}}</span>
					            </div>
					            <div class="card-content">
					              	<p>{{$partner->description}}</p>
					              	<p>Price: {{$partner->price}}</p>
					              	<p>Distance: {{$partner->distance}}</p>
					            </div>
					            <div class="card-action">
					              	<a href="/partners/{{$partner->id}} ">more info</a>
					            </div>
				            </div>
			          	</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@endsection