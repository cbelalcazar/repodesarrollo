
<table border="1">
	<tbody>		
		<tr>
			<td align="center" valign="middle">BELLEZA EXPRESS</td>
			<td colspan="2"></td>
			<td align="center"  valign="middle">COMERCIO EXTERIOR</td>
			<td colspan="4"></td>
			<td>Código:          </td>
			<td></td>
		</tr>

		<tr>
			<td colspan="8"></td>
			<td>Edición:01</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="3"></td>
			<td align="center"  valign="middle">INFORME BIMESTRAL DE IMPORTACIONES</td>
			<td colspan="4"></td>
			<td>Fecha de Emisión:</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="8"></td>
			<td>Pagina: 1 de 1</td>	
			<td></td>
		</tr>
		<tr>
			<td colspan="2">BIMESTRE</td>
			<td>ENE-FEB</td>
			@if($mes == "01" || $mes == "02")
			<td>X</td>
			@else
			<td></td>
			@endif			
			<td>JUL-AGO</td>
			@if($mes == "07" || $mes == "08")
			<td>X</td>
			@else
			<td></td>
			@endif	
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="10"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td>MAR-ABR</td>
			@if($mes == "03" || $mes == "04")
			<td>X</td>
			@else
			<td></td>
			@endif	
			<td>SEPT- OCT</td>
			@if($mes == "09" || $mes == "10")
			<td>X</td>
			@else
			<td></td>
			@endif	
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="10"></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td>MAY-JUN</td>
			@if($mes == "05" || $mes == "06")
			<td>X</td>
			@else
			<td></td>
			@endif	
			<td>NOV-DIC</td>
			@if($mes == "11" || $mes == "12")
			<td>X</td>
			@else
			<td></td>
			@endif	
			<td colspan="4"></td>
		</tr>
		<tr>
			<td colspan="10"></td>
		</tr>

		<tr>
			<td align="center">N° IMPORT</td>
			<td align="center">PROVEEDOR</td>
			<td align="center">VALOR FOB <br> IMPORTACION <br>USD</td>
			<td align="center">N° DECLARACION</td>
			<td align="center">VR. ARANCEL</td>
			<td align="center">VR. IVA <br> (Pesos)</td>
			<td align="center">FECHA LEVANTE</td>
			<td align="center">FECHA LLEGADA BE</td>
			<td align="center">ENTRADA SISTEMA BE</td>
			<td align="center">ESTADO</td>
		</tr>

		@foreach($declaracion as $key => $value)
		<tr>
			<td>{{$value->nacionalizacion['importacion']['imp_consecutivo']}}</td>
			<td>{{$value->nacionalizacion['importacion']['proveedor']->razonSocialTercero}}</td>
			<td>{{$value->nacionalizacion['importacion']['pagosimportacion']->pag_valor_fob}}</td>
			<td>{{$value->decl_numero}}</td>
			<td>{{$value->decl_arancel}}</td>
			<td>{{$value->decl_iva}}</td>
			<td>{{$value->decl_fecha_levante}}</td>
			<td>{{$value->nacionalizacion['naco_fecha_llegada_be']}}</td>
			<td>{{$value->nacionalizacion['naco_fecha_entrada_sistema']}}</td>
			<td>{{$value->nacionalizacion['importacion']['estado']->est_nombre}}</td>
		</tr>
		@endforeach




	</tbody>
</table>

