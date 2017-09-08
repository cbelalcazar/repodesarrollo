@extends('emails.notificaciones')

@section('content')
  <p style="{{ $style['body-line'] }}">
  La empresa <strong>Belleza Express S.A.</strong> solicita al proveedor {{$nombre}} ingresar al portal de belleza express y solicitar cita para las siguientes referencias, con fecha de entrega {{$fecha}}.
  </p>
  <p>
  <strong>Referencias</strong>
  </p>
  <ul>
  @foreach($programaciones as $key => $value)
      <li>Orden de compra: {{$value['prg_tipo_doc_oc']}} {{$value['prg_num_orden_compra']}} - Referencia: {{$value['prg_referencia']}} - {{$value['prg_desc_referencia']}} - Cantidad: {{$value['prg_cant_programada']}}</li>
  @endforeach
  </ul>
 
@endsection
