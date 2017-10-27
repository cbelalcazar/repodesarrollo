@extends('app')
@section('content')
@include('includes.titulo')
<style media="screen">
  md-select {

    margin-top:  5px !important;
  }
</style>
<div ng-controller='misSolitudesCtrl as ctrl' ng-cloak class="container-fluid">

	<md-content>

	    <md-tabs md-dynamic-height md-border-bottom>

	      <md-tab label="Todas (@{{todas.length}})">
	        <md-content class="md-padding">

	          <table datatable="ng" class="row-border hover">
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
	          			<td>Duplicar</td>
	          			<td>Ver</td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="toda in todas">
	          			<td>@{{toda.sci_id}}</td>
	          			<td>@{{toda.estado.soe_descripcion}}</td>
	          			<td>@{{toda.sci_fecha}}</td>
	          			<td>@{{toda.sci_facturara}}</td>
	          			<td>@{{toda.sci_tsd_id}}</td>
	          			<td>@{{toda.sci_tipopersona}}</td>
	          			<td>@{{toda.sci_cargara}}</td>
	          			<td>@{{toda.sci_observaciones}}</td>
	          			<td>DUPLICAR</td>
	          			<td>BOTON</td>
	          		</tr>
	          	</tbody>
	          </table>

	        </md-content>
	      </md-tab>

	      <md-tab label="En elaboracion (@{{elaboracion.length}})">
	        <md-content class="md-padding">
	           <table datatable="ng" class="row-border hover">
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
	          			<td>Duplicar</td>
	          			<td>Ver</td>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="elabora in elaboracion">
	          			<td>@{{elabora.sci_id}}</td>
	          			<td></td>
	          			<td></td>
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
	        </md-content>
	      </md-tab>

	      <md-tab label="Correcciones (@{{correcciones.length}})">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Anulada (@{{anulada.length}})">
	        <md-content class="md-padding ()">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Solicitud (@{{solicitud.length}})">
	        <md-content class="md-padding ()">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="En aprobacion (@{{aprobacion.length}})">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Cerrada (@{{cerrada.length}})">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Pendiente por duplicar">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	    </md-tabs>
	  </md-content>
</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/misSolitudesCtrl.js')}}"></script>
@endpush
