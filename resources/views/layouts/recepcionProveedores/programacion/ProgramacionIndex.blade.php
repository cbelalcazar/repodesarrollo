@extends('app')

@section('content')
@include('includes.titulo')
<div ng-controller="programacionCtrl as ctrl" ng-cloak>
	<div>
		<ul class="nav nav-tabs">
			<li  class="active"><a data-toggle="tab" href="#menu1">Ordenes en planeacion</a></li>
			<li><a data-toggle="tab" href="#menu2">Ordenes pendiente asignar cita</a></li>
		</ul>
		<div class="tab-content">
			<!-- tab ordenes en planeacion -->
			<div id="menu1" class="tab-pane fade in active">
				<div class="panel panel-default">
					<div class="panel-body">

						<button type="button"  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="limpiar()" name="programar">
							<i class="glyphicon glyphicon-plus"></i> Programar
							<md-tooltip md-direction="bottom">
								Crear nueva
							</md-tooltip>
						</button>

						<button type="button"  class="btn btn-info btn-sm" ng-click="cambiaEstado()">
							<i class="glyphicon glyphicon-gift"></i> Enviar a bodega
							<md-tooltip md-direction="bottom">
								Enviar programacion a solicitud cita
							</md-tooltip>
						</button>

						<button type="button"  class="btn btn-danger btn-sm" ng-click="eliminarSeleccionadas($event)">
							<i class="glyphicon glyphicon-trash"></i> Eliminar seleccionadas
							<md-tooltip md-direction="bottom">
								Eliminar todas las ordenes programaciones seleccionadas
							</md-tooltip>
						</button>


						<br><br>
						<div class="alert alert-success" ng-if="mensajeEliminar">
							<strong>Registro eliminado exitosamente.</strong> 
						</div>
						<table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" dt-instance="dtInstance">
							<thead>
								<tr>
									<th>
										<md-checkbox class="md-primary" aria-label="Select All"
										ng-checked="isChecked()"
										md-indeterminate="isIndeterminate()"
										ng-click="toggleAll()">
										<!--  <span ng-if="isChecked()">Anular </span>Seleccionar Todas -->
										</md-checkbox>
									</th>
									<th>Referencia</th>
									<td>Proveedor</td>
									<th>Orden compra</th>
									<th>Fecha programada</th>
									<th>Cant. programada</th>
									<th>Embalaje</th>
									<th>Cant. Solicitada OC</th>
									<th>Cant. Pendiente OC</th>
									<th>Estado</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="prg in progPendEnvio | filter : filtroDobleEstado">
									<td>
										<md-checkbox ng-checked="exists(prg, progSelected)" ng-click="toggle(prg, progSelected)" class="md-primary">
											@{{prg.id}}
										</md-checkbox>                   
									</td>                 
									<td>@{{prg.prg_referencia}} - @{{prg.prg_desc_referencia}}</td>                   
									<td>@{{prg.prg_razonSocialTercero}}</td>
									<td>@{{prg.prg_tipo_doc_oc}} - @{{prg.prg_num_orden_compra}}</td>
									<td>@{{prg.prg_fecha_programada  | date:'M/dd/yyyy'}}</td>
									<td>@{{prg.prg_cant_programada}} - @{{prg.prg_unidadreferencia}}</td>
									<td>@{{prg.prg_cantidadempaques}} - @{{prg.prg_tipoempaque}}</td>
									<td>@{{prg.prg_cant_solicitada_oc}}</td>
									<td>@{{prg.prg_cant_pendiente_oc}}</td>  
									<td ng-if="prg.prg_estado == 4">Rechazada</td>
									<td ng-if="prg.prg_estado == 1">Creada</td>    
									<td class="text-right" style="white-space:nowrap;"> 
										<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="edit(prg)">
											<i class="glyphicon glyphicon-pencil"></i>
											<md-tooltip md-direction="bottom">
												Actualizar registro
											</md-tooltip> 
										</button>
										<button class="btn btn-danger btn-sm" ng-click="showConfirm($event, prg)" >
											<i class="glyphicon glyphicon-trash"></i>
											<md-tooltip md-direction="bottom">
												Borrar registro
											</md-tooltip> 
										</button>
									</td>                  
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="menu2" class="tab-pane fade">

				<div class="panel panel-default">
					<div class="panel-body">

						<table  datatable="ng" dt-options="dtOptions2" dt-column-defs="dtColumnDefs2" class="row-border hover">
							<thead>
								<tr>
									<th>Id</th>
									<th>Referencia</th>
									<td>Proveedor</td>
									<th>Orden de compra</th>
									<th>Fecha programada</th>
									<th>Cantidad programada</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="prgCita in progPendEnvio | filter: {prg_estado : 2}">              
								</td>        
								<td>@{{prgCita.id}}</td>         
								<td>@{{prgCita.prg_referencia}} - @{{prgCita.prg_desc_referencia}}</td>
								<td>@{{prgCita.prg_razonSocialTercero}}</td>
								<td>@{{prgCita.prg_tipo_doc_oc}} - @{{prgCita.prg_num_orden_compra}}</td>
								<td>@{{prgCita.prg_fecha_programada  | date:'M/dd/yyyy'}}</td>
								<td>@{{prgCita.prg_cant_programada}}</td>  
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
</div>

@include('layouts.recepcionProveedores.programacion.programacionForm')
<div ng-if="progress" class="progress">
	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/programacion/programacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush