@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')


<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2/pago.js')}}" type="text/javascript" language="javascript"></script>


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

{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT',  'id' => 'importacionform')) }}

<input type="hidden" name="pag_importacion" value="{{$objeto->pag_importacion}}">

<!-- Valor anticipo  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor anticipo: (*)") }}
  {{ Form::number("pag_valor_anticipo", $objeto->pag_valor_anticipo, ['class' => 'form-control validemosText', 'id' =>  'pag_valor_anticipo', 'placeholder' =>  'Ingresar el valor del anticipo','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
<div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor anticipo    -->

<!-- Valor fecha del anticipo  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha del anticipo : (*)") }}
  {{ Form::text("pag_fecha_anticipo", $objeto->pag_fecha_anticipo, ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'pag_fecha_anticipo', 'placeholder' =>  'Ingresar la fecha del anticipo','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>

<!-- Valor saldo  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor saldo: (*)") }}
  {{ Form::number("pag_valor_saldo", $objeto->pag_valor_saldo, ['class' => 'form-control validemosText', 'id' =>  'pag_valor_saldo', 'placeholder' =>  'Ingresar el valor del saldo','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor saldo -->


<!-- Fecha del saldo  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha del saldo : (*)") }}
  {{ Form::text("pag_fecha_saldo", $objeto->pag_fecha_saldo, ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'pag_fecha_saldo', 'placeholder' =>  'Ingresar la fecha del saldo','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Fecha del saldo    -->

<!-- Valor comision  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor comisión: (*)") }}
  {{ Form::number("pag_valor_comision", $objeto->pag_valor_comision, ['class' => 'form-control validemosText', 'id' =>  'pag_valor_comision', 'placeholder' =>  'Ingresar el valor de la comisión','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor comision    -->

<!-- Valor total  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor total: (*)") }}
  {{ Form::number("pag_valor_total", $objeto->pag_valor_total, ['class' => 'form-control validemosText', 'id' =>  'pag_valor_total', 'placeholder' =>  'Ingresar el valor total','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor total    -->

<!-- Valor FOB  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor FOB: (*)") }}
  {{ Form::number("pag_valor_fob", $objeto->pag_valor_fob, ['class' => 'form-control validemosText', 'id' =>  'pag_valor_fob', 'placeholder' =>  'Ingresar el valor total','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor FOB    -->

<!-- Numero factura  -->
<div class="col-sm-6">
  {{ Form::label('', "No. Factura: (*)") }}
  {{ Form::number("pag_numero_factura", $objeto->pag_numero_factura, ['class' => 'form-control validemosText', 'id' =>  'pag_numero_factura', 'placeholder' =>  'Ingresar el numero de la factura','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Numero factura    -->

<!-- Valor trm liquidacion factura  -->
<div class="col-sm-6">
  {{ Form::label('', "TRM liquidación factura: (*)") }}
  {{ Form::number("trm_liquidacion_factura", $objeto->trm_liquidacion_factura, ['class' => 'form-control validemosText', 'id' =>  'trm_liquidacion_factura', 'placeholder' =>  'Ingresar el valor total','min' => '0','max' => '999999999','step' => '0.01','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor trm liquidacion factura    -->

<!-- Valor fecha de la factura  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha de la factura : (*)") }}
  {{ Form::text("pag_fecha_factura", $objeto->pag_fecha_factura, ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'pag_fecha_factura', 'placeholder' =>  'Ingresar la fecha de la factura','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha de la factura    -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha de envio a contabilidad : (*)") }}
  {{ Form::text("pag_fecha_envio_contabilidad", $objeto->pag_fecha_envio_contabilidad, ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'pag_fecha_envio_contabilidad', 'placeholder' =>  'Ingresar la fecha de envio a contabilidad','readonly' => 'readonly','required' => 'required']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<div class="col-sm-12">
<br>
{{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary pull-right', 'id' => 'finalizar1')) }}
</div>
{{ Form::close() }}
@endsection

