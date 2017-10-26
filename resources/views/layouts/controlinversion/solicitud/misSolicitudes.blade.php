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

	      <md-tab label="Todas ()">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab One</h1>

	          <table datatable="" class="row-border hover">
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
	          		<tr>
	          			<td></td>
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

	      <md-tab label="En elaboracion ()">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Two</h1>
	          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
	          <p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Correcciones ()">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Anulada">
	        <md-content class="md-padding ()">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Solicitud">
	        <md-content class="md-padding ()">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="En aprobacion ()">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Cerrada ()">
	        <md-content class="md-padding">
	          <h1 class="md-display-2">Tab Three</h1>
	          <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
	        </md-content>
	      </md-tab>

	      <md-tab label="Pendiente por duplicar ()">
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
