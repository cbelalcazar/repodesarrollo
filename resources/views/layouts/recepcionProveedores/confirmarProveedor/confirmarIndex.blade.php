@extends('app')

@section('content')

@include('includes.titulo')
<link href="{{url('/css/recepcionProveedores/confirmarIndex.css')}}" type="text/css" rel="stylesheet"/>
<div ng-controller="confirmProveedorCtrl as ctrl" ng-cloak>
	<div class="container container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">Citas</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#citas"><span class="badge badge-info">@{{noProgramables.length}}</span> &nbsp; Solicitar citas </a></li>
							<li><a data-toggle="tab" href="#programaciones"><span class="badge badge-info">@{{citas.length}}</span> &nbsp; Confirmar programaciones</a></li>
							<li><a data-toggle="tab" href="#confirmadas"><span class="badge badge-info">@{{confirmadas.length}}</span> &nbsp; Citas confirmadas</a></li>
						</ul>

						<div class="tab-content">
							<div id="citas" class="tab-pane fade in active">
								<form name="citaForm" ng-submit="citaForm.$valid && generarCita($event)" class="row" novalidate>
									<div class="col-md-11">
										<div class="container-fluid">
											<div class="form-group">
												<label>SELECCIONAR FECHA DE ENTREGA:</label>
												<md-datepicker ng-model="fechaEntrega" md-placeholder="Ingresar fecha" md-min-date="minDate" ng-change="validarSiCambioFecha(this)" required></md-datepicker>
												<hr>

											</div>
											<!-- table -->
											<p ng-if="(fechaEntrega != '')">Las ordenes que tienen <strong style="color:red;">(Dif. Dias) en rojo</strong> indican al proveedor que tendra mala calificacion en caso de confirmar cantidades y dar click en boton SOLICITAR CITA</p>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>ORDEN</th>
														<th>REFERENCIA</th>
														<th>FECHA ENTREGA</th>
														<th>CANT</th>
														<th ng-if="(fechaEntrega != '')">CONFIR. CANTIDAD</th>
														<th ng-if="(fechaEntrega != '')">DIF. DIAS</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-if="noProgramables.length == 0">
														<td colspan="4" style="text-align: center;">No se encontraron registros...</td>
													</tr>
													<tr ng-repeat="prog in noProgramables">
														<td>@{{prog['prg_tipo_doc_oc']}} - @{{prog['prg_num_orden_compra']}}</td>
														<td>@{{prog['prg_referencia']}} - @{{prog['prg_desc_referencia']}}</td>
														<td>@{{prog['prg_fecha_programada']}}</td>
														<td>@{{prog['prg_cant_programada']}}</td>
														<td ng-if="(fechaEntrega != '')">
															<input type="number" class="form-control cajitas" ng-model="prog['confirCantidad']" max="@{{prog['prg_cant_programada']}}" min="1">
															<label  ng-if='validarVacios(prog["confirCantidad"])' > Embalaje:</label>
															<select ng-if='validarVacios(prog["confirCantidad"])' ng-model="prog['tipoEmpaque']" class="form-control combitos" required>
																<option value="">Seleccionar...</option>
																<option value="Bidon">Bidon</option>
																<option value="Caja">Caja</option>
																<option value="Tambor">Tambor</option>
																<option value="Saco">Saco</option>
															</select>
															<label ng-if='validarVacios(prog["confirCantidad"])'> de </label>
															<input ng-if='validarVacios(prog["confirCantidad"])')" type="number" class="form-control cajitas" ng-model="prog['cantEmpaque']" min="1" required>
														</td>
														<td ng-if="(fechaEntrega != '')">
															
														</td>
														<td ng-if="(prog['difDias'] <= 4) && (fechaEntrega != '')">	@{{prog['difDias']}}
														</td>
														<td ng-if="(prog['difDias'] > 4) && (fechaEntrega != '')" style="color:red;"> 
															<strong>@{{prog['difDias']}}</strong>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										

									</div>
									<div class="col-md-1" style="max-height: 400px;">
										<button ng-if="(fechaEntrega != '')" class="btn btn-success" style="position:fixed; bottom:5px; right:10px;">Solicitar cita</button>
									</div>

								</form>
								
							</div>
							<div id="programaciones" class="tab-pane fade">
								<div>
									<div class="col-md-12">
										<hr>
										<h3>Confirmar programaciones</h3>
										<hr><br>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Fecha</th>
													<th>Detalle cita</th>
												</tr>
											</thead>
											<tbody>
												<tr ng-if="(citas.length == 0)">
													<td colspan="2" style="text-align: center;">No se encontraron registros...</td>
												</tr>
												<tr ng-repeat="cit in citas">
													<td>@{{cit.cit_fechainicio}}</td>
													<td><button class="btn btn-info "  data-toggle="modal" data-target="#modal1" ng-click="seleccionarCita(cit)"><span class="glyphicon glyphicon-eye-open"></span></button></td>
												</tr>
											</tbody>
										</table>
									</div>					
								</div>
								
							</div>
							<div id="confirmadas" class="tab-pane fade">
								<hr>
								<h3>Citas confirmadas</h3>
								<hr><br>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Fecha</th>
											<th>Detalle cita</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-if="confirmadas.length == 0">
											<td colspan="2" style="text-align: center;">No se encontraron registros...</td>
										</tr>
										<tr ng-repeat="confir in confirmadas">
											<td>@{{confir.cit_fechainicio}}</td>
											<td>
											<button class="btn btn-info "  data-toggle="modal" data-target="#modal1" ng-click="seleccionarCita(confir, false)"><span class="glyphicon glyphicon-eye-open"></span></button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
	@include('layouts.recepcionProveedores.confirmarProveedor.confirmarForm')
	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>

@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/confirmarProveedor/confirmarProveedorCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush