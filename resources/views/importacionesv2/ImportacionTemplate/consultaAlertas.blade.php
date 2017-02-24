@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')

<!-- /**
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */ -->

<script src="{{url('/js/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>
<div class="btn-group btn-group-justified">
        <a href="{{ $url }}" class="btn btn-default"> Consultar todos </a>
      </div>
      <br>
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<div class="portlet-body form">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  <table id="example" class="display" cellspacing="0" width="100%">
    <!-- Aqui se generan los titulos de la tabla-->
    <thead>
      <tr>
        @foreach($titulosTabla as $key => $value)
        <td>{{$value}}</td>
        @endforeach
      </tr>
    </thead>
    <tbody>
      <!-- Aqui se generan los registros de la tabla-->
      @foreach($datos as $key => $value)
      <tr>

        <td>{{$value->producto[0]->prod_referencia}}</td>
        <td>{{$value->importacion[0]->imp_consecutivo}}</td>
        @if($value->pdim_alerta == 1)
        <td>SI</td>
        @else
        <td>NO</td>
        @endif
        <td>Cerrar</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script type="text/javascript">
  $(document).ready( function () {
    $('#example').DataTable({
      responsive: true,
    });
  } );

</script>
@endsection
