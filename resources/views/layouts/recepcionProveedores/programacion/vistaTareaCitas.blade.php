@extends('app')

@section('content')
@include('includes.titulo')

<hr>
<h3>SOLICITUD CITAS CREADAS</h3>
<hr>
<ul>
	@foreach($progAutomaticas as $key => $value)
		<li>{{$value['prg_tipo_doc_oc']}} - {{$value['prg_num_orden_compra']}} - {{$value['prg_referencia']}}  </li>
	@endforeach
</ul>

@endsection
