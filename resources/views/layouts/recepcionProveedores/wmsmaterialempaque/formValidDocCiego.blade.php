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
				<!-- tipoDocumento -->
				<div class="form-group">
					<label>Tipo documento <strong class="text-danger">(*)</strong>:</label>
					<select ng-model="entrada.entm_txt_tipo_documento" class="form-control" ng-options="[opt.f021_id, opt.f021_descripcion].join(' - ') for opt in tiposDocumentos track by opt.f021_id" required>
						<option value="">Seleccione...</option>
					</select>
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
						<th>Orden de compra</th>
						<th>Bodega / Ubicacion</th>
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
							<input ng-change="value.ocACargar = null" type="number"  min="0" ng-change="calcular(value)" ng-model="value.rec_int_cantidad" class="form-control" required>
							<span class="has-error" ng-if="menorACero(value.rec_int_cantidad)"><p><small>Debe ser mayor a cero</small></p></span>  
						</td>
						<td>
							<input type="text" ng-model="value.rec_int_cajas" class="form-control" disabled required>
						</td>
						<td>
							<input type="text" ng-model="value.rec_int_saldo" class="form-control" disabled required>
						</td>
						<td>@{{value.rec_int_estiba}}</td>
						<td ng-if="value.programacion != null">@{{value.programacion.prg_tipo_doc_oc}} - @{{value.programacion.prg_num_orden_compra}}</td>
						<td ng-if="value.programacion == null">

							<button type="button" ng-if="ordenesSoloRefSeleccionada.length == 0" class="btn btn-warning btn-sm" ng-click="agregarOCaReferencia(value)" ><i class="glyphicon glyphicon-plus"></i>
								Agregar
								<md-tooltip md-direction="bottom">
								Agregar orden de compra a referencia
								</md-tooltip> 							
							</button>

							<select class="form-control" required ng-if="ordenesSoloRefSeleccionada.length > 0" ng-model="value.ocACargar" ng-change="validarUnidades(value.rec_int_cantidad, value, this)" ng-options="[realizarTrim(opt.CO), opt.TipoDocto, opt.ConsDocto, 'Cantidad: ' + redondea(opt.CantPendiente), formatoFecha(opt.f421_fecha_entrega)].join('-') for opt in ordenesSoloRefSeleccionada track by [opt.CO, opt.TipoDocto, opt.ConsDocto].join('-')">
								<option value="">Seleccione..</option>
							</select>
						</td>
						<td>
							<select class="form-control" ng-model="value.bodega" required ng-options="opt for (key, opt) in bodegasSolas track by opt" required>
								<option value="">Seleccione..</option>
							</select>
							<select class="form-control" ng-if="value.bodega != undefined" ng-model="value.ubicacion"  ng-options="[opt.id_ubic, opt.nom_ubic].join(' - ') for (key, opt) in bodegasUbica | filter : {id_bodega : value.bodega}  track by opt.id_ubic" required>
								<option value="">Seleccione..</option>
							</select>
						</td>
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
						<th colspan="3">
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
					<textarea class="form-control" ng-model="entrada.entm_txt_observaciones" cols="30" rows="2"></textarea>
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
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcdindocuemnto" value="FACTURA">Factura</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcdindocuemnto" value=" CERTIFICADO DE CALIDAD">Certificado de calidad</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcdindocuemnto" value="REMISION">Remisión</label>
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
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="SIN REFERENCIAS">Sin referencia</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="ERROR EN DESCRIPCION DE PRODUCTOS">Error en descripcion del producto</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="MERCANCIA NO PEDIDA">M/cia no pedida</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="ORDEN DE COMPRA">Orden de compra</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="DIFERENCIA EN MONEDAS">Diferencia en moneda</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nincofactura" value="DIFERENCIA EN PRECIOS">Diferencia en precios</label>
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
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcmalrotulada" value="REFERENCIAS">Referencias</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcmalrotulada" value="DESCRIPCION">Descripción</label>
						</div>
					</td>
					<td>
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_nmcmalrotulada" value="CANTIDADES">Cantidades</label>
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
						  <label><input type="radio" ng-model="entrada.entm_txt_ndiferenciaunidad" value="SOBRANTE">Sobrante</label>
						</div>
					</td>
					<td colspan="2">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_ndiferenciaunidad" value="FALTANTE">Faltante</label>
						</div>
					</td>
				</tr>
				<!-- End Mercancia mal rotulada -->		
				<!-- Mercancia averias -->
				<tr>
					<td>05</td>
					<td colspan="4">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_naverias" value="Si">AVERIAS</label>
						</div>
					</td>
				</tr>
				<!-- End averias -->	
				<!-- Otros -->
				<tr>
					<td>06</td>
					<td colspan="4">
						<div class="radio">
						  <label><input type="radio" ng-model="entrada.entm_txt_notros" value="Si">OTROS</label>
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
			<!-- <div class="btn-group">
				<button class="btn btn-danger">Rechazar</button>
			</div> -->
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