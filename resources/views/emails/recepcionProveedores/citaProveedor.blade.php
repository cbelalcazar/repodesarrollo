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
      <li>Referencia: {{$value['referencia']}} - Cantidad: {{$value['cantidadProgramada']}}</li>
  @endforeach
  </ul>
 
@endsection
