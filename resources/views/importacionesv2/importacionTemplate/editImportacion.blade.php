@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<!-- /**
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */ -->
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



{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT',  'id' => 'Formularioupdate1')) }}

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
      {{ Form::label('', "Consecutivo de creacion") }}
      {{ Form::text("imp_consecutivo", old("imp_consecutivo"), ['class' => 'form-control validemos', 'id' =>  'imp_consecutivo', 'placeholder' =>  'Ingresar el consecutivo de creacion','maxlength' => '250']) }}
      <div class="help-block error-help-block" id='error_imp_consecutivo'></div>
    </div>
    <input type="hidden" name="{{$objeto->id}}" id="identificador" value="{{$objeto->id}}">
    <!-- End Consecutive import    -->

    <!-- Provider -->
    <div class="form-group"  id="proveedor-div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Busqueda de proveedor") }}
      {{ Form::text('imp_proveedor', old("imp_proveedor"), ['class' => 'form-control validemos', 'id' =>  'proveedor', 'placeholder' =>  'Ingresar nombre o nit del proveedor'])}}
      <div class="help-block error-help-block" id='error_proveedor'></div>
      {{ Form::label('', "") }}
      {{ Form::text('razonSocialTercero', $objeto->proveedor->razonSocialTercero, ['class' => 'form-control', 'id' =>  'razonSocialTercero', 'readonly' =>  'readonly'])}}
      <input type="hidden" id="route1" value="{{route('search')}}">
    </div>
    <!-- End Provider -->

    <!-- Port of shipment -->
    <div class="form-group" id="puerto-div">
      <div class="row">
        <div class="col-xs-12">
          <label  class="control-label">Puerto de embarque</label>
          <div class="input-group add-on">
            {{ Form::select('imp_puerto_embarque', $puertos, null, ['placeholder' => 'Selecciona un puerto de embarque...', 'class' => 'form-control  validemos', 'id' => 'imp_puerto_embarque']) }}
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
    <div class="form-group"  id="inconterm-div">
      <div class="row">
        <div class="col-xs-12">
          <label class="control-label">Inconterm</label>
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
      {{ Form::label('', "Moneda negociación") }}
      {{ Form::select('imp_moneda_negociacion', ['COP' => 'PESOS', 'EUR' => 'EURO', 'USD' => 'DOLARES'], null, ['placeholder' => 'Selecciona una moneda...', 'class' => 'form-control  validemos']) }}
      <div class="help-block error-help-block" id='error_moneda'></div>
    </div>
    <!-- End Currency trading -->

    <!-- End Currency trading -->

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
  <div id="menu-2" id="origen-div">
    <h3>Asociar orígenes de la mercancia</h3>
    <div class="form-group">
      <div class="help-block error-help-block" id='error_origen'></div>
      {!! Form::select('origenMercancia[]', $origenMercancia, $seleccionados, ['multiple'=>true,'class' => 'multi-select','id' => 'my-select', 'style' => 'position: absolute; left: -9999px;']) !!}
    </div>

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente2" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras2" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>

    <input type="hidden" id="route2" value="{{route('searchProducto')}}">
  </div>
  <!-- ************************************ -->
  <!-- End Associate origins of the merchandise       -->
  <!-- ************************************ -->



  <!-- ************************************ -->
  <!-- Associate products                             -->
  <!-- ************************************ -->
  <div id="menu-3">
    <h3>Asociar productos</h3>

    <label  class="control-label">Productos de importacion</label>
    <div class="form-group" id="producto-div">
      <div class="row">

        <div class="col-xs-10">

          {{ Form::text('imp_producto', '', ['class' => 'form-control', 'id' =>  'imp_producto', 'placeholder' =>  'Ingresar la referencia del producto'])}}
        </div>

        <div class="col-xs-2">
          <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando orden" onclick="autocompleteprod(this);">Consultar
          </button>      
        </div>
        <div class="help-block error-help-block has-error" id='error_producto'></div>
      </div>
    </div>


    <!-- Table of related products  -->
    <div class="form-group">
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
            @if($tablaProductos)
            @foreach($tablaProductos as $key => $infoProducto)
            <tr>

              <td class="campos" id="{{$key+1}}">{{ $infoProducto[0] }}<input type="hidden" name="{{$key+1}}" value='{{$infoProducto[0]}}'></td>
              <td id="{{$key+1}}-decl" >{{ $infoProducto[1] }}<input type="hidden" name="{{$key+1}}-decl"  value="{{$infoProducto[1]}}"></td>
              <td id="{{$key+1}}-reg" >{{ $infoProducto[2] }}<input type="hidden" name="{{$key+1}}-reg"  value="{{$infoProducto[2]}}"></td>
              <td><span id="{{$infoProducto[3]}}" onclick="borrarprodimp(this);" class=" glyphicon glyphicon-remove"></span><input type="hidden" name="{{$key+1}}-idproducto" value="{{$infoProducto[3]}}"></td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <input type="hidden" id="urlborrar" value="{{$urlBorrar}}">

    <!-- end table of related products -->

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente3" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras3" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>



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
          {{ Form::text('val_proforma', '', ['class' => 'form-control solo-numero', 'id' =>  'val_proforma', 'placeholder' =>  'Ingresar el valor de la proforma','min' => '1','max' => '999999999','step' => '0.01'])}}
        </div>
        <div class="col-xs-4">

          <label  class="control-label">Proforma principal:</label>
          <div class="form-group">
            {{ Form::checkbox("proforma_principal", '1', null,  ['class' => 'field', 'id' => 'proforma_principal']) }}
          </div>

        </div>

        <div class="col-xs-4">
          <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando proforma" onclick="tablaproforma(this);">Agregar
          </button>      
        </div>
      </div>
      <div class="form-group">
        <div class="help-block error-help-block has-error" id='error_proforma'></div>
      </div>
      <!-- End submit proforma -->

      <!-- Table of proformas -->
      <div class="form-group" id="">
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
             @if($tablaProformas)
             @foreach($tablaProformas as $key1 => $infoProforma)
             <tr>
              <td class="campos" id="{{$key1+1}}-prof">{{ $infoProforma[0] }}<input type="hidden" name="{{$key1+1}}-noprof" value='{{$infoProforma[0]}}'></td>

              <td>{{ \Carbon\Carbon::parse($infoProforma[1])->format('d-m-Y') }}<input type="hidden" name="{{$key1+1}}-creaprof" value='{{$infoProforma[1]}}'></td>

              <td>{{  \Carbon\Carbon::parse($infoProforma[2])->format('d-m-Y') }}<input type="hidden" name="{{$key1+1}}-entregaprof" value='{{$infoProforma[2]}}'></td>
              <td>{{ $infoProforma[3] }}<input type="hidden" name="{{$key1+1}}-valorprof" value='{{$infoProforma[3]}}'></td>
              <td>{{ $infoProforma[4] }}<input type="hidden" name="{{$key1+1}}-princprof" value='{{$infoProforma[4]}}'></td>
              <td><span  id="{{$infoProforma[5]}}" onclick="borrarproforma(this);" class=" glyphicon glyphicon-remove"></span><input type="hidden" name="{{$key1+1}}-idproforma" value="{{$infoProforma[5]}}"></td>
            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <input type="hidden" id="urlborrarprof" value="{{$urlBorrarProforma}}">

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
    @if($objeto->imp_fecha_entrega_total != null)
    {{ Form::text("imp_fecha_entrega_total", \Carbon\Carbon::parse(old("imp_fecha_entrega_total"))->format('d-m-Y'), ['class' => 'form-control', 'id' =>  'imp_fecha_entrega_total', 'placeholder' =>  'Ingresar fecha de entrega total de la mercancia', 'readonly' =>  'readonly']) }}
    @else
    {{ Form::text("imp_fecha_entrega_total", "", ['class' => 'form-control', 'id' =>  'imp_fecha_entrega_total', 'placeholder' =>  'Ingresar fecha de entrega total de la mercancia', 'readonly' =>  'readonly']) }}
    @endif
  </div>
  <!-- End Delivery date total merchandise -->

  <div class="form-group">
    @if($hasPerm == 1)
    {{ Form::submit('Editar', array('class' => 'btn btn-primary  pull-right' )) }}
    @endif
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


@include('importacionesv2.importacionTemplate.modal')
<input type="hidden" id="productoajax" value="{{route('createproductoajax')}}">
<input type="hidden" id="productoGuarda" value="">
<input type="hidden" id="idguarda" value="">
<input type="hidden" id="tablaGuardar" value="" name="tablaGuardar">
<input type="hidden" id="tablaGuardarproforma" value="" name="tablaGuardarproforma">
<input type="hidden" id="tablaproformaguardar" value="" name="tablaproformaguardar">
{{ Form::close() }}

@endsection
