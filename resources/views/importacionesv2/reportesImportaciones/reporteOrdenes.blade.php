
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
				<ul>
					@foreach($value[1] as $key => $value1)
					<li>{{$value1->producto['productoItem']['referenciaItem']}}-{{$value1->producto['productoItem']['descripcionItem']}}</li>
					@endforeach
				</ul>
			</td>
			<!-- Proformas -->
			<td>
				<ul>
					@foreach($value[2] as $key => $value1)
					<li>{{$value1->prof_numero}}</li>
					@endforeach
				</ul>
			</td>
			<!-- valor proforma -->
			<td>{{ $value[2][0]->prof_valor_proforma }}</td>
			<!-- Factura no -->
			<td>{{$value[0]->pagosimportacion['pag_numero_factura']}}</td>
			<!-- Valor fob -->
			<td>{{ $value[0]->pagosimportacion['pag_valor_fob'] }}</td>
			<!-- Documento de transporte -->
			<td>{{ $value[0]->embarqueimportacion['emim_documento_transporte'] }}</td>
			<!-- Fecha ETD -->
			@if($value[0]->embarqueimportacion['emim_fecha_etd'] != "")
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_etd'] }}</td>
			@elseif($value[0]->embarqueimportacion['emim_fecha_etd'] == "")
			<td style="color:red;">{{$value[6]['fechaETD']}}</td>
			@endif
			
			<!-- Fecha ETA-->
			@if($value[0]->embarqueimportacion['emim_fecha_eta'] != "")
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_eta'] }}</td>
			@elseif($value[0]->embarqueimportacion['emim_fecha_eta'] == "")
			<td style="color:red;">{{$value[6]['fechaETA']}}</td>
			@endif
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
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETD'])->addDays(10)->format('d-m-Y') }}</td>
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
					@if($value1->pdim_numero_licencia_importacion != "")
					<li>{{$value1->pdim_numero_licencia_importacion}}</li>
					@endif
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
			@if($value[0]->embarqueimportacion['emim_fecha_envio_ficha_tecnica'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->subDays(15)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_envio_ficha_tecnica'] }}</td>
			@endif
			
			<!-- fecha envio lista de empaque -->
			@if($value[0]->embarqueimportacion['emim_fecha_envio_lista_empaque'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->subDays(7)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->embarqueimportacion['emim_fecha_envio_lista_empaque'] }}</td>
			@endif

			<!-- fecha levante -->
			@if(count($value[3]) == 0)
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(3)->format('d-m-Y') }}</td>
			@else
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{$value1->decl_fecha_levante}}</li>
					@endforeach
				</ul>
			</td>
			@endif
			
			<!-- fecha retiro puerto -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_retiro_puert'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(5)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_retiro_puert'] }}</td>
			@endif
			<!-- fecha envio ASN WMS -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_envio_comex'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(5)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_envio_comex'] }}</td>
			@endif
			<!-- fecha llegada a besa -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_llegada_be'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(6)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_llegada_be'] }}</td>
			@endif
			<!-- fecha recibo lista de empaque -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_recep_list_empaq'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(8)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_recep_list_empaq'] }}</td>
			@endif
			<!-- fecha envio liquidacion y costeo -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_envi_liqu_costeo'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(9)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_envi_liqu_costeo'] }}</td>
			@endif
			<!-- Numero comex -->
			<td>Numero comex</td>		
			<!-- Fecha entrada al sistema -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'] == "")
			<td style="color:red;">{{ \Carbon\Carbon::parse($value[6]['fechaETA'])->addDays(11)->format('d-m-Y') }}</td>
			@else
			<td>{{ $value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'] }}</td>
			@endif
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
			<td>{{ $value[0]->embarqueimportacion['lineamaritima']['lmar_descripcion'] }}</td>
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
			<!-- Indicador transito internacional -->
			<td>{{$value[0]->puerto_embarque['puem_itime']}}</td>
			<!-- Dias transito -->
			@if($value[0]->embarqueimportacion['emim_fecha_eta'] != "" && $value[0]->embarqueimportacion['emim_fecha_etd'] != "")
			<td>{{\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_eta'])->diffInDays(\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_etd']))}}</td>
			@else
			<td></td>
			@endif

				<!-- FECHA NAC SIA -->
			@if(count($value[3]) == 0)
			<td></td>
			@elseif(count($value[3]) > 0 && $value[0]->embarqueimportacion['emim_fecha_eta'] != "")
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{\Carbon\Carbon::parse($value1->decl_fecha_levante)->diffInDays(\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_eta']))}}</li>
					@endforeach
				</ul>
			</td>
			@endif

			<!-- Dias retiro puerto -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_retiro_puert'] != "" && $value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'] != "")
			<td>{{\Carbon\Carbon::parse($value[0]->nacionalizacionimportacion['naco_fecha_retiro_puert'])->diffInDays(\Carbon\Carbon::parse($value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema']))}}</td>
			@else
			<td></td>
			@endif

			<!-- Dias para el (ETD) -->
			@if($value[0]->embarqueimportacion['emim_fecha_etd'] != "" && $value[0]->imp_fecha_entrega_total != "")
			<td>{{\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_etd'])->diffInDays(\Carbon\Carbon::parse($value[0]->imp_fecha_entrega_total))}}</td>
			@else
			<td></td>
			@endif

			<!-- Dias legalizacion -->
			@if(count($value[3]) == 0)
			<td></td>
			@elseif(count($value[3]) > 0)
			<td>
				<ul>
					@foreach($value[3] as $key => $value1)
					<li>{{\Carbon\Carbon::parse($value1->decl_fecha_legaliza_giro)->diffInDays(\Carbon\Carbon::parse($value1->decl_fecha_levante))}}</li>
					@endforeach
				</ul>
			</td>
			@endif

			<!-- Dias ficha tecnica antes del eta -->
			@if($value[0]->embarqueimportacion['emim_fecha_eta'] != "" && $value[0]->embarqueimportacion['emim_fecha_envio_ficha_tecnica'] != "")
			<td>{{\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_eta'])->diffInDays(\Carbon\Carbon::parse($value[0]->embarqueimportacion['emim_fecha_envio_ficha_tecnica']))}}</td>
			@else
			<td></td>
			@endif
			

			<!-- Datos -->
			@if($value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'] != "" && $value[0]->imp_fecha_entrega_total != "")
			<td>{{\Carbon\Carbon::parse($value[0]->nacionalizacionimportacion['naco_fecha_entrada_sistema'])->diffInDays(\Carbon\Carbon::parse($value[0]->imp_fecha_entrega_total))}}</td>
			@else
			<td></td>
			@endif

			

			<!-- Oservaciones-->
			<td>{{ $value[0]->imp_observaciones }}</td>

		</tr>
		@endforeach

	</tbody>
</table>

