@extends('app')

@section('content')
@include('includes.titulo')

<div ng-controller="docEntradaAlmacenCtrl as ctrl" ng-cloak>
	<div>
		<div class="panel panel-default">
			<div class="panel-body">
				<table  datatable="ng">
					<thead>
						<tr>
							<th>Num.</th>
							<th>Fecha</th>
							<th>Tipo de ubicación</th>
							<th>Muelle</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="obj in entradas">               
							<td>@{{obj.entm_int_id}}</td>
							<td>@{{obj.entm_txt_fecha}}</td>
							<td>@{{obj.entm_int_idtipoubicacion}}</td>
							<td>Muelle</td>
							<td class="text-right" style="white-space:nowrap;"> 
								<button class="btn btn-warning btn-sm" ng-click="edit(obj)">
									<i class="glyphicon glyphicon-pencil"></i>
									<md-tooltip md-direction="bottom">
									Actualizar entrada
									</md-tooltip> 
								</button>
								<button class="btn btn-danger btn-sm" ng-click="showConfirm($event, obj)" >
									<i class="glyphicon glyphicon-trash"></i>
									<md-tooltip md-direction="bottom">
									Borrar registro
									</md-tooltip> 
								</button>
							</td>                  
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>
</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/wmsmaterialempaque/validacionCiegoCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush