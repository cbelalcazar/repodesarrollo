@extends('emails.notificaciones')

@section('content')

<p>Se ha generado una nueva solicitud con id {{$dataSolicitud['soh_sci_id']}}, y {{$dataSolicitud['perNivelEnvia']['razonSocialTercero']}} la ha enviado para que la revises y apruebes.</p>

@endsection
