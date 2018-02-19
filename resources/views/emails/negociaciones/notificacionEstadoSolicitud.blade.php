@extends('emails.notificaciones')

<style>
  body {
    font-family: Arial, Helvetica, sans-serif !important;
    font-size: 15px !important;
  }
</style>

@section('content')

<div class="form-group">
  <label><strong>Solicitud No.</strong> </label>
  {{$objTSolEnvioNego['sen_sol_id']}}
</div>

<div class="form-group">
  <label><strong>Fecha de solicitud:</strong> </label>
  {{$objTSolEnvioNego['soh_fechaenvio']}}
</div>

<p>La solicitud ha sido aprobada por <strong>Fulanito</strong> por favor ingrese al aplicativo y realice las acciones correspondientes.</p>

@endsection
