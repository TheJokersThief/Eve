@extends('layouts.app')

@section('body-class') usersAccount-page @endsection

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
				"method" => "POST",
				"files" => true
			]) !!}

			<div class="col l9 m8 s12"/>
				<ul class="collection flow-text input-field">
					<li class="collection-item"><strong>edit name:</strong> 
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>	
						{!! Form::text('name', $me->name, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit bio:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('bio', $me->bio, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit language:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('language', $me->language, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit city:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('city', $me->city, ["class" => "example"])!!}
					</li>
					<li class="collection-item"><strong>edit country:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::text('country', $me->country, ["class" => "example"])!!}
					</li>
				</ul>
				<ul class="collection flow-text">
					<li class="collection-item"><strong>Change password:</strong>
						<div class="secondary-content">
							<i class="fa fa-pencil teal-text"></i>
						</div>
						{!! Form::password('password', null, ["class" => "example"] ) !!}
					</li>
				</ul>
				<ul class="collection flow-text file-field input-field">
					<li class="collection-item"><strong>profile picture</strong>
						<div class="secondary-content">
						    <div class="btn">
    							<span>File</span>
   								{!! Form::file('profile_picture')!!}
  							</div>
  							<div class="file-path-wrapper">
						        <input class="file-path validate" type="text">
						    </div>
						</div>
					</li>
				</ul>
				{!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</main>
@endsection