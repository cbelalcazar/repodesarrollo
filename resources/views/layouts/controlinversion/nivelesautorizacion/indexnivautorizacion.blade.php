@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller="nivelesautorizacionCtrl as ctrl" ng-cloak class="container-fluid">
		
	<md-content>
	<button class="btn-sm btn-success" data-toggle="modal" data-target="#modal">Agregar&nbsp;<i class="glyphicon glyphicon-plus"></i></button>
		<md-tabs md-dynamic-height md-border-bottom>
			<md-tab label="Nivel 4">
				<md-content class="md-padding">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Usuario</th>
								<th>Nombre</th>
								<th>No. identificacion</th>
								<th>Zona</th>
								<th>Canal</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>vacio</td>
								<td>vacio</td>
								<td>vacio</td>
								<td>vacio</td>
								<td>vacio</td>
								<td>vacio</td>
							</tr>
						</tbody>
					</table>
				</md-content>
			</md-tab>
			<md-tab label="Nivel 3">
				<md-content class="md-padding">
					<h1 class="md-display-2">Tab Two</h1>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
					<p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
					<p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
				</md-content>
			</md-tab>
			<md-tab label="Nivel 2">
				<md-content class="md-padding">
					<h1 class="md-display-2">Tab Three</h1>
					<p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
				</md-content>
			</md-tab>
				<md-tab label="Nivel 1">
				<md-content class="md-padding">
					<h1 class="md-display-2">Tab Three</h1>
					<p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
				</md-content>
			</md-tab>
		</md-tabs>
	</md-content>
	@include('layouts.controlinversion.nivelesautorizacion.modalcreatepersona')
	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>
@endsection


@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/nivelesautorizacionCtrl.js')}}"></script>
@endpush
