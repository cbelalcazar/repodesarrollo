@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/multi-select.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/jquery.multi-select.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>

<div class="form-group">
  @include('importacionesv2.importacionTemplate.lineaProceso')
</div>


<br><br><br><br><br>
<div class="form-group">
  @foreach($errors->all() as $key => $value)
  <div class="alert alert-danger">{{$value}}</div>
  @endforeach
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
</div>

{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT')) }}
<div class="form-group">
  {{ Form::label('', "Consecutivo de creacion") }}
  {{ Form::text("imp_consecutivo", old("imp_consecutivo"), ['class' => 'form-control', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
</div>
<div class="form-group">
  {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
  {{ Form::label('', "Busqueda de proveedor") }}
  {{ Form::text('imp_proveedor', old("imp_proveedor"), ['class' => 'form-control', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
  {{ Form::label('', "") }}
  {{ Form::text('razonSocialTercero', '', ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
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
<br><br>
<div class="form-group">
  {!!  Form::label('origenMercancia','Origen de la mercancia', ['class' => 'control-label col-md-3"']); !!}   
  {!! Form::select('origenMercancia[]', $origenMercancia, $seleccionados, ['multiple'=>true,'class' => 'multi-select','id' => 'my-select', 'style' => 'position: absolute; left: -9999px;']) !!}
</div>


<input type="hidden" id="route2" value="{{route('searchProducto')}}">

<br><br>

<label  class="control-label">PROFORMAS DE IMPORTACION</label>
<br><br>
<div class="form-group">
  <div class="row">

    <div class="col-xs-4">
      <label  class="control-label">No de proforma:</label>
      {{ Form::text('imp_proforma', '', ['class' => 'form-control', 'id' =>  'imp_proforma', 'placeholder' =>  'Ingresar el numero de la proforma'])}}
    </div>

    <div class="col-xs-4">
      <label  class="control-label">Fecha creacion:</label>
      {{ Form::text("fech_crea_profor", old("fech_crea_profor"), ['class' => 'form-control', 'id' =>  'fech_crea_profor', 'placeholder' =>  'Ingresar fecha de creacion de la proforma', 'readonly' =>  'readonly']) }}
    </div>

    <div class="col-xs-4">
      <label  class="control-label">Fecha entrega:</label>
      {{ Form::text("fech_entreg_profor", old("fech_entreg_profor"), ['class' => 'form-control', 'id' =>  'fech_entreg_profor', 'placeholder' =>  'Ingresar fecha de entrega de la proforma', 'readonly' =>  'readonly']) }}
    </div>

</div>
<br><br>

  <div class="row">

    <div class="col-xs-4">
      <label  class="control-label">Valor proforma:</label>
      {{ Form::text('val_proforma', '', ['class' => 'form-control solo-numero', 'id' =>  'val_proforma', 'placeholder' =>  'Ingresar el valor de la proforma'])}}
    </div>
    <div class="col-xs-4">

      <label  class="control-label">Proforma principal:</label>
      <div class="form-group">
        {{ Form::checkbox("proforma_principal", '1', null,  ['class' => 'field', 'id' => 'proforma_principal']) }}
      </div>

    </div>



    <div class="col-xs-4">
      <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando proforma" onclick="tablaproforma(this);">Grabar
      </button>      
    </div>
  </div>



<div class="form-group" id="ocultar3">
  <div class="portlet-body form">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <table id="tablaproforma" class="table table-hover">
      <!-- Aqui se generan los titulos de la tabla-->
      <thead>
        <tr>
          <td>No. Proforma</td>
          <td>Fecha creacion:</td>          
          <td>Fecha entrega:</td>
          <td>Valor proforma:</td>
          <td>Proforma principal:</td>
          <td>Eliminar</td>
        </tr>
      </thead>
      <tbody id="añadir2">
      </tbody>
    </table>
  </div>
</div>

<br><br><br>





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
  {{ Form::text("imp_fecha_entrega_total", old("imp_fecha_entrega_total"), ['class' => 'form-control', 'id' =>  'imp_fecha_entrega_total', 'placeholder' =>  'Ingresar fecha de entrega total de la mercancia', 'readonly' =>  'readonly']) }}
</div>

<div class="form-group">
  {{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary')) }}
</div>

@include('importacionesv2.importacionTemplate.modal')
<input type="hidden" id="productoajax" value="{{route('createproductoajax')}}">
<input type="hidden" id="productoGuarda" value="">
<input type="hidden" id="idguarda" value="">
<input type="hidden" id="tablaGuardar" value="" name="tablaGuardar">
<input type="hidden" id="tablaGuardarproforma" value="" name="tablaGuardarproforma">
<input type="hidden" id="tablaproformaguardar" value="" name="tablaproformaguardar">
{{ Form::close() }}

<script>$('#my-select').multiSelect();</script>
{!! $validator  !!}
@endsection
