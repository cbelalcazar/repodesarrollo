@extends('app')

@section('content')
	@include('includes.titulo')
	<div ng-controller="controller as ctrl" ng-cloak>
		<div class="container-fluid">
			<br>
			<div class="alert alert-success" ng-if="mensajeExito">
			  Registro @{{ accion == 'Actualizar' ? 'actualizado' : 'creado' }} exitosamente
			</div>
			<div class="panel">
				<button type="button"  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="limpiar()">
					Crear Nueva
					<i class="glyphicon glyphicon-plus"></i>
				</button>
				<br><br>
				<table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover" dt-instance="dtInstance">
					<thead>
						<tr>
							<th>Referencia</th>
							<th>Tipo de empaque</th>
							<th>Peso por empaque</th>		
							<th>Acciones</th>					
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="referencia in data.infoReferencias">
							<td>@{{referencia.iref_referencia}} - @{{referencia.referencia.ite_descripcion}}</td>
							<td>@{{referencia.iref_tipoempaque}}</td>
							<td>@{{referencia.iref_pesoporempaque}}</td>
							<td>
								<button class="btn btn-warning" ng-click="actualizar(referencia)" data-toggle="modal" data-target="#modal1"><i class="glyphicon glyphicon-pencil"></i></button>
								<button class="btn btn-danger" ng-click="borrar(referencia)"><i class="glyphicon glyphicon-trash"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@include('layouts.recepcionProveedores.catalogos.formRefProgramables')
		<div ng-if="progress" class="progress">
			<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
		</div>
	</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/catalogos/refProgramablesCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush