@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')


<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2/pago.js')}}" type="text/javascript" language="javascript"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- ************************************ -->
<!-- General errors in form -->
<!-- ************************************ -->

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

{{ Form::open(array('url' => "$url",'id' => "importacionform"))}}
<input type="hidden" name="naco_importacion" value="{{$idImportacion}}">

<!-- Currency trading -->
<div class="col-sm-12">
  {{ Form::label('', "Tipo de importación: (*)") }}
  {{ Form::select('naco_tipo_importacion', $naco_tipo_importacion, null, ['placeholder' => 'Selecciona una tipo  de importacion...', 'class' => 'form-control validemosText', 'id' => 'naco_tipo_importacion']) }}
  <div class="help-block error-help-block" id='error'></div><br>
</div>   

<!-- Currency trading -->

<!-- Valor anticipo  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor anticipo a la agencia de aduanas: (*)") }}
  {{ Form::number("naco_anticipo_aduana", old("naco_anticipo_aduana"), ['class' => 'form-control validemosText', 'id' =>  'naco_anticipo_aduana', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '1','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor anticipo    -->
<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha de anticipo agencia de aduanas: (*)") }}
  {{ Form::text("naco_fecha_anticipo_aduana", old("naco_fecha_anticipo_aduana"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_anticipo_aduana', 'placeholder' =>  'Ingresar la fecha de envio a contabilidad','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<div class="col-sm-6">
  <div class="col-sm-6">
    <br>{{ Form::label('', "Preinscripcion: (*)") }}<br>
    {{ Form::checkbox("naco_preinscripcion", '1', null,['data-toggle' => 'toggle']) }}  
  </div>

  <div class="col-sm-6">
    <br>{{ Form::label('', "Control posterior: (*)") }}<br>
    {{ Form::checkbox("naco_control_posterior", '1', null,['data-toggle' => 'toggle']) }}
  </div>

</div>

<!-- Currency trading -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Tipo de nacionalización: (*)") }}
  {{ Form::select('naco_tipo_nacionalizacion', $naco_tipo_nacionalizacion, null, ['placeholder' => 'Selecciona una tipo  de nacionalizació...', 'class' => 'form-control validemosText', 'id' => 'naco_tipo_nacionalizacion']) }}
  <div class="help-block error-help-block" id='error'></div><br>
</div>   

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha recibo facturas Belleza Express: (*)") }}
  {{ Form::text("naco_fecha_recibo_fact_be", old("naco_fecha_recibo_fact_be"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_recibo_fact_be', 'placeholder' =>  'Ingresar la fecha de recibo facturas Belleza Express','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha entrega de facturas a contabilidad: (*)") }}
  {{ Form::text("naco_fecha_entrega_fact_cont", old("naco_fecha_entrega_fact_cont"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_entrega_fact_cont', 'placeholder' =>  'Ingresar la fecha de envio de facturas a contabilidad','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de entrega documentos al transportador: (*)") }}
  {{ Form::text("naco_fecha_entrega_docu_transp", old("naco_fecha_entrega_docu_transp"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_entrega_docu_transp', 'placeholder' =>  'Ingresar la fecha de entraga documentos al transportador','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de envio a comex: (*)") }}
  {{ Form::text("naco_fecha_entrega_docu_transp", old("naco_fecha_entrega_docu_transp"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_entrega_docu_transp', 'placeholder' =>  'Ingresar la fecha de entraga documentos al transportador','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de llegada a Belleza Express: (*)") }}
  {{ Form::text("naco_fecha_llegada_be", old("naco_fecha_llegada_be"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_llegada_be', 'placeholder' =>  'Ingresar la fecha de llegada a Belleza Express','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de recepción lista de empaque + Ciego: (*)") }}
  {{ Form::text("naco_fecha_recep_list_empaq", old("naco_fecha_recep_list_empaq"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_recep_list_empaq', 'placeholder' =>  'Ingresar la fecha de recepción lista de empaque','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de envio liquidación y costeo: (*)") }}
  {{ Form::text("naco_fecha_envi_liqu_costeo", old("naco_fecha_envi_liqu_costeo"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_envi_liqu_costeo', 'placeholder' =>  'Ingresar la fecha de envio lista de empaque de empaque','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de entrada al sistema: (*)") }}
  {{ Form::text("naco_fecha_entrada_sistema", old("naco_fecha_entrada_sistema"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_entrada_sistema', 'placeholder' =>  'Ingresar la fecha de entrada al sistema','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>

<div class="col-sm-12">  
  <br>
  <div class="mt-checkbox-list col-sm-6">
    <label class="mt-checkbox mt-checkbox-outline">Requiere ajuste: (*)
      {{ Form::checkbox("naco_ajuste", '1', null,['id' => 'showRadios'] ) }}
      <span></span>
    </label>
  </div>
  <div class="col-sm-3 hide radios1">
    <br>
    {{ Form::radio("naco_opcion", '1') }}
    {{ Form::label('', "Sobrante") }}  
  </div>
  <div class="col-sm-3 hide radios1">
    <br>
    {{ Form::radio("naco_opcion", '1') }}
    {{ Form::label('', "Faltante") }} 
  </div>
</div>
<script>
  $('#showRadios').click(function(event) {
    if($('#showRadios').prop('checked'))
    {
      $('.radios1').removeClass('hide');
    }else{
      $('.radios1').addClass('hide');
    }
    
  });
</script>


<!-- Valor anticipo  -->
<div class="col-sm-12 hide">
  <br>
  {{ Form::label('', "Valor: (*)") }}
  {{ Form::number("naco_valorseleccion", old("naco_valorseleccion"), ['class' => 'form-control validemosText', 'id' =>  'naco_valorseleccion', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '1','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<br><br>

<div class="col-sm-6"><br>
  {{ Form::label('', "Factor dolar tasa: (*)") }}
  {{ Form::number("naco_valorseleccion", old("naco_valorseleccion"), ['class' => 'form-control validemosText', 'id' =>  'naco_valorseleccion', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '1','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- Valor anticipo  -->
<div class="col-sm-6"><br>
  {{ Form::label('', "Factor dolar porcentaje: (*)") }}
  {{ Form::number("naco_valorseleccion", old("naco_valorseleccion"), ['class' => 'form-control validemosText', 'id' =>  'naco_valorseleccion', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '1','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>



<!-- End Valor anticipo    -->
<!-- End Valor fecha envio a contabilidad     -->
<div class="col-sm-12">
  <br>
  {{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary pull-right', 'id' => 'finalizar1')) }}
</div>
{{ Form::close() }}
@endsection

