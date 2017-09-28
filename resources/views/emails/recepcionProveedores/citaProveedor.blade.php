@extends('emails.notificaciones')

@section('content')

  <style>
    table, td, th {    
      border: 1px solid #ddd;
      text-align: left;
    }

    table {
      border-collapse: collapse;
      width: 80%;
    }

    th, td {
      padding: 7px;
    }
  </style>

  <p style="{{ $style['body-line'] }}">
  La empresa <strong>Belleza Express S.A.</strong> solicita al proveedor {{$nombre}} realizar la entrega de las mercancías a continuación mencionadas en la fecha: {{ $fecha }} hora: {{ $hora }}:
  </p>
  <p style="{{ $style['body-line'] }}"><strong>Detalle de la cita</strong></p>
  @foreach($programaciones as $key => $value)
    <p style="{{ $style['body-line'] }}">Orden de compra: {{$value[0]['prg_tipo_doc_oc']}} - {{$key}}</p>
    <table style="{{ $style['body-line'] }}">
      <thead>
        <tr>
          <th style="{{ $style['body-line'] }}">Referencia</th>
          <th style="{{ $style['body-line'] }}">Descripcion</th>
          <th style="{{ $style['body-line'] }}">Cantidad</th>
        </tr>        
      </thead>
      <tbody>
        @foreach($value as $clave => $info)
        <tr>
          <td style="{{ $style['body-line'] }}">{{$info['prg_referencia']}}</td>
          <td style="{{ $style['body-line'] }}">{{$info['prg_desc_referencia']}}</td>
          <td style="{{ $style['body-line'] }}">{{$info['prg_cant_programada']}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @endforeach
 
@endsection
