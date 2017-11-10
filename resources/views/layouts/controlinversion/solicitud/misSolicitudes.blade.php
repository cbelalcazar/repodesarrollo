@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller='misSolitudesCtrl as ctrl' ng-cloak class="container-fluid">

	<md-content>

	    <md-tabs md-dynamic-height md-border-bottom>

	      <md-tab label="Todas (@{{todas.length}})">
	        <md-content class="md-padding">

	          <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="toda in todas">
	          			<td>@{{toda.sci_id}}</td>
	          			<td>@{{toda.estado.soe_descripcion}}</td>
	          			<td>@{{toda.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{toda.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{toda.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{toda.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{toda.cargara.cga_descripcion}}</td>
	          			<td>@{{toda.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(toda)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>

	        </md-content>
	      </md-tab>

	      <md-tab label="En elaboracion (@{{elaboracion.length}})">
	        <md-content class="md-padding">
	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs1" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          			<td></td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="elabora in elaboracion">
	          			<td>@{{elabora.sci_id}}</td>
	          			<td>@{{elabora.estado.soe_descripcion}}</td>
	          			<td>@{{elabora.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{elabora.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{elabora.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{elabora.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{elabora.cargara.cga_descripcion}}</td>
	          			<td>@{{elabora.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(elabora)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          			<td><button class="btn btn-success" ng-click="terminarSolicitud(elabora)" type="button"><i class="glyphicon glyphicon-check"></i></button></td>
	          			<td><button class="btn btn-danger" ng-click="anularSolicitud(elabora)" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	        </md-content>
	      </md-tab>

	      <md-tab label="Correcciones (@{{correcciones.length}})">
	        <md-content class="md-padding">
	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs1" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          			<td></td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="corre in correcciones">
	          			<td>@{{corre.sci_id}}</td>
	          			<td>@{{corre.estado.soe_descripcion}}</td>
	          			<td>@{{corre.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{corre.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{corre.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{corre.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{corre.cargara.cga_descripcion}}</td>
	          			<td>@{{corre.sci_observaciones}}</td>
									<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(corre)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          			<td><button class="btn btn-warning" ng-click="corregirSolicitud(corre)" type="button"><i class="glyphicon glyphicon-edit"></i></button></td>
	          			<td><button class="btn btn-danger" ng-click="anularSolicitud(corre)" type="button"><i class="glyphicon glyphicon-remove"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	        </md-content>
	      </md-tab>

	      <md-tab label="Anulada (@{{anulada.length}})">
	        <md-content class="md-padding ()">
	         <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="anul in anulada">
	          			<td>@{{anul.sci_id}}</td>
	          			<td>@{{anul.estado.soe_descripcion}}</td>
	          			<td>@{{anul.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{anul.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{anul.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{anul.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{anul.cargara.cga_descripcion}}</td>
	          			<td>@{{anul.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(anul)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	      </md-tab>

	      <md-tab label="Solicitud (@{{solicitud.length}})">
	        <md-content class="md-padding ()">
	         <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="solic in solicitud">
	          			<td>@{{solic.sci_id}}</td>
	          			<td>@{{solic.estado.soe_descripcion}}</td>
	          			<td>@{{solic.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{solic.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{solic.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{solic.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{solic.cargara.cga_descripcion}}</td>
	          			<td>@{{solic.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(solic)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	        </md-content>
	      </md-tab>

	      <md-tab label="En aprobacion (@{{aprobacion.length}})">
	        <md-content class="md-padding">
	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="aprob in aprobacion">
	          			<td>@{{aprob.sci_id}}</td>
	          			<td>@{{aprob.estado.soe_descripcion}}</td>
	          			<td>@{{aprob.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{aprob.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{aprob.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{aprob.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{aprob.cargara.cga_descripcion}}</td>
	          			<td>@{{aprob.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(aprob)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	      </md-tab>

	      <md-tab label="Cerrada (@{{cerrada.length}})">
	        <md-content class="md-padding">
	          <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<td>No</td>
	          			<td>Estado</td>
	          			<td>Fecha</td>
	          			<td>Facturar A</td>
	          			<td>Tipo de salida</td>
	          			<td>Tipo de persona</td>
	          			<td>Cargar a</td>
	          			<td>Observaciones</td>
	          			<td></td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="cerr in cerrada">
	          			<td>@{{cerr.sci_id}}</td>
	          			<td>@{{cerr.estado.soe_descripcion}}</td>
	          			<td>@{{cerr.sci_fecha | date: 'dd/MM/yyyy'}}</td>
	          			<td>@{{cerr.facturara.tercero.razonSocialTercero}}</td>
	          			<td>@{{cerr.tipo_salida.tsd_descripcion}}</td>
	          			<td>@{{cerr.tipo_persona.tpe_tipopersona}}</td>
	          			<td>@{{cerr.cargara.cga_descripcion}}</td>
	          			<td>@{{cerr.sci_observaciones}}</td>
	          			<td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(cerr)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
	          		</tr>
	          	</tbody>
	          </table>
	      </md-tab>


	    </md-tabs>
	  </md-content>

			 @include('layouts.controlinversion.reportesVisuales.mostrarSolicitud')

     	<div ng-if="progress" class="progress">
	    	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
		</div>
</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/misSolitudesCtrl.js')}}"></script>
@endpush
