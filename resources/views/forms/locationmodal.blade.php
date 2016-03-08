<div id="locationForm" class="modal bottom-sheet">
	<div class="modal-content">
		<h4>{{_t('Create New Location')}}</h4>
		<ul id="location-errors" class="red white-text"></ul>
		{!! Form::open( ['route' => 'events.store', 'files' => true] ) !!}
		<div class="row">
			<div class="input-field col m6 s12">
				{!! Form::label('name',_t('Location Name'))	!!}
				{!! Form::text('name')	!!}
			</div>
			<div class="input-field col m6 s12">
				{!! Form::label('capacity',_t('Location Capacity'))	!!}
				{!! Form::number('capacity') !!}
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('latitude',_t('Latitude'))	!!}
				{!! Form::text('latitude', '53.2812223')	!!}
			</div>
			<div class="input-field col m5 s12">
				{!! Form::label('longitude',_t('Longitude'))	!!}
				{!! Form::text('longitude', '-7.3740124')	!!}
			</div>

			<div class="file-field input-field col m6 s12">
				<div class="btn">
					<span>{{_t('Feature Image')}}</span>
					{!! Form::file('featured_image') !!}
				</div>
				<div class="file-path-wrapper">
					<input class="file-path validate" type="text">
				</div>
			</div>

			<div class="row">
				<div class="input-field col s12">
					{!! Form::label('move-marker', 'Search map')!!}
					{!! Form::text('move-marker')!!}
				</div>
				<div id="map" class="row col s12 center-align" style="width: 40%; height: 300px;"></div>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
	<div class="modal-footer">
		<a href="#!" class="orange-text modal-action waves-effect waves-green btn-flat" onClick="createLocation()">{{_t('Create')}}</a>
		<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat" onClick="$('#location-select').val('');$('#location-select').material_select();">{{_t('Cancel')}}</a>
	</div>
</div>
