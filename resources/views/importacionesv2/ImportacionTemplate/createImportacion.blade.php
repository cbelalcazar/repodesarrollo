@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>
@include('importacionesv2.importacionTemplate.lineaProceso')

<br><br><br>
<div class="form-group">
  @foreach($errors->all() as $key => $value)
  <div class="alert alert-danger">{{$value}}</div>
  @endforeach
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
</div>

{{ Form::open(array('url' => "$url",'id' => "importacionform")) }}
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
  {{ Form::close() }}
  <input type="hidden" id="route1" value="{{route('search')}}">
</div>


<label  class="control-label">Productos de importacion</label>
<div class="form-group">
  <div class="row">

    <div class="col-xs-10">

      {{ Form::text('imp_producto', '', ['class' => 'form-control', 'id' =>  'imp_producto', 'placeholder' =>  'Ingresar la referencia del producto'])}}
    </div>

    <div class="col-xs-2">
      <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando orden" onclick="autocompleteprod(this);">Consultar
      </button>      
    </div>
  </div>

</div>



<div class="form-group" id="ocultar2">
  <div class="portlet-body form">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <table id="tablaProducto" class="table table-hover">
      <!-- Aqui se generan los titulos de la tabla-->
      <thead>
        <tr>
          <td>Referencia</td>
          <td>Requiere declaracion</td>          
          <td>Requiere Registro</td>
          <td>Eliminar</td>
        </tr>
      </thead>
      <tbody id="añadir1">
      </tbody>
    </table>
  </div>
</div>




<input type="hidden" id="route2" value="{{route('searchProducto')}}">

<div class="form-group">
  <div class="row">
    <div class="col-xs-12">
      <label  class="control-label">Puerto de embarque</label>
      <div class="input-group add-on">
        {{ Form::select('imp_puerto_embarque', $puertos, null, ['placeholder' => 'Selecciona un puerto de embarque...', 'class' => 'form-control', 'id' => 'imp_puerto_embarque']) }}
        <span class="input-group-addon" data-toggle="modal" data-target="#myModal" onclick="verModel($('#ajaxpuerto').val());">
          <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo puerto"> 
            <i class='glyphicon glyphicon-plus'></i>
          </a>
        </span>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="ajaxpuerto" value="{{route('createpuertoajax')}}">

<div class="form-group">
  <div class="row">
    <div class="col-xs-12">
      <label class="control-label">Inconterm</label>
      <div class="input-group add-on">
        {{ Form::select('imp_iconterm', $inconterm, null, ['placeholder' => 'Selecciona un inconterm...', 'class' => 'form-control', 'id' => 'imp_iconterm']) }}
        <span class="input-group-addon" data-toggle="modal" data-target="#myModal"  onclick="verModel($('#ajaxinconterm').val());">
          <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo inconterm "> 
            <i class='glyphicon glyphicon-plus'></i>
          </a>
        </span>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="ajaxinconterm" value="{{route('createincontermajax')}}">

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

@include('importacionesv2.importacionTemplate.modal')
<input type="hidden" id="productoajax" value="{{route('createproductoajax')}}">
<input type="hidden" id="productoGuarda" value="">
<input type="hidden" id="idguarda" value="">
{{ Form::close() }}
{!! $validator  !!}
@endsection
