@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>
@foreach($errors->all() as $key => $value)
<div class="alert alert-danger">{{$value}}</div>
@endforeach
{{ Form::open(array('url' => "$url")) }}
<div class="form-group">
  {{ Form::label('', "Consecutivo de creacion") }}
  {{ Form::text("imp_consecutivo", old("imp_consecutivo") ? old("imp_consecutivo") : $imp_consecutivo, ['class' => 'form-control', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
</div>
<div class="form-group">
  {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
  {{ Form::label('', "Busqueda de proveedor") }}
  {{ Form::text('imp_proveedor', '', ['class' => 'form-control', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
  {{ Form::label('', "") }}
  {{ Form::text('razonSocialTercero', '', ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
  <input type="hidden" id="route1" value="{{route('search')}}">
</div>

<div class="form-group">
<div class="row">
  <div class="col-xs-12">
    <label  class="control-label">Puerto de embarque</label>
    <!-- <div class="input-group add-on"> -->
    {{ Form::select('imp_puerto_embarque', $puertos, null, ['placeholder' => 'Selecciona un puerto de embarque...', 'class' => 'form-control']) }}
     <!-- <span class="input-group-addon"> -->
      <!-- <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo proveedor"> 
        <i class='glyphicon glyphicon-plus'></i>
      </a>
          </span> -->
    <!-- </div> -->
  </div>
  </div>
</div>

<div class="form-group">
<div class="row">
  <div class="col-xs-12">
    <label class="control-label">Inconterm</label>
    <!-- <div class="input-group add-on"> -->
  {{ Form::select('imp_iconterm', $inconterm, null, ['placeholder' => 'Selecciona un inconterm...', 'class' => 'form-control']) }}
  <!-- span class="input-group-addon">
      <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo inconterm "> 
        <i class='glyphicon glyphicon-plus'></i>
      </a>
    </span>
    </div> -->
  </div>
  </div>
</div>

<div class="form-group">
  {{ Form::label('', "Moneda negociación") }}
  {{ Form::select('imp_moneda_negociacion', $moneda, null, ['placeholder' => 'Selecciona una moneda...', 'class' => 'form-control']) }}
</div>

<div class="form-group">
  {{ Form::label('', "Observaciones") }}
  {{ Form::textarea("imp_observaciones", old("imp_observaciones"), ['class' => 'form-control', 'id' =>  'imp_observaciones', 'placeholder' =>  'Ingresar la observacion de la orden de importacion', 'maxlength' => '250', 'rows' => '5']) }}
</div>


<div class="form-group">
  {{ Form::label('', "Fecha entrega total mercancia") }}
  {{ Form::text("imp_fecha_entrega_total", old("imp_fecha_entrega_total"), ['class' => 'form-control', 'id' =>  'imp_fecha_entrega_total', 'placeholder' =>  'Ingresar fecha de entrega total de la mercancia']) }}
</div>

<div class="form-group">
{{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary')) }}
</div>

{{ Form::close() }}
{!! $validator  !!}
@endsection
