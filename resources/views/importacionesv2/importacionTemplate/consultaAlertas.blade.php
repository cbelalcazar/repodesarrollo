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
</div>
<br>
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>

 <div class="form-group">
   @if ($errors->all())
   <div class="alert alert-danger" id="mensajealerta">
    @foreach($errors->all() as $key => $value)
    <span class="glyphicon glyphicon-remove red"></span>  {{$value}} <br>
    @endforeach
    <script> setTimeout(function(){ 
      $( "#mensajealerta" ).fadeToggle("slow");
    }, 5000);</script>
  </div>
  @endif
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
</div>


<div class="portlet-body form">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  <table class="table">
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
      @if(isset($datos))
      @foreach($datos as $key => $value)
      @if($value['importacion'][0]->embarqueimportacion != null)
      <br>
      <tr class="warning">
      <td>{{$value->producto->prod_referencia}}</td>
      <td>{{$value->importacion[0]->imp_consecutivo}}</td>
      <td>{{$value->pdim_fech_req_declaracion_anticipado}}</td>      
      <td>{{$value->pdim_fech_requ_registro_importacion}}</td>
      <td>{{$value->pdim_alerta}}</td>
      </tr>
      @endif
      @endforeach
      @endif
    </tbody>
  </table>
</div>


@endsection
