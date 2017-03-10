@extends('app')
@section('content')

<table class="table table-condensed">
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
		</tr>
		@endforeach

	</tbody>
</table>

@endsection