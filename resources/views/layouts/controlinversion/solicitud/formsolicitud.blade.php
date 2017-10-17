@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller='solicitudCtrl as ctrl' ng-cloak class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
        	Datos de la Solicitud
        </div>
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
				          md-min-length="0"
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
		            <select class='form-control' ng-model='solicitud.tiposalida1' ng-options='opt.tsd_descripcion for opt in tiposalida track by opt.tsd_codigo'>
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
		            <select class='form-control' ng-model='solicitud.tipopersona1' ng-change='filtrapersona()' ng-options='opt1.tpe_tipopersona for opt1 in tipopersona track by opt1.tpe_id'>
		            	<option value=''>Seleccione...</option>
		            </select>
		            <!-- @{{solicitud.tipopersona1}} -->
		        </div> 
	        </div> 
	        <!-- Campo Despachar A -->
			<div class="row">
	            <div class="form-group col-md-12" ng-if="solicitud.tipopersona1.tpe_tipopersona == 'Colaborador'">
		            <label>Despachar a: </label>
				    <md-chips ng-model="selectedColaboradores" md-autocomplete-snap
				              md-transform-chip="transformChip($chip)"
				              md-require-match="autocompleteDemoRequireMatch">
				    	<md-autocomplete
				        	md-selected-item="selectedItem"
				          	md-search-text="searchText"
				          	md-items="item in querySearchPersona(searchText)"
				          	md-item-text="item.razonSocialTercero"
				          	placeholder="Buscar un/a colaborador/a...">
				        	<span md-highlight-text="ctrl.searchText">@{{item.razonSocialTercero}}</span>
				      	</md-autocomplete>
				    	<md-chip-template>
				    		<span>
				    			@{{$chip.razonSocialTercero}}
				    		</span>
				      	</md-chip-template>
				    </md-chips>					
		        </div> 		        
	        </div> 	        
	        <!-- Tabla - Referencias Sugeridas -->	
		    <div class="panel panel-primary">
		        <div class="panel-heading" align="center">
		        	Referencias Sugeridas
		        </div>
		        <div class="panel-body">
			        <div class="row">
				        <div class="form-group col-md-3">
				            <label>Referencia: </label>
							<md-autocomplete
							          ng-disabled="habautcomplete"
							          md-selected-item="objeto.selectedItem"
									  md-search-text="searchReferencia"
							          md-no-cache="true"
									  md-item-text="item.ite_descripcion"
							          md-items="item in qs_referencia(searchReferencia)"
							          md-min-length="0"
							          placeholder="Digite la referencia">
							        <md-item-template>
							          <span md-highlight-text="searchReferencia" md-highlight-flags="^i">@{{item.ite_referencia}} - @{{item.ite_descripcion}}</span>
							        </md-item-template>
							        <md-not-found>
							          No states matching "@{{searchReferencia}}" were found.
							        </md-not-found>
							</md-autocomplete>
				        </div>
				        <div class="form-group col-md-9">
				        	<label>Descripcion:</label>
				        	<div class="input-group">
				        		<input class="form-control" type="text" ng-model="solicitud.descrefsug" disabled></input>
							    <div class="input-group-btn">
							      <button class="btn btn-success" type="submit">
							        <i class="glyphicon glyphicon-plus"></i>
							      </button>
							    </div>
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
	        				<th colspan="7">@{{persona.razonSocialTercero}}</th>
	        			</tr>
	        			<tr>
	        				<td>
	        					<input type="text" class="form-control">
	        				</td>
	        				<td colspan="5">
	        					<input type="text" disabled class="form-control">
	        				</td>
	        				<td>
	        					<button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button>
	        				</td>
	        			</tr>
	        			<tr>
	        				<th>Referencia</th>
	        				<th>Estado</th>
	        				<th>Costo</th>
	        				<th>Cantidad</th>
	        				<th>lineas</th>
	        				<th>Valor total</th>
	        				<th>Acción</th>
	        			</tr>
	        		</thead>
	        	</table>
	        </div>        
        </div>
    </div>
</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/solicitudCtrl.js')}}"></script>
@endpush
