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

          <div class="col-md-3 form-group">
            <button type="button" onclick=" location.href='{{ $url }}' " class="btn default">Consultar todos</button>
          </div>
          <div class="col-md-3 form-group">
            <button type="button" onclick=" location.href='{{ $url.'/create' }}' " class="btn default">Crear Nuevo</button>
          </div>
          <br>
          <br>
          <br>
          <br>
          @yield('generic')
        </div>
        <!-- END SAMPLE FORM PORTLET-->
      </div>
    </div>
  </div>
</div>
@endsection
