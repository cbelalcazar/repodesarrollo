@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')

<!-- /**
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */ -->

<script src="{{url('/js/importacionesv2/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>
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
    </div><!-- 
    <div class="col-xs-4"><br>
      {{ Form::label('', "Consulta por numero de proforma") }}
      {{ Form::text("imp_proforma", old("imp_proforma"), ['class' => 'form-control', 'id' =>  'imp_proforma', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
    </div> -->
    <div class="col-xs-12"><br>
    {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
    {{ Form::label('', "Busqueda de proveedor") }}
    {{ Form::text('imp_proveedor', '', ['class' => 'form-control', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
    </div>
    <div class="col-xs-12">
    {{ Form::label('', "") }}
    {{ Form::text('razonSocialTercero', '', ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
    </div>

  </div>
   
    <input type="hidden" id="route1" value="{{route('search')}}">
 
    <div class="form-group"><br>
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
        <td>{{$value->imp_proveedor}} -- {{$value->proveedor->razonSocialTercero}}</td>
        <td>{{$value->estado->est_nombre}}</td>
        <td>{{$value->puerto_embarque->puem_nombre}}</td>
        <td> <a class="btn btn-small btn-success glyphicon glyphicon-ok" href="{{ URL::to("$url2/" . $value->id . '/edit') }}"></a></td>
        @if($value->embarqueimportacion == null)
        <td> <a class="btn btn-small btn-danger glyphicon glyphicon-plus" href="{{route('createEmbarque1',['id' => $value->id])}}"'></a></td>
        @elseif($value->embarqueimportacion != null)
        <td> <a class="btn btn-small btn-success glyphicon glyphicon-ok" href="{{ URL::to("$url3/" . $value->embarqueimportacion->id . '/edit') }}"></a></td>
        @endif

        @if($value->pagosimportacion == null)
        <td> <a class="btn btn-small btn-danger glyphicon glyphicon-plus" href="{{route('createPagos',['id' => $value->id])}}"'></a></td>
        @elseif($value->pagosimportacion != null)
        <td> <a class="btn btn-small btn-success glyphicon glyphicon-ok" href="{{ URL::to("$url4/" . $value->pagosimportacion->id . '/edit') }}"></a></td>
        @endif
      
        @if($value['nacionalizacionimportacion'] == null && $value['embarqueimportacion'] == null)
        <td> <a class="btn btn-small btn-default glyphicon glyphicon-remove-sign disabled" href="#"></a></td>
        @elseif($value->nacionalizacionimportacion == null && $value->embarqueimportacion != null)
        <td> <a class="btn btn-small btn-danger glyphicon glyphicon-plus" href="{{route('createNC',['id' => $value->id])}}"'></a></td>
        @elseif($value->nacionalizacionimportacion != null)
        <td> <a class="btn btn-small btn-success glyphicon glyphicon-ok" href="{{ URL::to("$url5/" . $value->nacionalizacionimportacion->id . '/edit') }}"></a></td>
        @endif  


        @if($value->nacionalizacionimportacion == null || $value->embarqueimportacion == null || $value->pagosimportacion == null)
        <td> <a class="btn btn-small btn-default glyphicon glyphicon-remove-sign disabled" href="#"></a></td>
        @elseif($value->nacionalizacionimportacion != null && $value->estado->est_nombre != 'CERRADA')
        <td> <a class="btn btn-small btn-danger glyphicon glyphicon-plus" href="{{route('Importacion.show',['id' => $value->id])}}"'></a></td>
        @elseif($value->nacionalizacionimportacion != null && $value->estado->est_nombre == 'CERRADA')
        <td> <a class="btn btn-small btn-success glyphicon glyphicon-ok" href="{{route('Importacion.show',['id' => $value->id])}}"></a></td>
        @endif  

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

function crearEmbarque(id, url){
  alert(url);
  alert(id);
  $( "#mostrar2" ).load(url, id);
  alert('holis');
}

</script>
@endsection
