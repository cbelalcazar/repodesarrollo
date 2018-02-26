<link rel="stylesheet" href="{{url('css/negociaciones/nivelesAutorizacion.css')}}">
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
    <div class="modal-content panel-primary">
	    <div class="modal-header panel-heading">
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	      <span aria-hidden="true">&times;</span>
	      </button>
	      <h4 ng-if="infoPerNivel.id == undefined" class="modal-title">Creación - @{{nivel[0].niv_descripcion}}</h4>
	      <h4 ng-if="infoPerNivel.id != undefined" class="modal-title">Actualizar - @{{nivel[0].niv_descripcion}}</h4>
	    </div>
		
		<form name="frmNivelesAuth" ng-submit="frmNivelesAuth.$valid && guardarPerNivel()" novalidate>		
		    <div class="modal-body">
	    		<div class="row">
					<div  class="col-md-12 col-lg-12 col-xs-12 col-sm-12" ng-if="infoPerNivel.id != undefined">
						<h4>Actualizar @{{infoPerNivel.pen_nombre}} - @{{infoPerNivel.pen_cedula}}</h4>
					</div>		    			

	    			<div class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
						<div class="form-group">
							<label>Tipo Persona:</label>

							<select class="form-control" ng-model="infoPerNivel.tipopersona" ng-options="tipoper.tpp_descripcion for tipoper in tipospersona track by tipoper.id" id-prop="can_id" display-prop="can_txt_descrip" ng-disabled="infoPerNivel.id != undefined" required>
								<option value="">Seleccione Tipo de Persona..</option>
							</select> 							
	
                      	</div>					
	    			</div> 	
					
					<div  ng-if="(infoPerNivel.tipopersona.id != undefined && nivel[0].id > 1 && infoPerNivel.id == undefined)" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
						<div class="form-group">
						<label>Persona(s):</label> 
							<multiselect class="span-margin" ng-model="infoPerNivel.persona" options="terceros" id-prop="idRowTercero" display-prop="cedulaNombre" placeholder="Seleccione Personas.." show-search="true" show-select-all="true" selection-limit="1" show-unselect-all="true" required></multiselect>
						</div>
					</div>
	    			

	    			<div ng-if="(infoPerNivel.tipopersona.id === 2 &&  nivel[0].id === 1) || (infoPerNivel.tipopersona.id === 2 &&  (nivel[0].id === 2 || nivel[0].id === 3 ))" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
						<div class="form-group">
							<label>Territorio:</label> 

							<multiselect  selection-limit="1" class="span-margin" ng-model="infoPerNivel.territorio" options="territorios" id-prop="id"  display-prop="tnw_descripcion" placeholder="Seleccione un Territorio.." show-select-all="true" show-unselect-all="true" required></multiselect> 			
																			
	    				</div>
	    			</div>		    

	    			<div ng-if="(infoPerNivel.tipopersona.id === 1 &&  nivel[0].id === 1) || (infoPerNivel.tipopersona.id === 1 &&  (nivel[0].id === 2 || nivel[0].id === 3) && (infoPerNivel.persona.length == 1 || infoPerNivel.id != undefined)) || (infoPerNivel.tipopersona.id === 3 &&  (nivel[0].id === 2 || nivel[0].id === 3 ))" class="col-md-6 col-lg-6 col-xs-6 col-sm-6">
						<div class="form-group">
							<label>Canal:</label> 
							<multiselect class="span-margin" ng-change="filtrarTercerosCan(infoPerNivel.tipopersona, infoPerNivel.canales, nivel[0])" ng-model="infoPerNivel.canales" options="canales" id-prop="can_id" display-prop="can_txt_descrip" show-select-all="true" placeholder="Seleccione Canales.." show-unselect-all="true" required></multiselect> 							
	    				</div>
	    			</div>		
    				    			
	    		</div>

	    		<hr class="border-top-dotted">

	    		<div class="panel panel-primary" ng-if="(nivel[0].id === 1 && infoPerNivel.canales.length > 0 && infoPerNivel.id == undefined && infoPerNivel.tipopersona.id == 1) || ((nivel[0].id === 2 || nivel[0].id === 3) && infoPerNivel.canales.length > 0 && infoPerNivel.tipopersona.id == 1)">
	    		  	<div class="panel-heading text-center">Personas Agregadas</div>
				    <div class="panel-body">
				    	<table ng-repeat="(key, canal) in infoPerNivel.canales" class="table table-bordered">
				    		<thead>
				    			<tr>
				    				<th colspan="3" style="text-align:center">@{{canal.can_txt_descrip}}</th>
				    			</tr>
				    			<tr>
				    				<th class="text-center">Cédula</th>
				    				<th class="text-center">Nombre</th>
				    				<th class="text-center">Acción</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<tr ng-if="infoPerNivel.terceros.length == 0">
				    				<td colspan="3" class="text-center">No hay registros en el momento</td>
				    			</tr>
				    			<tr>
				    				<td colspan="3">
				    					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
											<div class="form-group">
												<label>Persona(s):</label> 
												<multiselect ng-if="nivel[0].id === 1" class="span-margin" ng-model="canal.terceros" options="terceros" id-prop="idRowTercero" display-prop="cedulaNombre" placeholder="Seleccione Personas.." show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
												<multiselect ng-if="(nivel[0].id === 2 || nivel[0].id === 3)" class="span-margin" ng-model="canal.terceros" options="canal.tercerosFiltrados" id-prop="idRowTercero" display-prop="cedulaNombre" placeholder="Seleccione Personas.." show-search="true" show-select-all="true" show-unselect-all="true"></multiselect>
						    				</div>
						    			</div>	
				    				</td>
				    			</tr>
				    			<tr ng-if="canal.terceros.length > 0" ng-repeat="(key, tercero) in canal.terceros">
				    				<td class="text-center">@{{tercero.idTercero}}</td>
				    				<td class="text-center">@{{tercero.razonSocialTercero}}</td>
				    				<td class="text-center">
				    					<button  type="button" class="btn btn-danger" ng-click="eliminar(canal.terceros, tercero)"><i class="glyphicon glyphicon-remove"></i></button>
				    				</td>
				    			</tr>
				    		</tbody>
				    	</table>
				    </div>
				</div>

				<div  ng-if="(nivel[0].id === 1 || nivel[0].id === 2 || nivel[0].id === 3) && infoPerNivel.tipopersona.id == 2 && infoPerNivel.territorio.length > 0">
					<md-content>
					    <md-tabs class="tabsConfigured" md-dynamic-height md-border-bottom>
					      <md-tab ng-repeat="territorio in infoPerNivel.territorio" label="@{{territorio.tnw_descripcion}} @{{calcularCantidadPersonas(territorio.canales)}}">
					        <md-content class="md-padding content-tab-padre">
					        	<div class="form-group">
									<label>Canal:</label> 
									<multiselect class="span-margin"  ng-model="territorio.canales" options="canales" id-prop="can_id" display-prop="can_txt_descrip" ng-change="filtrarTercerosTerritorios(infoPerNivel.tipopersona, infoPerNivel.territorio, nivel[0].id)" show-select-all="true" placeholder="Seleccione Canales.." show-unselect-all="true"></multiselect>
		    					</div>
		    					<md-content>
								    <md-tabs ng-if="infoPerNivel.id == undefined" class="tabsConfigured-slim" md-dynamic-height md-border-bottom>
								      <md-tab ng-repeat="canTer in territorio.canales" label="@{{canTer.can_txt_descrip}} (@{{canTer.personas.length == undefined ? 0 : canTer.personas.length}})">
								        <md-content ng-if="infoPerNivel.id == undefined" class="md-padding content-tab-hijos">
								        	<div class="form-group">
												<label>Persona(s):</label> 
												<multiselect  ng-if="nivel[0].id === 1"  class="span-margin" ng-model="canTer.personas" options="terceros" id-prop="idRowTercero" display-prop="cedulaNombre" placeholder="Seleccione Personas.." show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect>
												<multiselect  ng-if="nivel[0].id === 2 || nivel[0].id === 3"  class="span-margin" ng-model="canTer.personas" options="canTer.tercerosFiltrados" id-prop="idRowTercero" display-prop="cedulaNombre" placeholder="Seleccione Personas.." show-search="true" show-select-all="true" show-unselect-all="true"></multiselect>
						    				</div>
						    				<table class="table table-responsive table-striped table-bordered">
									    		<thead>
									    			<tr>
									    				<th class="text-center">Cédula</th>
									    				<th class="text-center">Nombre</th>
									    				<th class="text-center">Acción</th>
									    			</tr>
									    		</thead>
									    		<tbody>
									    			<tr ng-if="canTer.personas.length == 0">
									    				<td colspan="3" class="text-center">No hay registros en el momento</td>
									    			</tr>
									    			<tr ng-if="canTer.personas.length > 0" ng-repeat="(key, tercero) in canTer.personas">
									    				<td class="text-center">@{{tercero.idTercero}}</td>
									    				<td class="text-center">@{{tercero.razonSocialTercero}}</td>
									    				<td class="text-center">
									    					<button  type="button" class="btn btn-danger" ng-click="eliminarPersonaDepende(tercero)"><i class="glyphicon glyphicon-remove"></i></button>
									    				</td>
									    			</tr>
									    		</tbody>
									    	</table>
								        </md-content>
								      </md-tab>
								    </md-tabs>
								</md-content>
					        </md-content>
					      </md-tab>
					    </md-tabs>
					</md-content>
				</div>

				<div class="panel panel-primary" ng-if="(nivel[0].id == 2 || nivel[0].id == 3) && infoPerNivel.tipopersona.id === 3">
	    		  	<div class="panel-heading text-center">Canales y lineas</div>
				    <div class="panel-body">
				    	<div ng-repeat="can in infoPerNivel.canales" class="panel panel-default">
			    		  	<div class="panel-heading text-center">
			    		  		<strong>@{{can.can_txt_descrip}}</strong>
			    		  	</div>
						    <div class="panel-body">
						    	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<div class="form-group">
										<label>Lineas:</label> 
										<multiselect ng-init="" class="span-margin" ng-model="can.lineas" options="can.lineasFiltradas" id-prop="lin_id" display-prop="lin_txt_descrip" placeholder="Seleccione Lineas.." show-search="true" show-select-all="true" show-unselect-all="true" required></multiselect> 	
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Codigo</th>
													<th>Linea</th>
													<th>Acción</th>
												</tr>
											</thead>
											<tbody>
												<tr ng-if="can.lineas.length == 0">
													<td>Favor ingresar al menos un registro</td>
												</tr>
												<tr ng-repeat="(key, value) in can.lineas">
													<td>@{{value.lin_id}}</td>
													<td>@{{value.lin_txt_descrip}}</td>
													<td>
														<button type="button" class="btn btn-danger" ng-click="eliminar(can.lineas, value)"><i class="glyphicon glyphicon-remove"></i></button>
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
		    <div class="modal-footer">
		    	<button type="submit" ng-if="infoPerNivel.id == undefined" class="btn btn-success">Guardar</button>
		    	<button type="submit" ng-if="infoPerNivel.id != undefined"  class="btn btn-success">Actualizar</button>
		    	<button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Cerrar">Cerrar</button>
		    </div>
	   	</form>
  	</div>
	</div>
</div>