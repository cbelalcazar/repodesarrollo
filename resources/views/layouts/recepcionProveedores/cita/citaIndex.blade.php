@extends('app')

@section('content')
@include('includes.titulo')
<link href="{{url('/css/recepcionProveedores/cita.css')}}" type="text/css" rel="stylesheet"/>
<div ng-controller="citaCtrl as ctrl" class="row" ng-cloak>
	<div class="col-md-4">
		<hr>
		<h4>Bandeja solictud cita</h4>
		<hr>

		<div ng-if="programaciones.length == 0">
			No se encontraron registros....
		</div>

		<div class="bandeja">
			<div class="panel-group" id="mygroup"  ng-if="programaciones[fecha].length != 0" role="tablist" aria-multiselectable="true" ng-repeat="(fecha, array) in programaciones">      
				<div class="panel panel-primary fechal" role="button" data-toggle="collapse" data-parent="#mygroup" href="#collapse@{{fecha}}">
					<div class="panel-heading fecha2" role="tab">
						<h6 class="panel-title row pro-name fuenteFecha">
							@{{fecha | date: 'EEEE - dd/MMMM/yyyy'}}
						</h6>
					</div>
				</div>
				<div class="accordion-group">
					<div id="collapse@{{fecha}}" class="panel-collapse collapse" role="tabpanel">
						<div class="panel panel-default">
							<ul class="list-group">
								<li class="list-group-item liproveedor" ng-repeat="(key, value) in array | groupBy: 'prg_nit_proveedor'">

									<div class="panel-heading proveedor" role="tab">
										<h4 class="panel-title">
											<div>
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
		</div>

		<div>	
			<hr>
				<h4>Programaciones pendientes: @{{seleccionadas[0].prg_razonSocialTercero}}</h4>
			<hr>
			<div style="min-height:40px">
				<div ng-if="groupChekbox.length > 0" md-whiteframe="@{{ctrl.elevation}}" drag-me class="list-group-item arrastrable alert fc-event" style="font-size:12px; cursor: -moz-grab; cursor: -webkit-grab; cursor:grab">
					Cita para: @{{seleccionadas[0].prg_razonSocialTercero}} - Prog. selecc: @{{groupChekbox.length}}
					<md-tooltip>Mover al calendario</md-tooltip>
				</div>
			</div>
			
			<hr>
			<div flex-xs flex="50" ng-if="seleccionadas.length > 0">
	           	<md-checkbox aria-label="Select All"
	                         ng-checked="isChecked()"
	                         md-indeterminate="isIndeterminate()"
	                         ng-click="toggleAll()">
              		<span ng-if="isChecked()">Des-</span>Seleccionar
            	</md-checkbox>            	
            </div>           
            <div ng-if="seleccionadas.length == 0">
				Seleccionar un elemento de bandeja solicitud cita...
			</div>
            <div class="demo-select-all-checkboxes" style="font-size:11px;" flex="100" ng-repeat="lista in seleccionadas">            	
                <md-checkbox ng-checked="exists(lista, groupChekbox)" style="width:95%;display:inline-block;" ng-click="toggle(lista, groupChekbox)">
	               	@{{lista.prg_tipo_doc_oc}} - @{{lista.prg_num_orden_compra}} - <strong>Ref:	</strong> @{{lista.prg_referencia}} - <strong>Cant: </strong>@{{lista.prg_cant_programada}} - <strong>Embalaje: </strong>@{{lista.prg_cantidadempaques}} &nbsp; en @{{lista.prg_tipoempaque}}					
                </md-checkbox>
                <a href="#" ng-click="showPrompt($event, lista)" style="width:3%;display:inline-block;"  class="glyphicon glyphicon-remove pull-right linkcerrar"><md-tooltip>Rechazar programación</md-tooltip></a>
            </div>

		</div>
	</div>

	<div class="col-md-8">        
		<div ui-calendar="uiConfig.calendar"  calendar="myCalendar" ng-model="eventSources">   
		</div>
		<div class="col-sm-12">
			<md-button  ng-click="guardarCitas()" class="btn btn-success btn-sm pull-right" md-click>Guardar</md-button>
			<md-button  ng-click="recargarPagina()" class="btn btn-default btn-sm pull-right" md-click>Cancelar</md-button>
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
@endpush