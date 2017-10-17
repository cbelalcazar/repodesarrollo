@extends('app')

@section('content')
@include('includes.titulo')

<style>
	.table {
	    width: 99%;
	    max-width: 100%;
	    margin-bottom: 24px;
	    margin-left: 4px;
	}
	.vcenter {
	    display: inline-block;
	    vertical-align: middle;
	    float: none;
	} 
</style>
<div ng-controller="formValidacionCiegoCtrl as ctrl" ng-cloak class="container" ng-init="entm_int_id = {{$info}}; getInfo();">
	<form name="formulario" ng-submit="formulario.$valid ? save() : subir()" novalidate>
		<div class="row">

			<!-- Mensajes de errores -->
			<div  ng-if="mensajes" class="col-sm-12">
				<div class="col-sm-12">
					<div class="alert alert-danger alert-dismissable">                       
						<p>Formulario con errores, favor validar los campos en rojo</p>              
					</div>
				</div>
			</div>
			<!-- End mensajes de errores -->

			<!-- Columna izquierda -->
			<div class="col-md-6">
				<!-- Fecha -->
				<div class="form-group">
					<label>Fecha <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_fecha" class="form-control" disabled required>
				</div>
				<!-- Proveedor -->
				<div class="form-group">
					<label>Proveedor <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_idproveedor" class="form-control" required disabled>
				</div>
				<!-- Factura -->
				<div class="form-group">
					<label>Factura <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_factura" class="form-control" required>
				</div>
				<!-- Funcionario -->
				<div class="form-group">
					<label>Funcionario que entrega <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_funcionarioentrega" class="form-control" required>
				</div>
			</div>
			<!-- End columna izquierda -->
			<!-- Columna derecha -->
			<div class="col-md-6">
				<!-- Vehiculo placa -->
				<div class="form-group">
					<label>Vehiculo placa <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_vehiculoplaca" class="form-control" required>
				</div>
				<!-- Transportadora -->
				<div class="form-group">
					<label>Transportadora <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_transportadora" class="form-control" required>
				</div>
				<!-- Guia -->
				<div class="form-group">
					<label>Guia No <strong class="text-danger">(*)</strong>:</label>
					<input type="text" ng-model="entrada.entm_txt_guia" class="form-control" required>
				</div>
				<!-- Tipo mercancia -->
				<div class="form-group">
					<label>Tipo mercancia <strong class="text-danger">(*)</strong>:</label>
					<select ng-model="entrada.entm_txt_tipomercancia" class="form-control" ng-options="opt for opt in tiposMercancia track by opt" required>
						<option value="">Seleccione...</option>
					</select>
				</div>
			</div>
			<!-- End columna derecha -->
		</div>

		<!-- Tabla Pinta referencias agrupadas -->
		<div class="table-responsive" ng-repeat="(key, obj) in entrada.t_refentrada | groupBy :  'rec_txt_referencia' ">
			<table class="table table-bordered table-condensed"  md-whiteframe="4">
				<thead>
					<tr>
						<th>Referencia</th>
						<th colspan="9">Nombre</th>
					</tr>				
				</thead>
				<tbody>
					<tr>
						<td>@{{key}}</td>
						<td colspan="9">descripcion referencia</td>					
					</tr>
					<tr>
						<th>Lote <strong class="text-danger">(*)</strong>:</th>
						<th>Unidad Empaque <strong class="text-danger">(*)</strong>:</th>
						<th>Total unidades <strong class="text-danger">(*)</strong>:</th>
						<th>Numero cajas <strong class="text-danger">(*)</strong>:</th>
						<th>Saldo <strong class="text-danger">(*)</strong>:</th>
						<th>Estiba</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
					<tr ng-repeat="value in obj">
						<td>
							<input type="text" ng-model="value.rec_txt_lote" class="form-control" required>
						</td>
						<td>
							<input type="number" min="0" ng-change="calcular(value)" ng-model="value.rec_int_undempaque" class="form-control" required>
							<span class="has-error" ng-if="menorACero(value.rec_int_undempaque)"><p><small>Debe ser mayor a cero</small></p></span>  
						</td>
						<td>
							<input type="number"  min="0" ng-change="calcular(value)" ng-model="value.rec_int_cantidad" class="form-control" required>
							<span class="has-error" ng-if="menorACero(value.rec_int_cantidad)"><p><small>Debe ser mayor a cero</small></p></span>  
						</td>
						<td>
							<input type="text" ng-model="value.rec_int_cajas" class="form-control" disabled required>
						</td>
						<td>
							<input type="text" ng-model="value.rec_int_saldo" class="form-control" disabled required>
						</td>
						<td>@{{value.rec_int_estiba}}</td>
						<td>@{{value.rec_int_idestado}}</td>
						<td>
							<button class="btn btn-danger btn-sm" ng-click="showConfirm($event, obj)" >
								<i class="glyphicon glyphicon-trash"></i>
								<md-tooltip md-direction="bottom">
								Borrar registro
								</md-tooltip> 
							</button>
						</td>
					</tr>				
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">Total de la referencia: </th>
						<th colspan="3">Cantidad:  @{{totalReferencia(obj)}}</th>
						<th colspan="2">Novedad: </th>
						<th colspan="3">
							<select class="form-control" ng-model="entrada.novPorReferencia[key]" ng-options="opt for opt in novedad track by opt">
								<option value="">Seleccione</option>
							</select>
						</th>
					</tr>				
				</tfoot>
			</table>
		</div>
		<!-- End tabla referencias -->
		<div class="row">
			<div class="col-md-12">
				<!-- Observaciones -->
				<div class="form-group">
					<label>Observaciones</label>
					<textarea class="form-control" ng-model="entrada.observaciones" cols="30" rows="2"></textarea>
				</div>
			</div>
		</div>
		<!-- Tabla novedades -->
		<table class="table table-bordered"  md-whiteframe="4">
			<thead>
				<tr>
					<th>Codigo</th>
					<th colspan="7">NOVEDADES - MARCA CON UNA X</th>
				</tr>
			</thead>
			<tbody>
				<!-- Mercancia sin documento -->
				<tr>
					<td>01</td>
					<td>M/CIA SIN DOCUMENTO</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercSinDocumento" value="factura">Factura</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercSinDocumento" value="certCalidad">Certificado de calidad</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercSinDocumento" value="remision">Remisión</label>
						</div>
					</td>
				</tr>
				<!-- End mercancia sin documento -->
				<!-- Inconsistencias en facturacion -->
				<tr>
					<td rowspan="2">02</td>
					<td rowspan="2"><div class="vcenter">INCONSISTENCIAS EN FACTURACION</div></td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="sinRef">Sin referencia</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="errDescProduct">Error en descripcion del producto</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="mciaNoPedida">M/cia no pedida</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="ordenCompra">Orden de compra</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="difMoneda">Diferencia en moneda</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.inconEnFacturacion" value="difPrecios">Diferencia en precios</label>
						</div>
					</td>
				</tr>				
				<!-- End inconsistencias en facturacion -->
				<!-- Mercancia mal rotulada -->
				<tr>
					<td>03</td>
					<td>M/CIA MAL ROTULADA</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercMalRotulada" value="referencia">Referencias</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercMalRotulada" value="descripcion">Descripción</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.mercMalRotulada" value="cantidades">Cantidades</label>
						</div>
					</td>
				</tr>
				<!-- End Mercancia mal rotulada -->			
				<!-- Mercancia mal rotulada -->
				<tr>
					<td>04</td>
					<td>DIFERENCIAS EN UNIDADES</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.difUnidades" value="sobrante">Sobrante</label>
						</div>
					</td>
					<td colspan="2">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.difUnidades" value="faltante">Faltante</label>
						</div>
					</td>
				</tr>
				<!-- End Mercancia mal rotulada -->		
				<!-- Mercancia averias -->
				<tr>
					<td>05</td>
					<td colspan="4">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.averias" value="averias">AVERIAS</label>
						</div>
					</td>
				</tr>
				<!-- End averias -->	
				<!-- Otros -->
				<tr>
					<td>06</td>
					<td colspan="4">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.novedades.otros" value="otros">OTROS</label>
						</div>
					</td>
				</tr>
				<!-- End otros -->
			</tbody>
		</table>

		<div class="row">
			<div class="col-md-12">
				<!-- Observaciones -->
				<div class="form-group">
					<label>Los campos marcados con  <strong class="text-danger">(*)</strong> son obligatorios</label>
				</div>
			</div>
		</div>

		<div class="btn-group btn-group-justified">
			<div class="btn-group">
				<button class="btn btn-success" type="submit" ng-disabled="formulario.$invalid">Aprobar</button>
			</div>
			<div class="btn-group">
				<button class="btn btn-danger">Rechazar</button>
			</div>
			<div class="btn-group">
				<button class="btn btn-info">Cancelar</button>
			</div>	
		</div>	
		
		<br>
			
		<div ng-if="progress" class="progress">
			<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
		</div>
	</form>	
</div>

@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/wmsmaterialempaque/formValidacionCiego.js')}}" type="text/javascript" language="javascript"></script>
@endpush