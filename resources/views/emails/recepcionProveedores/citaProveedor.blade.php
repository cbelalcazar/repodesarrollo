@extends('emails.notificaciones')

@section('content')
  <p style="{{ $style['body-line'] }}">
  La empresa <strong>Belleza Express S.A.</strong> solicita al proveedor {{$nombre}} realizar la entrega de las mercancías a continuación mencionadas en la fecha: {{ $fecha }} hora: {{ $hora }}:
  </p>
  <p>
  <strong>Detalle de la cita</strong>
  </p>
  <ul>
  @foreach($programaciones as $key => $value)
      <li>Orden de compra: {{$value['prg_tipo_doc_oc']}} {{$value['prg_num_orden_compra']}} - Referencia: {{$value['prg_referencia']}} - {{$value['prg_desc_referencia']}} - Cantidad: {{$value['prg_cant_programada']}}</li>
  @endforeach
  </ul>
 
@endsection
