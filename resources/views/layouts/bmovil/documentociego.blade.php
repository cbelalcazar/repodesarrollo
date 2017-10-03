@extends('app')

@section('content')
<style>
	body{
		font-size:10px;
	}
	td{
		padding: 1px !important;
	}
	th{
		padding: 2px !important;
	}
	.pagination {
	    margin: 7px 0;
	}
	.btn-xs {
	    border-radius: 16px;
	    font-size: 10px;
	    padding: 0px 3px
	}
	.pagination>li>a{
	    padding: 4px 9px;
	}
	.wrap {
	    padding: 5px 0 0;
	}
	h6{
		margin-bottom: 3px;
	}
</style>
<div class="container"  ng-controller="indexciego as ctrl" ng-cloak>
	<h6><strong>DOCUMENTO EN CIEGO CITA</strong></h6>
	<div class="table-responsive">
		<table class="table-striped" border="1">
			<thead>
				<tr>
					<th colspan="4"><button  align="center" class="btn-xs btn-primary">Proveedor sin cita </button> <button class="btn-xs btn-warning pull-right"> <span class="glyphicon glyphicon glyphicon glyphicon-home"></span></button></th>
				</tr>	
				<tr>
					<th>CITA</th>
					<th>FECHA</th>
					<th>PROV.</th>
					<th>CUMP</th>
				</tr>			
			</thead>
			<tbody>
				<tr dir-paginate="cita in citas | itemsPerPage: 3">
					<td>@{{cita.id}}</td>
					<td>@{{cita.cit_fechainicio}}</td>
					<td>@{{cita.cit_nombreproveedor}}</td>
					<td align="center"><button ng-click="recibir(cita)" class="btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></button></td>
				</tr>
			</tbody>
		</table>		
		<dir-pagination-controls max-size="2"></dir-pagination-controls>
	</div>
	<div ng-if="progress" class="progress">
		<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div>	
		
</div>

@endsection


@push('script_angularjs')
<script src="{{url('/js/bmovil/documentociego.js')}}" type="text/javascript" language="javascript"></script>
@endpush