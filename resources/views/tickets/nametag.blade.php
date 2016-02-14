<!DOCTYPE html>
<html lang="en">
<head>
	<title>Printable Nametag</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
	<style>
		.card{
			width:3.5in;
			height:2in;
		}

		.valign{
			width:3in;
		}

		.card .card-content .card-title{
			line-height:23px;
		}
		.card-content p{
			font-size: 12px;
		}
	</style>
</head>
<body>
<main class="container row">
	<div class="col s6">
		<div class="card valign-wrapper">
			<div class="card-content valign row">
				<div class="col s4">
					<img src="{{$ticket->user->profile_picture}}" class="responsive-img circle">
				</div>
				<div class="col s8">
					<span class="card-title
						@if($ticket->user->is_admin)red-text
						@elseif($ticket->user->is_staff)green-text @endif
					">{{$ticket->user->name}}.</span>
					<p>
						@if($ticket->user->is_admin)
							Administrator
						@elseif($ticket->user->is_staff)
							Event Staff
						@else
							{{$ticket->event->title}}
						@endif</p>
				</div>
			</div>
		</div>
	</div>
</main>
<script>window.print(); window.close();</script>
</body>
</html>