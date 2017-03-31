@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<!-- ************************************ -->
<!-- /************************************
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 *****************************************
 *****************************************/ -->
 <script src="{{url('/js/importacionesv2/pago.js')}}" type="text/javascript" language="javascript"></script>


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
<!-- ************************************ -->
<!-- End General errors in form -->
<!-- ************************************ -->

{{ Form::model($producto, array('route' => array($route, $producto->id), 'method' => 'PUT')) }}

@if($declaracion)
<!-- Valor fecha del anticipo  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha de declaracion anticipada : (*)") }}
  {{ Form::text("pdim_fecha_anticipado", old("pdim_fecha_anticipado"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'pdim_fecha_anticipado', 'placeholder' =>  'Ingresar la fecha de declaracion anticipada','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End fecha del anticipo    -->

@endif

@if($registroImportacion)
<!-- Consecutive import  -->
<div class="col-sm-6" id="imp_consecutivo-div">
  {{ Form::label('', "Numero de licencia de importación: (*)") }}
  {{ Form::text("pdim_numero_licencia_importacion", old("pdim_numero_licencia_importacion"), ['class' => 'form-control validemosText', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el numero de licencia de importación','maxlength' => '250']) }}
  <div class="help-block error-help-block" id='error_imp_consecutivo'></div>
</div>
<!-- End Consecutive import    -->
@endif

<div class="col-sm-12">
<br>
  {{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary pull-right')) }}
</div>

{{ Form::close() }}

@endsection
