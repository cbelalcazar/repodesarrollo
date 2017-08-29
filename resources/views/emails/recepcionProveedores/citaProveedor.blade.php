@extends('emails.notificaciones')

@section('content')
  <p style="{{ $style['body-line'] }}">
    Se ha asignado cita para despacho al proveedor {{ $cita.cit_nombreproveedor }}, fecha de la cita {{Carbon::parse($cita.cit_fechainicio)->format(dd-mm-yyyy)}}
  </p>
@endsection
