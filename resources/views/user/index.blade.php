@extends('layouts.app')

@section('content')
	<main class="row">
		<div class="col s12 m8 offset-m2">
			<div class="col l3 m4, hide-on-small-only" id="userInfo">
				<div class="collection">
					<div class="hide-on-med-and-down">
						<img src={{$me->profile_picture}}>
					</div>

					<div class="row">
						<div class="col s10">
							<span class="card-title">User Name: {{$me->name}}</span>
							<p>{{$me->bio}}</p>
						</div>
					</div>
				</div>
			</div>

			{!! Form::open([
				"route" => 'user',
				"method" => "POST"
			]) !!}

			<div class="col l9 m8 s12"/>
				<ul class="collection flow-text input-field">
					<li class="collection-item"><strong>edit name:</strong> 
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>	
						{!! Form::text('name', $me->name, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit email:</strong> 
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('email', $me->email, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit bio:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('bio', $me->bio, ["class" => "example"])!!}
					</li>
				</ul>
				<ul class="collection flow-text">
					<li class="collection-item"><strong>password:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::password('password', null, ["class" => "example"])!!}
					</li>
				</ul>
				<ul class="collection flow-text file-field">
					<li class="collection-item"><strong>profile picture</strong>
						<div class="secondary-content">
						    <div class="btn">
    							<span>File</span>
   								<input type="file">
  							</div>
						</div>
					</li>
				</ul>
				<button class="btn waves-effect waves-light" type="submit" name="action">Submit
					<i class="mdi-content-send right"></i>
				</button> 
			</div>
			{!! Form::close() !!}
		</div>
	</main>
@endsection