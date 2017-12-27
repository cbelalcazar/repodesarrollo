@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller='solicitudCtrl as ctrl' class="col-md-12" ng-init="getInfo()" ng-cloak>
	<form name="solicitudForm" ng-submit="solicitudForm.$valid && save()" novalidate >
		<md-content>
		    <md-tabs md-dynamic-height md-border-bottom>
		      <md-tab label="Información de Solicitud">
		        <md-content class="md-padding">

		        	<!-- Vendedor -->
						<div class="form-group"> 
							<br>
							<label>Vendedor: </label>&nbsp;@{{objeto.usuario}}
							<hr>
						</div>
					<!-- end vendedor -->

		        	<!-- fecha solicitud -->
			          	<div class="form-group">
							<label>Fecha de solicitud: 
								<font color="red">*</font>
							</label>
							<input type="text" class="form-control" ng-model="objeto.sol_fecha" disabled required>
						</div>						
					<!-- end fecha solicitud -->	

					<!-- clase negociacion -->
						<div class="form-group">
							<label>Clase negociación: <font color="red">*</font></label>
							<select ng-model="objeto.sol_clase" class="form-control" ng-options="opt.cneg_descripcion for opt in claseNegociacion track by opt.id">
								<option value="">Seleccione..</option>
							</select>
						</div>
					<!-- end clase negociacion -->	

					<!-- negociacion año anterior -->
						<div class="form-group">
							<label>Negociación año anterior:
								<font color="red">*</font>
							</label>
							<select ng-model="objeto.sol_huella_capitalizar" class="form-control" ng-options="opt.nant_descripcion for opt in negoAnoAnterior track by opt.id">
								<option value="">Seleccione..</option>
							</select>
						</div>
					<!-- end negociacion año anterior -->	

					<!-- tipo de negociacion -->
						<div class="form-group">
							<label>Tipo de negociación:
								<font color="red">*</font>
							</label>
							<select ng-model="objeto.sol_tipo" class="form-control" ng-options="opt.tneg_descripcion for opt in tipNegociacion track by opt.id">
								<option value="">Seleccione..</option>
							</select>
						</div>
					<!-- end tipo de negociacion -->	

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
