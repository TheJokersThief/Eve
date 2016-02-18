@extends('layouts.app')

@section('body-class') staff-home-page @endsection
@section('title') Staff Panel @endsection

@section('extra-js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
@endsection

@section('content')


	<div class="row admin-with-sidebar">
		<div class="col s12 m8 offset-m2">
			<div class="col hide-on-small-only m4">
				<aside class="card">
					<div class="collection sidebar-scroll">
						<a href="#scanned" 	class="collection-item">Badges</a>
					</div>

				</aside>
			</div>
			<div class="col s12 m8">
				<div class="row scrollspy" id="partners" name="partners">
					<ul class="collection with-header">
						<li class="collection-header">
							<h4>Badges To Print</h4>
						</li>
						<!-- ko foreach: tickets -->
							<li class="collection-item" data-bind="attr:{'id':id}">
								<div>
									<strong data-bind="text:user.name"></strong>
									<br /><small data-bind="text:event.title">()</small>
									<div class="secondary-content">
										<a data-bind="click:$parent.print" href="#" target="_blank">
											<i class="fa fa-print teal-text tooltipped" alt="Print Ticket" data-tooltip="Print Ticket" data-position="bottom"></i> &nbsp;
										</a>
										<a href="#" data-bind="click:$parent.markPrinted">
											<i class="fa fa-check teal-text tooltipped" alt="Mark Done" data-tooltip="Mark Done" data-position="bottom"></i> &nbsp;
										</a>
									</div>
								</div>
							</li>
						<!-- /ko -->
					</ul>
					<a data-bind="click:update" class="waves-effect waves-light btn right">Reload <i class="fa fa-refresh right"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection
