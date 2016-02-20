@extends('layouts.app')

@section('body-class') info-page @endsection
@section('title') Electronic Info Pack @endsection

@section('extra-js')
<script type="text/javascript">
  $(document).ready(function(){
    initMap();
  });
</script>
@endsection

@section('content')

<div class="container">
	<div class="row">
			<div class="card">
				<div class="card-header red lighten-2">
					<div class="card-title">
						<h4 class="">{!! $ticket->event->title !!}</h4>
					</div>
				</div>
				<div class="card-content">
					{!! $ticket->event->description !!}
				</div>
			</div>
		<div class="col s12 center-align">
			{!! $ticket->qr() !!}
		</div>
		<div id="map" class="col s12 center-align" style="height: 400px;"></div>
		@foreach($ticket->event->partners as $partner)
		<div class="col s4">
	      <div class="card blue-grey darken-1">
	        <div class="card-content white-text">
	          <span class="card-title">{!! $partner->name !!}</span>
	          <p>{!! $partner->description !!}</p>
	        </div>
	      </div>
	    </div>
	    @endforeach
	</div>
</div>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKOjys2eW4gpc3KmoBlVOjQ-SqHWgyvwI
        &libraries=visualization&callback=initMap">
</script>

@endsection