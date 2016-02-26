<html>
	<script>
		window.print();
	</script>
	<style type="text/css">
	body{
		font-family: 'Oxygen',sans-serif;
		color: #4F4F4F;
		width: 21cm;
	}
	header{
		height:3cm;
	}
	header img{
		padding-top: .3cm;
	}
	header h1{
		margin: 0 0 0 .5cm;
	}
	p{
		margin: 0 0 0 .5cm;
	}
	img{
		width:100%;
	}
	.superText{
		padding-left: .3cm;
		display: inline;
		font-size: 9pt;
	}
	#title{
		width:15.75cm;
		height:3cm;
		float: left;
	}
	#logo{
		width: 5cm;
		height: 3cm;
		float: right;
	}
	#logo img{
		max-width: 100%;
	}
	main{
		clear:both;
	}
	@page{
		margin: 0.5cm;
	}
	#time{
		float: left;
	}
	#time, #location{
		width: 49.5%;
		height:3.5cm;
	}
	#location{
		float:right;
		margin-bottom: 0;
	}
	#name{
		clear:both;
	}
	#time, #location, #name, #about, #number{
		background-color: white;
		margin-top: .25cm;
		padding-top: 10;
		padding-bottom: 10;
	}
	#name, #number{
		width:49.5%;
		float:left;
	}
	#number{
		float:right;
		margin-bottom: 10;
	}
	#about{
		clear:both;
		margin-bottom: 10;
	}
	#map{
		width:59%;
		float: left;
		max-height: 15cm;/* remove/improve when google api implemented */
	}
	#map img{
		max-height: 15cm;/* remove/improve when google api implemented */
	}
	#qr{
		width:39%;
		float:right;
	}
	</style>
	<body>
		<header>
			<div id="title">
				<div class="superText">{{_t('Event:')}}</div>
				<h1>{{_t($ticket->event->title)}}</h1>
			</div>
			<div id="logo">
				<img src="{{ $ticket->event->featured_image }}" />
			</div>
		</header>
		<main>
			<div id="time">
				<div class="superText">{{_t('Date and Time:')}}</div>
				<p>{{_t('From:')}}&emsp;{{ $ticket->event->hrStartTime() }}</p>
				<p>{{_t('To:')}}&emsp;&emsp;{{ $ticket->event->hrEndTime() }}</p>
			</div>
			<div id="location">
				<div class="superText">{{_t('Location:')}}</div>
				@foreach( $ticket->event->location->addressAsArray() as $line )
					<p>{{ $line }}</p>
				@endforeach
			</div>
			<div id="name">
				<div class="superText">{{_t('Ticketholder:')}}</div>
				<p>{{$ticket->user->name}}</p>
			</div>
			<div id="number">
				<div class="superText">{{_t('Order Number:')}}</div>
				<p>#{{ $ticket->id }}</p>
			</div>
			<div id="about">
				<div class="superText">{{_t('About:')}}</div>
				<p>{{ strip_tags(str_limit( _t($ticket->event->description), 300 ))}}</p>
			</div>
			<div id="map">
				<img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $ticket->event->location->latitude }},{{ $ticket->event->location->longitude }}&zoom=15&size=300x300&markers=color:red%7C{{ $ticket->event->location->latitude }},{{ $ticket->event->location->longitude }}&key=AIzaSyB17PgysQ3erA1N2uSJ-xaj7bS9dxyOW9o">{{-- Update this in a later commit to use the key in the env, Possibly a secured key that is usable by only one server --}}
			</div>
			<div id="qr">
				{!! $ticket->qr() !!}
			</div>
		</main>
	</body>
</html>
