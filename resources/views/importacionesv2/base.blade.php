@extends('app')
@section('content')
<div class="col-md-14 ">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <label style="font-size:20px;">{{$titulo}}</label>
    </div>
    <div class="panel-body" align="left">
      <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light ">

          <div class="btn-group btn-group-justified">
            <a href="{{ $url }}" class="btn btn-default"> Consultar todos </a>
            <a href="{{ $url.'/create' }}" class="btn btn-default"> Crear Nuevo </a>
          </div>
          <br>
          @yield('generic')
        </div>
        <!-- END SAMPLE FORM PORTLET-->
      </div>
    </div>
  </div>
</div>
@endsection
