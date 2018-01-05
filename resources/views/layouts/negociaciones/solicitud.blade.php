<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario crear solicitud negociaciones -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A. -->
<!-- ******************************************************************** -->
@extends('app')
@section('content')
@include('includes.titulo')
<link rel="stylesheet" href="{{url('/css/negociaciones/solicitudCss.css')}}">
<div ng-controller='solicitudCtrl as ctrl' class="col-md-12" ng-init="getInfo()" ng-cloak>
	<form name="solicitudForm" class="form-horizontal" ng-submit="solicitudForm.$valid && save()" novalidate >
		<md-content>
		    <md-tabs md-dynamic-height md-border-bottom>
		      <md-tab label="Información de Solicitud">
		        <md-content class="md-padding">
					<div class="container-fluid">
						<!-- Vendedor -->
							<div class="form-group col-sm-6">
								<label>Vendedor: </label>							
								<input type="text" class="form-control input-sm" ng-model="objeto.usuario" readonly disabled required> 
							</div>			
						<!-- end vendedor -->

			        	<!-- fecha solicitud -->
				          	<div class="form-group col-sm-6">
								<label>Fecha de solicitud: 
									<font color="red">*</font>
								</label>							
								<input type="text" class="form-control input-sm" ng-model="objeto.sol_fecha" readonly disabled required>
							</div>						
						<!-- end fecha solicitud -->	


						<!-- clase negociacion -->
							<div class="form-group col-sm-6">
								<label>Clase negociación: 
									<font color="red">*</font>
								</label>
								<select ng-model="objeto.sol_clase" required class="form-control input-sm" ng-options="opt.cneg_descripcion for opt in claseNegociacion track by opt.id">
										<option value="">Seleccione..</option>
								</select>						
							</div>
						<!-- end clase negociacion -->	

						<!-- negociacion año anterior -->
							<div class="form-group  col-sm-6">
								<label>Negociación año anterior:
									<font color="red">*</font>
								</label>
								<select ng-model="objeto.sol_huella_capitalizar" required class="form-control input-sm" ng-options="opt.nant_descripcion for opt in negoAnoAnterior track by opt.id">
									<option value="">Seleccione..</option>
								</select>				
							</div>
						<!-- end negociacion año anterior -->	

						<!-- tipo de negociacion -->
							<div class="form-group col-sm-6">
								<label>Tipo de negociación:
									<font color="red">*</font>
								</label>
								<select ng-model="objeto.sol_tipo" required class="form-control input-sm" ng-options="opt.tneg_descripcion for opt in tipNegociacion track by opt.id">
									<option value="">Seleccione..</option>
								</select>								
							</div>
						<!-- end tipo de negociacion -->	

						<!-- canal -->
							<div class="form-group col-sm-6">
								<label>Canal:
									<font color="red">*</font>
								</label>
								<select ng-model="objeto.sol_can_id" ng-change="limpiarSucursales()" required class="form-control input-sm" ng-options="opt.can_txt_descrip for opt in canales track by opt.can_id">
									<option value="">Seleccione..</option>
								</select>				
							</div>
						<!-- end canal -->	

						<!-- Cliente -->
							<div class="form-group col-sm-6">
								<label>Clientes:
									<font color="red">*</font>
								</label>
								<select  ng-model="objeto.sol_cli_id" required  ng-disabled="objeto.sol_can_id == undefined" ng-change="formatoDescuentoComer()" class="form-control input-sm" ng-options="[opt.razonSocialTercero_cli, opt.ter_id].join(' - ') for opt in consultaClientes() track by opt.cli_id">
									<option value="">Seleccione..</option>
								</select>				
							</div>
						<!-- end Cliente -->	

						<!-- negociacion para -->
							<div class="form-group col-sm-6" >
								<label>Negociación para:
									<font color="red">*</font>
								</label>
								<select ng-change="limpiar()" ng-model="objeto.sol_tipocliente" required class="form-control input-sm"  ng-disabled="objeto.sol_cli_id == undefined" ng-options="opt.npar_descripcion for opt in negociacionPara track by opt.id">
									<option value="">Seleccione..</option>
								</select>								
							</div>
						<!-- end negociacion para -->	

						<!-- Zonas -->
							<div class="col-sm-12"  ng-if="objeto.sol_tipocliente.id == 1">
								<div class="panel panel-primary">
								    <div class="panel-heading">
										Zonas
								    </div>
								    <div class="panel-body">
								    	<div class="alert alert-warning">
											La suma del porcentaje de participación debe ser igual a 100.
										</div>										
										<!-- tabla -->
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Zona</th>
													<th>Porcentaje participación</th>
													<th>Acción</th>
												</tr>											
											</thead>
											<tbody>
												<tr>
													<!-- Capturar zona -->
														<td>
															<div class="form-group">
																<label style="text-align: center">
																<select ng-model="objNegCliente.szn_coc_id" class="form-control input-sm" ng-options="opt.cen_txt_descripcion for opt in zonas track by opt.cen_id">
																	<option value="">Seleccione..</option>
																</select>
															</div>
														</td>
													<!-- end capturar zona -->

													<!-- capturar porcentaje de participacion -->
														<td>
															<div class="form-group">
																<input placeholder="Maximo: @{{calcularMaximo()}}" type="number" class="form-control input-sm" ng-model="objNegCliente.szn_ppart" min="1" max="@{{calcularMaximo()}}">
															</div>
														</td>
													<!-- end porcentaje de participacion -->

													<!-- accion -->
														<td>
															<button class="btn btn-success btn-sm" type="button" ng-click="agregarZona(objNegCliente)"><i class="glyphicon glyphicon-plus"></i></button>
														</td>
													<!-- end accion -->
												</tr>
												<tr ng-if="arrayZona.length == 0">
													<td colspan="3" style="text-align: center">Favor agregar al menos una zona..</td>
												</tr>
												<tr ng-repeat="(key, value) in arrayZona">
													<td>@{{value.szn_coc_id.cen_txt_descripcion}}</td>
													<td>@{{value.szn_ppart}}</td>
													<td>
														<button type="button" class="btn btn-danger btn-sm" ng-click="removeZona(value)"><i class="glyphicon glyphicon-remove"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
								    </div>
								  </div>
							</div>
						<!-- End Zonas -->

						<!-- Sucursales  -->
							<div class="col-sm-12" ng-if="objeto.sol_tipocliente.id == 2" >
								<div class="panel panel-primary">
								    <div class="panel-heading">
										Sucursales
								    </div>
								    <div class="panel-body">
								    	<div class="alert alert-warning" ng-if="arraySucursales.length > 0">
											La suma del porcentaje de participación debe ser igual a 100 faltan @{{calculaFaltanteSucu()}}.
										</div>		
										<!-- multiselect -->
											<div class="col-sm-10">
												<label>Seleccionar sucursales:</label>
												<multiselect ng-model="objeto.sucursales" options="nuevoFiltrado" id-prop="suc_id" display-prop="descripcionConId" show-select-all="true" show-unselect-all="true" show-search="true" placeholder="Seleccionar una sucursal..." labels="labels"></multiselect>
											</div>
											<div class="col-sm-2">
												<label>&nbsp;</label><br>
												<button class="btn btn-primary" type="button" ng-click="agregarSucursales()"><i class="glyphicon glyphicon-plus"></i></button>
											</div>
										<!-- end multiselect -->
								
										<!-- tabla -->
										<br><hr><br>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Sucursal</th>
													<th>% participacion</th>
													<th>Acción</th>
												</tr>											
											</thead>
											<tbody>
												<tr ng-if="arraySucursales.length == 0">
													<td colspan="3" style="text-align: center">Favor agregar al menos una sucursal..</td>
												</tr>
												<tr ng-repeat="(key, value) in arraySucursales">
													<td>@{{value.descripcionConId}}</td>
													<td>
														<div class="input-group">
													      	<span class="input-group-btn">
													    		<button ng-click="agregarFaltante(value)" class="btn btn-success" type="button">
																	<i class="glyphicon glyphicon-refresh"></i>
													    			<md-tooltip md-direction="left">Sumar Faltante</md-tooltip>
													    		</button>
													      	</span>
													    	<input type="number" min="0" string-to-number class="form-control" ng-model="value.porcentParti">
													    </div>														
													</td>
													<td>
														<button type="button" class="btn btn-danger btn-circle" ng-click="removeSucursal(value)"><i class="glyphicon glyphicon-remove"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
								    </div>
								  </div>
							</div>
						<!-- End Sucursales -->

						<!-- nit -->
							<div class="form-group col-sm-4">
								<label>Nit:</label>
								<input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.sol_cli_id.ter_id">
							</div>
						<!-- end nit -->

						<!-- Descuento comercial % -->
							<div class="form-group col-sm-4">
								<label>Descuento comercial %:</label>
								<input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.sol_cli_id.cli_txt_dtocome">			
							</div>
						<!-- end Descuento comercial % -->

						<!-- Lista de precios -->
							<div class="form-group col-sm-4">
								<label>Lista de precios: </label>
								<input type="text" disabled readonly class="form-control input-sm" ng-model="objeto.listaprecios">					
							</div>
						<!-- end Lista de precios -->

						<!-- Periodo de facturacion -->
							<div>
								<!-- Titulo -->
									<div class="col-sm-12">
										<h5>
											<strong>Periodo de Facturación: </strong>
											<font color="red">*</font>
										</h5>
									</div>
								<!-- End titulo -->
								<!-- Periodo de facturación Desde -->
									<div class="form-group col-sm-3">
										<label>Inicio: </label>
										<md-datepicker required ng-model="objeto.sol_peri_facturaini" md-placeholder="Enter date" ng-change="diffmesesFacturacion()"></md-datepicker>											
									</div>
								<!-- end Periodo de facturación Desde -->
								<!-- Periodo de facturación Hasta -->
									<div class="form-group col-sm-3">
										<label>Fin: </label>
										<md-datepicker required ng-model="objeto.sol_peri_facturafin" md-placeholder="Enter date"  ng-change="diffmesesFacturacion()"></md-datepicker>					
									</div>
								<!-- end Periodo de facturación Hasta -->

								<!-- Periodo de facturación meses -->
									<div class="form-group  col-sm-6">
									    <label class="control-label col-sm-2">Meses: </label>
									    <div class="col-sm-10"> 
									    	<input required type="text" disabled readonly class="form-control input-sm" ng-model="objeto.sol_mesesfactu">		
									    </div>
									</div>
								<!-- end Periodo de facturación meses -->
							</div>
						<!-- End Periodo de facturacion -->

						<!-- Periodo de ejecución (informativo) -->
							<div>
								<!-- Titulo -->
									<div class="col-sm-12">
										<h5>
											<strong>Periodo de ejecución (informativo) </strong>
											<font color="red">*</font>
										</h5>
									</div>
								<!-- End titulo -->
								<!-- Periodo de ejecucion Desde -->
									<div class="form-group col-sm-3">
										<label>Inicio: </label>
										<md-datepicker required ng-model="objeto.sol_peri_ejeini" md-placeholder="Enter date" ng-change="diffmesesEjecucion()"></md-datepicker>											
									</div>
								<!-- end Periodo de ejecucion Desde -->
								<!-- Periodo de facturación Hasta -->
									<div class="form-group col-sm-3">
										<label>Fin: </label>
										<md-datepicker required ng-model="objeto.sol_peri_ejefin" md-placeholder="Enter date"  ng-change="diffmesesEjecucion()"></md-datepicker>						
									</div>
								<!-- end Periodo de facturación Hasta -->

								<!-- Periodo de ejecucion meses -->
									<div class="form-group  col-sm-6">
									    <label class="control-label col-sm-2">Meses: </label>
									    <div class="col-sm-10"> 
									    	<input required type="text" disabled readonly class="form-control input-sm" ng-model="objeto.sol_meseseje">		
									    </div>
									</div>
								<!-- end Periodo de ejecucion meses -->
							</div>
						<!-- End Periodo de ejecucion -->

						<!-- Observaciones -->
							<div class="form-group  col-sm-12">
								<label>Observaciones: 
									<font color="red">*</font>
								</label>
								<input type="text" maxlength="255" ng-model="objeto.sol_ltxt_observ" class="form-control">					
							</div>
						<!-- end Observaciones -->	


						<!-- Evento o temporada -->
							<div class="form-group col-sm-6">
								<label>Evento o temporada: 
									<font color="red">*</font>
								</label>
								<select ng-model="objeto.sol_evt_id" required class="form-control input-sm" ng-options="[opt.descTipoEvento, opt.evt_descripcion].join(' - ') for opt in arrayEventoTemp track by opt.evt_id">
										<option value="">Seleccione..</option>
								</select>						
							</div>
						<!-- end Evento o temporada -->	

						<!-- Tipo de negociaciones -->
							<div class="col-sm-12">
								<div class="panel panel-primary">
								    <div class="panel-heading">
										Tipo de negociaciones
								    </div>
								    <div class="panel-body">								
										<!-- tabla -->
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Descripción</th>
													<th>Tipo de servicio</th>
													<th>Costo</th>
													<th>Acción</th>
												</tr>											
											</thead>
											<tbody>
												<tr>
													<!-- Descripcion -->
														<td>
															<div class="form-group">
																<select ng-model="objtipoNeg.stn_tin_id" ng-change="filtrarTiposServicios(objtipoNeg.stn_tin_id.tin_id)" class="form-control input-sm" ng-options="opt.tin_descripcion for opt in tipoDeNegociacion track by opt.tin_id">
																	<option value="">Seleccione..</option>
																</select>
															</div>
														</td>
													<!-- end Descripcion -->

													<!-- Tipo de servicio -->
														<td>
															<div class="form-group">
																<select ng-model="objtipoNeg.stn_ser_id" class="form-control input-sm" ng-options="opt.ser_descripcion for opt in tipoDeServicioFilt track by opt.ser_id">
																	<option value="">Seleccione..</option>
																</select>
															</div>
														</td>
													<!-- end Tipo de servicio -->

													<!-- Costo -->
														<td>
															<div class="form-group">
																<input type="number" class="form-control" ng-model="objtipoNeg.stn_costo" min="1">
															</div>
														</td>
													<!-- end Costo -->

													<!-- accion -->
														<td>
															<button class="btn btn-success btn-sm" type="button" ng-click="agregarTipoNegociacion(objtipoNeg)"><i class="glyphicon glyphicon-plus"></i></button>
														</td>
													<!-- end accion -->
												</tr>
												<tr ng-if="arrayTipoNegociacion.length == 0">
													<td colspan="4" style="text-align: center">Favor agregar al menos tipo de negociacion</td>
												</tr>
												<tr ng-repeat="(key, value) in arrayTipoNegociacion">
													<td>@{{value.stn_tin_id.tin_descripcion}}</td>
													<td>@{{value.stn_ser_id.ser_descripcion}}</td>
													<td>@{{value.stn_costo}}</td>
													<td>
														<button type="button" class="btn btn-danger btn-sm" ng-click="removeTipoNegociacion(value)"><i class="glyphicon glyphicon-remove"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
								    </div>
								  </div>
							</div>
						<!-- End Tipo de negociacion -->


						<!-- Causales de negociación -->
							<div class="col-sm-12">
								<div class="panel panel-primary">
								    <div class="panel-heading">
										Causal de negociaciones
								    </div>
								    <div class="panel-body">								
										<!-- tabla -->
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Descripción</th>
													<th>Acción</th>
												</tr>											
											</thead>
											<tbody>
												<tr>
													<!-- Causales de negociacion -->
														<td>
															<div class="form-group">
																<select ng-model="objCausalNego.scn_can_id" class="form-control input-sm" ng-options="opt.can_descripcion for opt in causalesNego track by opt.can_id">
																	<option value="">Seleccione..</option>
																</select>
															</div>
														</td>
													<!-- end Descripcion -->

													<!-- accion -->
														<td>
															<button class="btn btn-success btn-sm" type="button" ng-click="agregarCausalNegociacion(objCausalNego)"><i class="glyphicon glyphicon-plus"></i></button>
														</td>
													<!-- end accion -->
												</tr>
												<tr ng-if="arrayCausalNegociacion.length == 0">
													<td colspan="4" style="text-align: center">Favor agregar al menos una causal de negociacion</td>
												</tr>
												<tr ng-repeat="(key, value) in arrayCausalNegociacion">
													<td>@{{value.scn_can_id.can_descripcion}}</td>
													<td>
														<button type="button" class="btn btn-danger btn-sm" ng-click="removeCausalNegociacion(value)"><i class="glyphicon glyphicon-remove"></i></button>
													</td>
												</tr>
											</tbody>
										</table>
								    </div>
								  </div>
							</div>
						<!-- End Causales de negociación -->
						
						<!-- Botones -->
							<div class="col-sm-12">
								
									<div class="col-sm-6"></div>
								
									<div class="col-sm-6">
										<!-- btn Save -->
											<div class="col-sm-6"></div>
											<div class="col-sm-2">
												<button class="btn btn-success btn-circle btn-lg  pull-right">
													<i class="glyphicon glyphicon-floppy-save"></i>
												</button>
											</div>									
										<!-- end btn save -->
										<!-- btn cancelar -->
											<div class="col-sm-2">
												<button class="btn btn-danger btn-circle btn-lg  pull-right">
													<i class="glyphicon glyphicon-remove"></i>
												</button>
											</div>										
										<!-- end btn cancelar -->
										<!-- btn adelante -->
											<div class="col-sm-2">
												<button class="btn btn-primary btn-circle btn-lg  pull-right">
													<i class="glyphicon glyphicon-chevron-right"></i>
												</button>
											</div>										
										<!-- end btn adelante -->
									</div>
							</div>
						<!-- End Botones -->
						
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
