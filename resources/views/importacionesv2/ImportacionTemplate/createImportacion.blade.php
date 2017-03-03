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
 <link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
 <link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
 <link href="{{url('/css/multi-select.css')}}" type="text/css" rel="stylesheet"/>
 <script src="{{url('/js/jquery.multi-select.js')}}" type="text/javascript" language="javascript"></script>
 <script src="{{url('/js/importacionesv2/importacionesv2.js')}}" type="text/javascript" language="javascript"></script>

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


<!-- ************************************ -->
<!-- Menu with tabs                       -->
<!-- ************************************ -->
<div id="tabs">
  <ul>
    <li><a id="menu1" href="#menu-1">Datos basicos</a></li>
    <li><a id="menu2" href="#menu-2">Asociar origenes</a></li>
    <li><a id="menu3" href="#menu-3">Asociar productos</a></li>
    <li><a id="menu4" href="#menu-4">Asociar proformas</a></li>
    <li><a id="menu5" href="#menu-5">Finalizar creacion</a></li>
  </ul>

  <!-- ************************************ -->
  <!-- Basic data                           -->
  <!-- ************************************ -->
  <div id="menu-1">
    <h3>Datos basicos</h3>

    <!-- Consecutive import  -->
    <div class="form-group" id="imp_consecutivo-div">
      {{ Form::label('', "Consecutivo de importación: (*)") }}
      {{ Form::text("imp_consecutivo", old("imp_consecutivo") ? old("imp_consecutivo") : $imp_consecutivo, ['class' => 'form-control validemos', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
      <div class="help-block error-help-block" id='error_imp_consecutivo'></div>
    </div>
    <!-- End Consecutive import    -->

    <!-- Provider -->
    <div class="form-group" id="proveedor-div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Proveedor: (*)") }}
      {{ Form::text('imp_proveedor', '', ['class' => 'form-control validemos', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
      <div class="help-block error-help-block" id='error_proveedor'></div>

      {{ Form::label('', "") }}
      {{ Form::text('razonSocialTercero', '', ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
      <input type="hidden" id="route1" value="{{route('search')}}">
    </div>
    <!-- End Provider -->

    <!-- Port of shipment -->
    <div class="form-group" id="puerto-div">
      <div class="row">
        <div class="col-sm-12">
          <label>Puerto de embarque: (*)</label>
          <div class="input-group add-on">
            {{ Form::select('imp_puerto_embarque', $puertos, null, ['placeholder' => 'Selecciona un puerto de embarque...', 'class' => 'form-control validemos', 'id' => 'imp_puerto_embarque']) }}
            <span class="input-group-addon" data-toggle="modal" data-target="#myModal" onclick="verModel($('#ajaxpuerto').val());">
              <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo puerto"> 
                <i class='glyphicon glyphicon-plus'></i>
              </a>
            </span>            
          </div>          
          <div class="help-block error-help-block" id='error_puerto'></div>
        </div>
      </div>
    </div>
    <input type="hidden" id="ajaxpuerto" value="{{route('createpuertoajax')}}">
    <!-- End Port of shipment -->

    <!-- Inconterm -->
    <div class="form-group" id="inconterm-div">
      <div class="row">
        <div class="col-sm-12">
          <label>Inconterm: (*)</label>
          <div class="input-group add-on">
            {{ Form::select('imp_iconterm', $inconterm, null, ['placeholder' => 'Selecciona un inconterm...', 'class' => 'form-control validemos', 'id' => 'imp_iconterm']) }}
            <span class="input-group-addon" data-toggle="modal" data-target="#myModal"  onclick="verModel($('#ajaxinconterm').val());">
              <a class='my-tool-tip' data-toggle="tooltip" data-placement="left" title="Agregar un nuevo inconterm "> 
                <i class='glyphicon glyphicon-plus'></i>
              </a>
            </span>
          </div>
          <div class="help-block error-help-block" id='error_inconterm'></div>
        </div>
      </div>
    </div>
    <input type="hidden" id="ajaxinconterm" value="{{route('createincontermajax')}}">
    <!-- End inconterm -->

    <!-- Currency trading -->
    <div class="form-group" id="moneda-div">
      {{ Form::label('', "Moneda negociación: (*)") }}
      {{ Form::select('imp_moneda_negociacion', $moneda, null, ['placeholder' => 'Selecciona una moneda...', 'class' => 'form-control validemos', 'id' => 'imp_moneda_negociacion']) }}
      <div class="help-block error-help-block" id='error_moneda'></div>
    </div>   


    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente1" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
    <br><br>

    

  </div>
  <!-- ************************************ -->
  <!-- End Basic data                       -->
  <!-- ************************************ -->


  <!-- ************************************ -->
  <!-- Associate origins of the merchandise -->
  <!-- ************************************ -->
  <div id="menu-2">
    <h3>Asociar orígenes de la mercancia</h3>

    <!-- Origins of the merchandise  -->
    <div class="form-group" id="origen-div">
      <br>
      <div class="help-block error-help-block" id='error_origen'></div>
      {!! Form::select('origenMercancia[]', ($origenMercancia), null, ['multiple'=>true,'class' => 'multi-select','id' => 'my-select', 'style' => 'position: absolute; left: -9999px;']) !!}
      
    </div>
    <!-- End Origins of the merchandise  -->

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente2" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras2" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>


  </div>
  <!-- ************************************ -->
  <!-- End Associate origins of the merchandise       -->
  <!-- ************************************ -->



  <!-- ************************************ -->
  <!-- Associate products                             -->
  <!-- ************************************ -->
  <div id="menu-3">
    <h3>Asociar productos</h3>

    <!-- Submit products -->
    <label  class="control-label">Productos de importación: (*)</label>
    <div class="form-group" id="producto-div">
      <div class="row">
        <div class="col-sm-10">
          {{ Form::text('imp_producto', '', ['class' => 'form-control', 'id' =>  'imp_producto', 'placeholder' =>  'Ingresar la referencia del producto'])}}
        </div>        
        <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando orden" onclick="autocompleteprod(this);">Agregar
        </button>      
      </div>
      <div class="help-block error-help-block has-error" id='error_producto'></div>
      <div class="col-sm-2">
      </div>
    </div>
    <!-- End Submit products -->

    <!-- Table of related products  -->

    <div class="form-group" id="ocultar2">
      <div class="portlet-body form">
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="tablaProducto" class="table table-hover">
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

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente3" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras3" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>

    <!-- end table of related products -->

  </div>  
  <!-- ************************************ -->
  <!-- End Associate products                         -->
  <!-- ************************************ -->


  <!-- ************************************ -->
  <!-- Associate proforma                             -->
  <!-- ************************************ -->
  <div id="menu-4">
    <h3>Asociar proformas</h3>

    <!-- Submit proforma -->
    <div class="form-group" id="proforma-div">
      <div class="row">
        <div class="col-sm-4">
          <label  class="control-label">No de proforma: (*)</label>
          {{ Form::text('imp_proforma', '', ['class' => 'form-control', 'id' =>  'imp_proforma', 'placeholder' =>  'Ingresar el numero de la proforma'])}}
        </div>
        <div class="col-sm-4">
          <label  class="control-label">Fecha creacion: (*)</label>
          {{ Form::text("fech_crea_profor", old("fech_crea_profor"), ['class' => 'form-control', 'id' =>  'fech_crea_profor', 'placeholder' =>  'Ingresar fecha de creacion de la proforma', 'readonly' =>  'readonly']) }}
        </div>
        <div class="col-sm-4">
          <label  class="control-label">Fecha entrega: (*)</label>
          {{ Form::text("fech_entreg_profor", old("fech_entreg_profor"), ['class' => 'form-control', 'id' =>  'fech_entreg_profor', 'placeholder' =>  'Ingresar fecha de entrega de la proforma', 'readonly' =>  'readonly']) }}
        </div>
      </div>
      <br><br>
      <div class="row">
        <div class="col-sm-4">
          <label  class="control-label">Valor proforma: (*)</label>
          {{ Form::number('val_proforma', '', ['class' => 'form-control', 'id' =>  'val_proforma', 'placeholder' =>  'Ingresar el valor de la proforma','min' => '1','max' => '999999999','step' => '0.01'])}}
        </div>
        <div class="col-sm-4">
          <label  class="control-label">Proforma principal: (*)</label>
          <div class="form-group">
            {{ Form::checkbox("proforma_principal", '1', null,  ['class' => 'field', 'id' => 'proforma_principal']) }}
          </div>
        </div>     
        <div class="col-sm-4">
          <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando proforma" onclick="tablaproforma(this);">Agregar
          </button>      
        </div>
      </div>
      <div class="form-group">
        <div class="help-block error-help-block has-error" id='error_proforma'></div>
      </div>

      <!-- End submit proforma -->

      <!-- Table of proformas -->
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
      <!-- End Table of proformas -->
    </div>


    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente4" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras4" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>

  </div>  
  <!-- ************************************ -->
  <!-- End Proforma                         -->
  <!-- ************************************ -->

  <!-- ************************************ -->
  <!-- Finalize creation                    -->
  <!-- ************************************ -->
  <div id="menu-5">
    <h3>Finalizar creación</h3>

    <!-- Observations -->
    <div class="form-group">
      {{ Form::label('', "Observaciones") }}
      {{ Form::textarea("imp_observaciones", old("imp_observaciones"), ['class' => 'form-control', 'id' =>  'imp_observaciones', 'placeholder' =>  'Ingresar la observacion de la orden de importacion', 'maxlength' => '250', 'rows' => '5']) }}
    </div>
    <!-- End Observations -->

    <!-- Delivery date total merchandise -->
    <div class="form-group">
      {{ Form::label('', "Fecha entrega total mercancia") }}
      {{ Form::text("imp_fecha_entrega_total", old("imp_fecha_entrega_total"), ['class' => 'form-control', 'id' =>  'imp_fecha_entrega_total', 'placeholder' =>  'Ingresar fecha de entrega total de la mercancia', 'readonly' =>  'readonly']) }}
    </div>
    <!-- End Delivery date total merchandise -->
    


    <div class="form-group">
      {{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary pull-right')) }}

      <a class="btn btn-default pull-left" id="atras5" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>

    

  </div>  
  <!-- ************************************ -->
  <!-- End Finalize creation                -->
  <!-- ************************************ -->


</div>
<!-- ************************************ -->
<!-- Menu with tabs                       -->
<!-- ************************************ -->

<input type="hidden" id="route2" value="{{route('searchProducto')}}">
@include('importacionesv2.importacionTemplate.modal')
<input type="hidden" id="productoajax" value="{{route('createproductoajax')}}">
<input type="hidden" id="productoGuarda" value="">
<input type="hidden" id="idguarda" value="">
<input type="hidden" id="tablaGuardar" value="" name="tablaGuardar">
<input type="hidden" id="tablaGuardarproforma" value="" name="tablaGuardarproforma">
<input type="hidden" id="tablaproformaguardar" value="" name="tablaproformaguardar">
{{ Form::close() }}

@endsection
