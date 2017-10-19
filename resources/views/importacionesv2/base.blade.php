@extends('app')
@section('content')
<!-- /**
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */ -->
</div>
<div class="barraEncabezado">
  <div class="letra1"><strong>IMPORTACIONES V2 // {{$titulo}}</strong></b></div>
</div>
<br>

<div class="tituloForm">
  <font size="2.5">{{$titulo}}</font>
</div>

<div class="panel-body" align="left">
  <div class="col-md-12 ">
    <!-- BEGIN SAMPLE FORM PORTLET-->
    <div class="portlet light ">

      <div class="btn-group btn-group-justified">
        <a href="{{ $url }}" class="btn btn-default"> Consultar todos </a>
         
        @if($titulo != "PRODUCTO" && $titulo != "EDITAR PRODUCTO" && !isset($metrica) )
        <a href="{{ $url.'/create' }}" class="btn btn-default"> Crear Nuevo </a>
        @endif
      </div>
      <br>
      @yield('generic')
    </div>
    <!-- END SAMPLE FORM PORTLET-->
  </div>
  </div>

  @endsection