<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
			<form name="periodoForm" ng-submit="periodoForm.$valid && save()" novalidate>
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<button type="button" class="close" data-dismiss="modal aria-label="Cerrar">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title">@{{tituloModal}}</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="col-sm-12">
									<h4 class="text-primary">
										<strong>Consecutivo cita: @{{citaSeleccionada.id}}</strong>
									</h4>
									<hr><br>
									<label for="inicio">Hora de inicio: </label> @{{citaSeleccionada.cit_fechainicio}}
									<br><hr>
									<table class="table">
										<thead>
											<tr>
												<th>Orden</th>
												<th>Referencia</th>
												<th>Cantidad</th>
												<th>Embalaje</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-repeat="prog in citaSeleccionada.programaciones">
												<td>@{{prog.prg_tipo_doc_oc}} - @{{prog.prg_num_orden_compra}}</td>
												<td>@{{prog.prg_referencia}} - @{{prog.prg_desc_referencia}}</td>
												<td>@{{prog.prg_cant_programada}}</td>
												<td>@{{prog.prg_cantidadempaques}} - @{{prog.prg_tipoempaque}}</td>
											</tr>
										</tbody>
									</table>
								</div> 

								<div class="col-sm-12">
									<div ng-if="alertas" class="col-sm-12">
											<div class="alert alert-danger alert-dismissable">                       
													<p ng-repeat="msj in mensajes">@{{msj[0]}}</p>              
											</div>
										</div>
								</div>

								<div class="col-sm-12" ng-if="obsRechazo">
									<h5><strong>Motivos del rechazo</strong></h5>
									<div class="checkbox">
									  <label><input type="checkbox" ng-model="checkbox.probFecha">Problemas con la fecha de entrega asignada</label>
									</div>
									<div class="checkbox">
									  <label><input type="checkbox" ng-model="checkbox.probHora">Problemas con la hora asignada</label>
									</div>
									<div class="checkbox">
									  <label><input type="checkbox" ng-model="checkbox.probCantidad">Problemas con la cantidad a entregar</label>
									</div>
									<div class="form-group">
										<label>Observaciones:</label>
										<textarea class="form-control" ng-model="observacionRechazo.obs" cols="100" rows="3" required></textarea>
									</div>
								</div>

							</div>
						</div>
						<div class="modal-footer">  
							<button class="btn btn-primary" ng-if="mostrarBotones" ng-click="confirmarCita()">
								Confirmar
							</button> 
							<button class="btn btn-danger"  ng-if="mostrarBotones" ng-hide="obsRechazo"  ng-click="cambiaEstado()">
								Rechazar
							</button> 
							<button class="btn btn-danger" ng-if="obsRechazo"  ng-click="generarRechazo()">
								Rechazar
							</button> 
							<button class="btn btn-secondary" data-dismiss="modal" type="button">
								Cerrar
							</button>
						</div>
					</div>
				</div>
			</form>
	</div>
</div>
