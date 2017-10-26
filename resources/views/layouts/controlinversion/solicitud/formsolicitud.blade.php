@extends('app')
@section('content')
@include('includes.titulo')
<style media="screen">
  md-select {

    margin-top:  5px !important;
  }
</style>
<div ng-controller='solicitudCtrl as ctrl' ng-cloak class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
        	Datos de la Solicitud
        </div>
        <form ng-submit="$event.preventDefault()">
	        <div class="panel-body">
	        	<div class="row">
			        <div class="form-group col-md-2">
			            <label>Fecha: </label>
			            <input class="form-control" type="text" ng-model="solicitud.fecha" disabled></input>
			        </div>
			    </div>
			    <!-- Campo Facturar A -->
		        <div class="form-group">
		            <label>Facturar a: </label>
					<md-autocomplete
					          ng-disabled="hab_ac_facturara"
					          md-selected-item="objeto.selectedItem"
							      md-search-text="buscar_ac_facturara"
					          md-no-cache="true"
							      md-item-text="item.tercero.razonSocialTercero"
					          md-items="item in qs_facturara(buscar_ac_facturara)"
					          md-min-length="1"
					          placeholder="Ingrese el número documento de identidad o el nombre de la persona a la cual se le facturará">
					        <md-item-template>
					          <span md-highlight-text="buscar_ac_facturara" md-highlight-flags="^i">@{{item.fca_idTercero}} - @{{item.tercero.razonSocialTercero}}</span>
					        </md-item-template>
					        <md-not-found>
					          No states matching "@{{buscar_ac_facturara}}" were found.
					        </md-not-found>
					</md-autocomplete>
		        </div>
		        <!-- Campo Tipo de Salida y Motivo de Salida -->
				<div class="row">
			        <div class="form-group col-md-6">
			            <label>Tipo de Salida: </label>
			            <select class='form-control' ng-model='solicitud.tiposalida1' ng-options='opt.tsd_descripcion for opt in tiposalida track by opt.tsd_codigo'>
			            	<option value=''>Seleccione...</option>
			            </select>
			            <!-- @{{solicitud.tiposalida1}} -->
			        </div>
			        <div class="form-group col-md-6">
			            <label>Motivo de Salida: </label>
			            <select class='form-control' ng-model='solicitud.motivoSalida' ng-options='opt.descripcion for opt in motivoSalida track by opt.id'>
			            	<option value=''>Seleccione...</option>
			            </select>
			            <!-- @{{solicitud.tiposalida1}} -->
			        </div>
				</div>
				<!-- Campo Cargar Gastos A y Linea -->
		        <div class="row">
			        <div class="form-group col-md-6">
			            <label>Cargar Gastos a: </label>
			            <select class='form-control' ng-model='solicitud.cargagasto1' ng-options='opt2.cga_descripcion for opt2 in cargagasto track by opt2.cga_id'>
			            	<option value=''>Seleccione...</option>
			            </select>
			            <!-- @{{solicitud.tipopersona1}} -->
			        </div>

			        <div class="form-group col-md-6" ng-if="solicitud.cargagasto1.cga_descripcion == 'Linea'">
			            <label>Línea: </label>
			            <select class='form-control' ng-model='solicitud.lineas1' ng-options='opt3.lineas_producto.NomLinea for opt3 in lineasproducto track by opt3.lineas_producto.CodLinea'>
			            	<option value=''>Seleccione...</option>
			            </select>
			            <!-- @{{solicitud.tipopersona1}} -->
			        </div>
		        </div>
		        <!-- Campo Observaciones -->
		        <div class="form-group">
		            <label>Observaciones: </label>
		            <textarea class="form-control" ng-model="solicitud.observaciones" cols="50" rows="3"></textarea>
		        </div>
		        <!-- Campo Tipo Persona -->

				    <div class="row">

		               <div class="form-group col-md-6">
      			            <label>Tipo de Persona: </label>
      			            <select class='form-control' ng-model='solicitud.tipopersona1' ng-change="filtrapersona()" ng-options='opt1.tpe_tipopersona for opt1 in tipopersona track by opt1.tpe_id'>
      			            	<option value=''>Seleccione...</option>
      			            </select>
			             </div>

                   <div ng-if="esVendedor" class="form-group col-md-6">

                        <label>Zonas: </label>
                        <md-select ng-model="solicitud.zonasSelected"
                                   aria-label="zonas de vendedores"
                                   data-md-container-class="selectdemoSelectHeader"
                                   multiple>
                          <md-optgroup label="zonas">
                            <md-option ng-value="zona" ng-repeat="zona in zonas">@{{zona.descripcion}}</md-option>
                          </md-optgroup>
                        </md-select>

                   </div>

		        </div>


				<div class="row">
		            <div class="form-group col-md-12" ng-if="solicitud.tipopersona1.tpe_tipopersona != undefined">
			            <label>Despachar a: </label>
					    <md-chips ng-model="selectedColaboradores" md-autocomplete-snap
					              md-transform-chip="transformChip($chip)"
					              md-require-match="autocompleteDemoRequireMatch">
					    	<md-autocomplete
					        	  md-selected-item="selectedItem"
					          	md-search-text="colaboradorText"
					          	md-items="item in onSearchQueryChange(colaboradorText) | map: filtrarVendedorZona | remove: undefined"
					          	md-item-text="[item.nitVendedor, item.nombreVendedor].join(' - ')"
                      md-min-length="1"
                      md-no-cache="true"
					          	placeholder="Buscar un/a colaborador/a...">
					        	<span md-highlight-text="searchText">@{{[item.nitVendedor, item.nombreVendedor].join(' - ')}}</span>
					      	</md-autocomplete>
					    	<md-chip-template>
					    		<span>
					    			@{{[$chip.nitVendedor, $chip.nombreVendedor].join(' - ')}}
					    		</span>
					      	</md-chip-template>
					    </md-chips>
			        </div>
		        </div>
		        <!-- Tabla - Referencias Sugeridas -->
			    <div class="panel panel-primary" ng-if="selectedColaboradores.length > 0">
			        <div class="panel-heading" align="center">
			        	Referencias Sugeridas
			        </div>
			        <div class="panel-body">

                <div class="row">
					        <div class="form-group col-md-12">
                      <label style="display:inline-block;">Cargar Referencias:</label>&nbsp
                      <div class="input-group" style="display:inline-block;">
                        <!-- Esta es la directiva nueva marcillo, ya funciona carga cada fila del excel en un objeto en el controlador de angular -->
                        <js-xls onread="read" onerror="error"></js-xls>
                        <label for="file"><i class="glyphicon glyphicon-cloud-upload"></i> Subir Archivo</label>
                        <!-- end directiva excel -->
                      </div>
                  </div>
                </div>


				        <div class="row">
					        <div class="form-group col-md-12">
					        	<label>Referencia:</label>
					        	<div class="input-group">
					        		<md-autocomplete
								          md-selected-item = "objeto.referenciaGeneral"
										      md-search-text = "searchReferencia"
								          md-no-cache = "true"
								          md-items = "item in qs_referencia(searchReferencia)"
                          md-item-text = "[item.referenciaCodigo,item.referenciaDescripcion].join(' - ')"
								          md-min-length = "1"
								          placeholder = "Digite la referencia">
								        <md-item-template>
								          <span md-highlight-text="searchReferencia" md-highlight-flags="^i">@{{[item.referenciaCodigo,item.referenciaDescripcion].join(" - ")}}</span>
								        </md-item-template>
								        <md-not-found>
								          No states matching "@{{searchReferencia}}" were found.
								        </md-not-found>
									</md-autocomplete>
								    <div class="input-group-btn">

								      <button ng-disabled="!(objeto.referenciaGeneral != '' &&  objeto.referenciaGeneral != undefined)" class="btn btn-success" type="button" ng-click="agregarReferenciaTodos(referenciaGeneral)">
								        <i class="glyphicon glyphicon-plus"></i>
								      </button>

								    </div>
								  </div>
					        </div>
				        </div>
			        </div>
			    </div>
          <!--Tabla de resumen de detalles por Destinatario-->
          <div class="panel panel-primary" ng-if="selectedColaboradores.length > 0">
              <div class="panel-heading" align="center">
                Resumen de detalle por persona
              </div>
              <div class="panel-body">

                <div class="row">
                  <div class="form-group col-md-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>Despachar a</th>
                              <th>Zona</th>
                              <th>Cantidad Referencias</th>
                              <th>Cantidad Solicitada</th>
                              <th>Valor</th>
                              <th>Mostrar Referencias</th>
                              <th>Acción</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="7">No hay personas agregadas por ahora</td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>

		        <!-- Tabla - Detalle por Destinatario -->
		        <div class="table-responsive" ng-repeat="persona in selectedColaboradores">
		        	<table class="table">
		        		<thead>
		        			<tr>
		        				<th colspan="7">@{{[persona.nitVendedor, persona.nombreVendedor].join(' - ')}}</th>
		        			</tr>
		        			<tr>
		        				<td colspan="4">
                        <md-autocomplete
                            md-selected-item = "persona.referenciaSearchItem"
                            md-search-text = "searchReferencia"
                            md-no-cache = "true"
                            md-items = "item in qs_referencia(searchReferencia)"
                            md-item-text = "[item.referenciaCodigo,item.referenciaDescripcion].join(' - ')"
                            md-min-length = "1"
                            placeholder = "Digite la referencia">
                            <md-item-template>
                              <span md-highlight-text="searchReferencia" md-highlight-flags="^i">@{{[item.referenciaCodigo,item.referenciaDescripcion].join(" - ")}}</span>
                            </md-item-template>
                            <md-not-found>
                              No states matching "@{{searchReferencia}}" were found.
                            </md-not-found>
                        </md-autocomplete>
		        				</td>
		        				<td>
		        					<button ng-disabled="!(persona.referenciaSearchItem != '' &&  persona.referenciaSearchItem != undefined)" class="btn btn-success" type="button" ng-click="agregarReferenciaVendedor(persona, $event)"><span class="glyphicon glyphicon-plus"></span></button>
		        				</td>
		        			</tr>
		        			<tr>
		        				<th>Referencia</th>
		        				<th>Estado</th>
		        				<th>Costo</th>
		        				<th>Cantidad</th>
		        				<th>linea</th>
		        				<th>Valor total</th>
		        				<th>Acción</th>
		        			</tr>
		        		</thead>
		                <tbody>
		                  <tr ng-if="persona.referencias == undefined"><td style="text-align:center;" colspan="7">No hay referencias para esta persona</td></tr>
		                  <tr ng-repeat="referencia in persona.referencias">
		                    <td>@{{[referencia.referenciaCodigo,referencia.referenciaDescripcion].join(" - ")}}</td>
		                    <td>@{{referencia.referenciaEstado}}</td>
		                    <td>@{{referencia.referenciaPrecio | currency: "$" : 2}}</td>
		                    <td style="width: 76px;">
		                    	<input class="form-control inputCantMinimized inputCantMinimized-success" type="number" ng-model="referencia.referenciaCantidad" ng-change="onCantidadChange(referencia)" min="0"/>
		                    </td>
		                    <td>@{{referencia.referenciaLinea}}</td>
		                    <td>@{{referencia.referenciaValorTotal  | currency: "$" : 2}}</td>
		                    <td>
			                    <button type="button" class="btn btn-danger">
			                    	<i class="glyphicon glyphicon-remove"></i>
			                    </buttom>
		                    </td>
		                  </tr>
		                </tbody>
		        	</table>
		        </div>
	        </div>
        </form>
    </div>
    <div ng-if="progress" class="progress">
    	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>

</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/solicitudCtrl.js')}}"></script>
@endpush
