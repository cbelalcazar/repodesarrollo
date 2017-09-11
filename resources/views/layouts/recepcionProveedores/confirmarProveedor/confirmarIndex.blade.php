@extends('app')

@section('content')

@include('includes.titulo')
<style>
	hr {
		margin-top: 3px;
    	margin-bottom: 3px;
	}
	.dataTables_wrapper {
    	padding: 0rem 0;
	}
</style>
<div ng-controller="confirmProveedorCtrl as ctrl" class="row" ng-cloak>
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#citas">Solicitar citas</a></li>
			<li><a data-toggle="tab" href="#programaciones">Confirmar programaciones</a></li>
		</ul>

		<div class="tab-content col-md-6">
			<div id="citas" class="tab-pane fade in active">
				<h3>Solicitar citas</h3>
				<hr>
				<!-- table -->
				<table datatable="ng" dt-instance="dtInstance1" dt-options="dtOptions1" dt-column-defs="dtColumnDefs1" class="row-border hover" >
                    <thead>
                      <tr>
                        <th>Orden</th>
                        <th>Referencia</th>
                        <th>Fecha entrega</th>
                        <th>Cant. solicitada</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat="prog in noProgramables">
                       	<td>@{{prog['prg_tipo_doc_oc']}} - @{{prog['prg_num_orden_compra']}}</td>
                       	<td>@{{prog['prg_referencia']}} - @{{prog['prg_desc_referencia']}}</td>
                       	<td>@{{prog['prg_fecha_programada']}}</td>
                       	<td>@{{prog['prg_cant_programada']}}</td>
                      </tr>
                    </tbody>
                </table>
				<hr>
				<!-- endtable -->
			</div>
			<div id="programaciones" class="tab-pane fade">
				<h3>Confirmar programaciones</h3>
				<p>Some content in menu 1.</p>
			</div>
		</div>
	</div>

<div ng-if="progress" class="progress">
	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
</div>
</div>

@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/confirmarProveedor/confirmarProveedorCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush