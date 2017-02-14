@extends('app')
@section('content')
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

      @yield('generic')
    </div>
    <!-- END SAMPLE FORM PORTLET-->
  </div>
  </div>

  @endsection
