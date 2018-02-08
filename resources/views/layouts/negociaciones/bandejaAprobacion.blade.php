@extends('app')
@section('content')
@include('includes.titulo')
<div ng-controller='bandejaCtrl' ng-cloak class="container-fluid">
<table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
	<thead>
		<tr>
		  	<th align="center" width="8%">No. Sol</th>
            <th align="center" width="20%">Solicitante</th>
            <th align="center" width="12%">Fecha de Solicitud</th>
            <th align="center" width="20%">Cliente</th>
            <th align="center" width="3%">Aprobar</th>
            <th align="center" width="3%">Ver</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="obj in solicitudes">
			<td>@{{obj.sol_id}}</td>
			<td>@{{obj.vendedor.razonSocialTercero}}</td>
			<td>@{{obj.sol_fecha}}</td>
			<td>@{{obj.cliente.razonSocialTercero_cli}}</td>
			<td>
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal1" ng-click="aprobar(obj)">
					<i class="glyphicon glyphicon-ok"></i>
					<md-tooltip>aprobar 
				</button>
			</td>
			<td class="text-right">
				<button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(obj)">
					<i class="glyphicon glyphicon-eye-open"></i>
					<md-tooltip>Ver 
				</button>
			</td>
		</tr>
	</tbody>
</table>

	@include('layouts.negociaciones.misSolicitudesDetalle')
	@include('layouts.negociaciones.modTipoSolicitud')

    <div ng-if="progress" class="progress">
	    <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/negociaciones/bandejaAprobacionCtrl.js')}}"></script>
@endpush
