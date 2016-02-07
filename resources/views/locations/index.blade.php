@extends('layouts.app')

@section('body-class') locations-index locations @endsection

@section('content')

<div class="row">
	<ul class="collection with-header col s12 m8 offset-m2 l6 offset-l3">
		<li class="collection-header">
			<a href="{{ URL::route('locations.create') }}" class="waves-effect waves-light btn right add-new-button"><i class="fa fa-plus left"></i>Add New Location</a>
			<h4>Locations</h4>
		</li>

		@foreach( $locations as $location )
			<li class="collection-item">
				<div>
					<strong>{{ $location->name }}</strong>
					<br /><small>({{ $location->capacity }} people)</small>
					<div class="secondary-content">
						<a href="{{ URL::route('locations.edit', ['location'=>$location->id]) }}">
							<i class="fa fa-pencil teal-text" alt="Edit Location"></i> &nbsp;
						</a>
						{{ Form::open(['route' => ['locations.destroy', $location->id], 'method' => 'delete', 'class' => 'inline-form']) }}
							<button type="submit" ><i class="fa fa-times red-text left" alt="Delete Location"></i></button>
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
