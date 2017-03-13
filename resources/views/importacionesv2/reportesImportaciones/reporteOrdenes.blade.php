
<table border="1">
	<thead>
		<tr>
			@foreach($titulosTabla as $key => $value)
			<th>{{ $value }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		
		@foreach($tabla as $key => $value)
		<tr>
			<!-- Estado -->
			<td>{{ $value[0]->estado->est_nombre }}</td>
			<!-- Consecutivo -->
			<td>{{ $value[0]->imp_consecutivo }}</td>
			<!-- proveedor -->
			<td>{{ $value[0]->proveedor->razonSocialTercero}} - {{ $value[0]->proveedor->nitTercero}}</td>
			<!-- producto -->
			<td>
				<strong>Productos:<br></strong>
				<ul>
					@foreach($value[1] as $key => $value1)
					<li>{{$value1->producto->productoItem->referenciaItem}}-{{$value1->producto->productoItem->descripcionItem}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Proformas -->
			<td>
				<strong>Proformas:<br></strong>
				<ul>
					@foreach($value[2] as $key => $value1)
					<li>{{$value1->prof_numero}}</li>
					@endforeach
				</ul>
			</td>
			<!-- valor proforma -->
			<td>{{ $value[2][0]->prof_valor_proforma }}</td>
			<!-- Factura no -->
			<td></td>
			<!-- Valor fob -->
			<td>{{ $value[0]->pagosimportacion['pag_valor_fob'] }}</td>
			<!-- Documento de transporte -->
			<td>{{ $value[0]->embarqueimportacion['emim_documento_transporte'] }}</td>
			<!-- Fecha ETA -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_etd'] }}</td>
			<!-- Fecha ETD -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_eta'] }}</td>
			<!-- Puerto de embarque -->
			<td>{{ $value[0]->puerto_embarque->puem_nombre }}</td>
			<!-- Valor euros-->
			<td>N/A</td>
			<!-- Giro anticipo-->
			<td>{{$value[0]->pagosimportacion['pag_valor_anticipo']}}</td>
			<!-- Fecha anticipo -->
			<td>fecha anticipo</td>
			<!-- Giro saldo total -->
			<td>{{$value[0]->pagosimportacion['pag_valor_saldo']}}</td>
			<!-- Giro saldo total -->
			<td>fecha giro saldo</td>
			<!-- Fecha legalización -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_fecha_legaliza_giro}}</li>
					@endforeach
				</ul>
			</td>

			<!-- Licencia importacion -->
			<td>
				<ul>
					@foreach($value[1] as $key => $value1)
					<li>{{$value1->pdim_numero_licencia_importacion}}</li>
					@endforeach
				</ul>
			</td>
			<!-- fecha factura-->
			<td>{{$value[0]->pagosimportacion['pag_fecha_factura']}}</td>
			<!-- TRM liquidacion factura-->
			<td>{{$value[0]->pagosimportacion['trm_liquidacion_factura']}}</td>
			<!-- Factura en contabilidad -->
			<td>{{$value[0]->pagosimportacion['pag_fecha_envio_contabilidad']}}</td>
			<!-- Recibo documentos originales -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_recibido_documentos_ori'] }}</td>
			<!-- fecha envio documentos agencia de aduana -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_envio_aduana'] }}</td>
			<!-- fecha envio ficha tecnica agencia de aduanas -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_envio_ficha_tecnica'] }}</td>
			<!-- fecha envio lista de empaque -->
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_envio_lista_empaque'] }}</td>
			<!-- fecha levante -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_fecha_levante}}</li>
					@endforeach
				</ul>
			</td>
			<!-- fecha retiro puerto -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_retiro_puert'] }}</td>
			<!-- fecha envio ASN WMS -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_envio_comex'] }}</td>		
			<!-- fecha llegada a besa -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_llegada_be'] }}</td>	
			<!-- fecha recibo lista de empaque -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_recep_list_empaq'] }}</td>		
			<!-- fecha envio liquidacion y costeo -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_envi_liqu_costeo'] }}</td>	
			<!-- Numero comex -->
			<td>Numero comex</td>		
			<!-- Fecha entrada al sistema -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'] }}</td>	
			<!-- Origen mercancia -->
			<td>
				<ul>
					@foreach($value[0]->origenMercancia as $key => $value1)
					<li>{{$value1->origenes[0]->ormer_nombre}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Tipo de carga -->
			@if($value[0]->embarqueimportacion['emim_tipo_carga'] == 1 ||$value[0]->embarqueimportacion['emim_tipo_carga'] == 2)

			<td>{{$value[0]->embarqueimportacion['tipoCarga']['tcar_descripcion']}}</td>	

			@elseif($value[0]->embarqueimportacion['emim_tipo_carga'] == 3 )
			<td>
				@foreach($value[5] as $key => $value1)
				<li>{{$value1}}</li>
				@endforeach
			</td>
			@else
			<td></td>
			@endif
			<!-- Numero de contenedor -->
			<td>
				<ul>
					@foreach($value[4] as $key => $value1)
					@if($value1->cont_numero_contenedor != "")
					<li>{{$value1->cont_numero_contenedor}}</li>
					@endif
					@endforeach
				</ul>
			</td>
			<!-- volumen -->
			<td>
				<ul>
					@foreach($value[4] as $key => $value1)
					@if($value1->cont_cubicaje != "")
					<li>{{$value1->cont_cubicaje}}</li>
					@endif
					@endforeach
				</ul>
			</td>
			<!-- Cajas -->
			<td>
				<ul>
					@foreach($value[4] as $key => $value1)
					@if($value1->cont_cantidad != "")
					<li>{{$value1->cont_cantidad}}</li>
					@elseif($value1->cont_cajas != "")
					<li>{{$value1->cont_cajas}}</li>
					@endif
					@endforeach
				</ul>
			</td>
			<!-- Puerto de embarque -->
			<td>{{ $value[0]->puerto_embarque['puem_nombre'] }}</td>
			<!-- Embarcador -->
			<td>{{ $value[0]->embarqueimportacion['embarcador']['razonSocialTercero'] }}</td>
			<!-- Linea maritima -->
			<td>{{ $value[0]->embarqueimportacion['lineamaritima']['razonSocialTercero'] }}</td>
			<!-- Agencia de aduanas -->
			<td>{{ $value[0]->embarqueimportacion['aduana']['razonSocialTercero'] }}</td>
			<!-- Empresa transportadora -->
			<td>{{ $value[0]->embarqueimportacion['transportador']['razonSocialTercero'] }}</td>
			<!-- Numero de declaracion de importacion -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_numero}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Valor del arancel -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_arancel}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Valor del iva -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_iva}}</li>
					@endforeach
				</ul>
			</td>

			<!-- tasa dec imp -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_trm}}</li>
					@endforeach
				</ul>
			</td>
			<!-- factor importacion total -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_factor_dolar_tasa'] }}</td>
			<!-- factor importacion logistico -->
			<td>{{ $value[0]->nacionalizacionimportacion['naco_factor_logist_tasa'] }}</td>
			<!-- solicitud de booking -->
			<td>N/A</td>
			<!-- Confirmacion de booking -->
			<td>N/A</td>
			<!-- fecha entrega total proveedor -->
			<td>{{ $value[0]->imp_fecha_entrega_total }}</td>
			<!-- preinspeccion -->			
			@if($value[0]->nacionalizacionimportacion['naco_preinscripcion']  == 1)
			<td>SI</td>
			@elseif($value[0]->nacionalizacionimportacion['naco_preinscripcion']  == 0)
			<td>NO</td>
			@else
			<td></td>
			@endif
			<!-- tipo de levante -->
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->levanteDeclaracion['tlev_nombre']}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Control posterior -->			
			@if($value[0]->nacionalizacionimportacion['naco_control_posterior']  == 1)
			<td>SI</td>
			@elseif($value[0]->nacionalizacionimportacion['naco_control_posterior']  == 0)
			<td>NO</td>
			@else
			<td></td>
			@endif
			<td>INDICADOR TRANSITO INTERNNAL</td>
			<td>DIAS TRANSITO</td>
			<td>DIAS NAC SIA</td>
			<td>DIAS RETIRO DE PUERTO</td>
			<td>DIAS PARA (ETD)</td>
			<td>DIAS LEGALIZACION</td>
			<td>"DIAS FICHA TEC. ANTES ETA"</td>
			<td>DATOS</td>
			<!-- Oservaciones-->
			<td>{{ $value[0]->imp_observaciones }}</td>

		</tr>
		@endforeach

	</tbody>
</table>

