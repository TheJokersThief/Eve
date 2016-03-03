@extends('layouts.app')

@section('body-class') locations-index locations @endsection
@section('title') {{_t('Places')}} @endsection


@section('content')

<div class="row">
	<ul class="collection with-header col s12 m8 offset-m2 l6 offset-l3">
		<li class="collection-header">
			<a href="{{ URL::route('locations.create') }}" class="waves-effect waves-light btn right add-new-button"><i class="fa fa-plus left"></i>{{_t('Add New Location')}}</a>
			<h4>{{_t('Locations')}}</h4>
		</li>

		@foreach( $locations as $location )
			<li class="collection-item">
				<div>
					<strong>{{ $location->name }}</strong>
					<br /><small>({{ $location->capacity }} {{_t('people')}})</small>
					<div class="secondary-content">
						<a href="{{ URL::route('locations.edit', ['location'=>$location->id]) }}">
							<i class="fa fa-pencil teal-text" alt="{{_t('Edit Location')}}"></i> &nbsp;
						</a>
						{{ Form::open(['route' => ['locations.destroy', Crypt::encrypt($location->id)], 'method' => 'delete', 'class' => 'inline-form']) }}
							<button type="submit" ><i class="fa fa-times red-text left" alt="{{_t('Delete Location')}}"></i></button>
						{{ Form::close() }}
					</div>
				</div>
			</li>
		@endforeach
		<li class="center">
			<div class="row">
				<br />
				@include('layouts.pagination.default', ['paginator' => $locations])
			</div>
		</li>
	</ul>
</div>
@endsection
