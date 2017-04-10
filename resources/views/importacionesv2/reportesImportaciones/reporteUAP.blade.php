
<table border="1">
	<thead>
		<tr>
			<th colspan="12" align="center">INFORME DE IMPORTACION PRESENTADAS PARA PAGO UAP</th>			
		</tr>
	</thead>
	<tbody>		
		<tr>
			<td colspan="12" align="center">BELLEZA EXPRESS S.A.</td>
		</tr>
		<tr>
			<td align="center" colspan="2">Mes: </td>
			<td align="center">Enero/2017</td>
			<td colspan="9"></td>
		</tr>
		<tr>
			<td align="center" colspan="2">Semana: </td>
			<td align="center">01-09 Enero</td>
			<td colspan="9"></td>
		</tr>
		<tr>
			<td align="center" colspan="2">FECHA DE PRESENTACION</td>
			<td align="center">FECHA DE LEVANTE</td>
			<td align="center">DECLARACION No.</td>
			<td align="center">VR. ARANCEL</td>
			<td align="center">VR. IVA</td>
			<td align="center">VR. OTROS</td>
			<td align="center">TOTAL</td>
			<td align="center">TIPO DE NACIONALIZACION</td>
			<td align="center">ADMINISTRACION</td>
			<td align="center">IMP. No</td>
			<td align="center" colspan="2">PROVEEDOR</td>
		</tr>

		@foreach($groupDeclaraciones as $llave => $declaracion)
		@foreach($declaracion as $key => $value)
		<tr>
			<td colspan="2">{{$value->decl_fecha_aceptacion}}</td>
			<td>{{$value->decl_fecha_levante}}</td>
			<td>{{$value->decl_numero}}</td>
			<td>{{$value->decl_arancel}}</td>
			<td>{{$value->decl_iva}}</td>
			<td>{{$value->decl_valor_otros}}</td>
			<td>{{$value->decl_arancel + $value->decl_iva + $value->decl_valor_otros}}</td>
			<td>{{$value->nacionalizacion['tiponacionalizacion']['tnac_descripcion']}}</td>
			<td>{{$value->admindianDeclaracion['descripcion']}}</td>
			<td>{{$value->nacionalizacion['importacion']['imp_consecutivo']}}</td>
			<td colspan="2">{{$value->nacionalizacion['importacion']['proveedor']->razonSocialTercero}}</td>
		</tr>	
		@endforeach
		<td colspan="4" align="center">TOTAL</td>
		<td>{{$arancelesTotal[$llave]}}</td>
		<td>{{$ivaTotal[$llave]}}</td>
		<td>{{$otrosTotal[$llave]}}</td>
		<td>{{$totalArray[$llave]}}</td>
		<td colspan="5"></td>
		<tr><td colspan="12"></td></tr>
		@endforeach

		<tr>
			<td colspan="4">TOTAL MANUALES</td>
			<td>{{$manualesArancel}}</td>
			<td>{{$manualesIva}}</td>
			<td>{{$manualesOtros}}</td>
			<td>{{$manualesTotal}}</td>
		</tr>
		<tr>
			<td colspan="4">TOTAL AUTOMATICAS</td>
			<td>{{$automaticasArancel}}</td>
			<td>{{$automaticasIva}}</td>
			<td>{{$automaticasOtros}}</td>
			<td>{{$automaticasTotal}}</td>
		</tr>
		<tr>
			<td colspan="4">TOTAL</td>
			<td>{{$sumatodasArancel}}</td>
			<td>{{$sumatodasIva}}</td>
			<td>{{$sumatodasOtros}}</td>
			<td>{{$sumatodasTotal}}</td>
		</tr>
		

	</tbody>
</table>

