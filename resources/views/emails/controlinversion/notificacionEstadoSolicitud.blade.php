@extends('emails.notificaciones')

@section('content')

<div class="form-group">
  <label><strong>Solicitud No.</strong> </label>
  {{$dataSolicitud['soh_sci_id']}}
</div>

<div class="form-group">
  <label><strong>Fecha de solicitud:</strong> </label>
  {{$dataSolicitud['soh_fechaenvio']}}
</div>

<div class="form-group">
  <label><strong>Canal:</strong> </label>
  {{$dataSolicitud['solicitud']['sci_can_desc']}}
</div>

<p>La solicitud ha sido aprobada por <strong>{{$dataSolicitud['perNivelEnvia']['razonSocialTercero']}}</strong> por favor ingrese al aplicativo y realice las acciones correspondientes.</p>

<table style="width:100%;" border="1" bordercolor="black">
  <thead>
    <tr>
      <th colspan="2" style="text-align: center; font-weight: bold;">Linea(s)</th>
    </tr>
    <tr>
      <th>Codigo Linea</th>
      <th>Nombre Linea</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($dataSolicitud['lineasCorreo'] as $linea)

      <tr>
        <td style="text-align: center;">{{ $linea['CodLinea'] }}</td>
        <td style="text-align: center;">{{ $linea['NomLinea'] }}</td>
      </tr>

    @endforeach

  </tbody>
</table>

@endsection
