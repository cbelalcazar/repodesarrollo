@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller='solicitudCtrl as ctrl' class="col-md-12" ng-init="getInfo()" ng-cloak>
	<form name="solicitudForm" ng-submit="solicitudForm.$valid && save()" novalidate >
		<md-content>
		    <md-tabs md-dynamic-height md-border-bottom>
		      <md-tab label="Información de Solicitud">
		        <md-content class="md-padding">
		          	<div class="form-group">
						<label>Fecha de solicitud</label>
						<input type="text" class="form-control" ng-model="objeto.sol_fecha" disabled required>
					</div>
					<div class="form-group">
						<label>Vendedor: @{{objeto.usuario}}</label>
						<input type="hidden" class="form-control" ng-model="objeto.sol_ven_id">
					</div>
		        </md-content>
		      </md-tab>
		    </md-tabs>
		</md-content>
	</form>

	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>

</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/negociaciones/solicitudCtrl.js')}}"></script>
@endpush
