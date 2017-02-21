@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')

<script src="{{url('/js/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>
<div class="btn-group btn-group-justified">
        <a href="{{ $url }}" class="btn btn-default"> Consultar todos </a>
        <a href="{{ route('Importacion.create') }}" class="btn btn-default"> Crear Nuevo </a>
      </div>
      <br>
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>

 {{ Form::open(['url' => "$url", 'method' => 'get']) }}
 <input type="hidden" name="consulto" value="1">
<div class="form-group">
  <div class="row">
    <div class="col-xs-4">
      {{ Form::label('', "Consulta por puerto") }}
      {{ Form::select('imp_puerto_embarque', $puertos, null, ['placeholder' => 'Selecciona una moneda...', 'class' => 'form-control']) }}
    </div>
    <div class="col-xs-4">
      {{ Form::label('', "Consulta por estado") }}
      {{ Form::select('imp_estado_proceso', $estados, null, ['placeholder' => 'Selecciona una moneda...', 'class' => 'form-control']) }}
    </div>
    <div class="col-xs-4">
      {{ Form::label('', "Consulta por consecutivo") }}
      {{ Form::text("imp_consecutivo", old("imp_consecutivo"), ['class' => 'form-control', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
    </div>

  </div>
  <br>
  <div class="form-group">
    {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
    {{ Form::label('', "Busqueda de proveedor") }}
    {{ Form::text('imp_proveedor', '', ['class' => 'form-control', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
    {{ Form::label('', "") }}
    {{ Form::text('razonSocialTercero', '', ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
    <input type="hidden" id="route1" value="{{route('search')}}">
  </div>
    <div class="form-group">
    {{ Form::submit('Consultar', array('class' => 'btn btn-primary')) }}
    </div>
  

</div>
{{ Form::close() }}

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

        <td>{{$value->imp_consecutivo}}</td>
        <td>{{$value->imp_proveedor}}</td>
        <td>{{$value->estado->est_nombre}}</td>
        <td>{{$value->puerto_embarque->puem_nombre}}</td>
        <td> <a class="btn btn-small btn-info" href="{{ URL::to("$url2/" . $value->id . '/edit') }}">Editar</a></td>
        <td>Eliminar</td>
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
