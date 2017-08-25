@extends('app')

@section('content')
@include('includes.titulo')
<style>
	hr {
    margin-top: 0px;
    margin-bottom: 10px;
	}
</style>
<div ng-controller="citaCtrl as ctrl" class="row" ng-cloak>
	<div class="col-md-4">
		<hr>
		<h4>Bandeja solictud cita</h4>
		<hr>
		<div style="height:250px; overflow-y: auto;">
			<div class="panel-group" id="accordion"  ng-if="programaciones[fecha].length != 0" role="tablist" aria-multiselectable="true" ng-repeat="(fecha, array) in programaciones">      
				<div class="panel panel-primary" style="margin-bottom:2px !important;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{fecha}}">
					<div class="panel-heading" role="tab" style="padding:5px 25px !important;  background-color:#337ab7 !important;">
						<h6 class="panel-title row pro-name" style="font-size: 13px;">
								@{{fecha | date: 'EEEE - dd/MMMM/yyyy'}}
						</h6>
					</div>
				</div>

				<div id="collapse@{{fecha}}" class="panel-collapse collapse" role="tabpanel">
					<div class="panel panel-default">
						<ul class="list-group">
							<li class="list-group-item" style="padding:0px;" ng-repeat="(key, value) in array | groupBy: 'prg_nit_proveedor'">

									<div class="panel-heading" role="tab" style="padding: 0px 2px 7px 7px;">
										<h4 class="panel-title row">
											<div class="col-sm-12">
												<md-button  ng-click="mostrarProgramaciones(fecha, value[0].prg_nit_proveedor)" class="btn btn-default btn-sm" md-click>@{{value[0].prg_razonSocialTercero}} &nbsp;</md-button>
											</div>
										</h4>
									</div>

							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>

		<div>
			<div id='external-events'>
				<div id='external-events-listing'>
					<hr>
					<h4>Programaciones pendientes: @{{seleccionadas[0].prg_razonSocialTercero}}</h4>
					<hr>
					<div class='fc-event' style="margin-bottom:1px; padding:5px;" drag-me ng-repeat="lista in seleccionadas" ng-mouseup="seleccionar(lista)">@{{lista.prg_tipo_doc_oc}} - @{{lista.prg_num_orden_compra}} - Ref: @{{lista.prg_referencia}} - Cant: @{{lista.prg_cant_programada}} - Embalaje: @{{lista.prg_cantidadempaques}} en @{{lista.prg_tipoempaque}} - @{{lista.prg_nit_proveedor}}</div>
				</div>
			</div>
		</div>

	</div>

	<div class="col-md-8">        
		<div ui-calendar="uiConfig.calendar"  calendar="myCalendar" ng-model="eventSources">   
		</div>
		<div class="col-sm-12">
			<md-button  ng-click="guardarProgramacion()" class="btn btn-default btn-sm pull-right" md-click>Guardar</md-button>
		</div>
	</div>
	<a class="btn" data-ng-click="test()">Test</a>  

	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>

@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/cita/citaCtrl.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-locale_es-co.js')}}"></script>
@endpush