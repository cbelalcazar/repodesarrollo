@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')


<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2/embarque.js')}}" type="text/javascript" language="javascript"></script>


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
<input type="hidden" name="emim_importacion" value="{{$idImportacion}}">
<div id="tabs">
  <ul>
    <li><a id="menu1" href="#menu-1">Datos basicos</a></li>
    <li><a id="menu2" href="#menu-2">Tipo de carga</a></li>
    <li><a id="menu3" href="#menu-3">Fechas</a></li>
    <li><a id="menu4" href="#menu-4">Finalizar embarque</a></li>
  </ul>

  <!-- ************************************ -->
  <!-- Basic data                           -->
  <!-- ************************************ -->
  <div id="menu-1">
    <h3>Datos basicos</h3>
    
    <!-- Embarcador -->
    <div class="form-group"  id="embarcador_div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Embarcador: (*)") }}
      {{ Form::text('emim_embarcador', '', ['class' => 'form-control validemos', 'id' =>  'emim_embarcador', 'placeholder' =>  'Ingresar nombre o nit del embarcador'])}}
      <div class="help-block error-help-block" id='error_embarcador'></div>

      {{ Form::label('', "") }}
      {{ Form::text('razonsocialembarcador', '', ['class' => 'form-control', 'id' =>  'razonsocialembarcador', 'readonly' =>  'readonly'])}}
      <input type="hidden" id="route1" value="{{route('search')}}">
    </div>
    <!-- End Embarcador -->

    <!-- Linea maritima -->
    <div class="form-group" id="linea_div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Linea maritima: (*)") }}
      {{ Form::text('emim_linea_maritima', '', ['class' => 'form-control validemos', 'id' =>  'emim_linea_maritima', 'placeholder' =>  'Ingresar nombre o nit de la linea maritima'])}}
      <div class="help-block error-help-block" id='error_lineamaritima'></div>

      {{ Form::label('', "") }}
      {{ Form::text('razonsociallinea', '', ['class' => 'form-control', 'id' =>  'razonsociallinea', 'readonly' =>  'readonly'])}}
    </div>
    <!-- End Linea maritima -->



    <!-- Agencia de aduanas -->
    <div class="form-group" id="agencia_div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Agencia de aduanas: (*)") }}
      {{ Form::text('emim_aduana', '', ['class' => 'form-control validemos', 'id' =>  'emim_aduana', 'placeholder' =>  'Ingresar nombre o nit de la agencia de aduanas'])}}
      <div class="help-block error-help-block" id='error_agencia'></div>

      {{ Form::label('', "") }}
      {{ Form::text('razonsocialaduana', '', ['class' => 'form-control', 'id' =>  'razonsocialaduana', 'readonly' =>  'readonly'])}}
    </div>
    <!-- End Agencia de aduanas -->


    <!-- Embarcador -->
    <div class="form-group" id="transportador_div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "Transportador: (*)") }}
      {{ Form::text('emim_transportador', '', ['class' => 'form-control validemos', 'id' =>  'emim_transportador', 'placeholder' =>  'Ingresar nombre o nit de la agencia de aduanas'])}}
      <div class="help-block error-help-block" id='error_transportador'></div>

      {{ Form::label('', "") }}
      {{ Form::text('razonsocialtransportador', '', ['class' => 'form-control', 'id' =>  'razonsocialtransportador', 'readonly' =>  'readonly'])}}
    </div>
    <!-- End Embarcador -->

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente1" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
    <br><br>

  </div>
  <!-- ************************************ -->
  <!-- End Basic data                       -->
  <!-- ************************************ -->


  <!-- ************************************ -->
  <!-- Basic data                           -->
  <!-- ************************************ -->
  <div id="menu-2">
    <h3>Tipo de carga</h3>
    
    <!-- Port of shipment -->
    <div class="form-group" id="tipo_carga_div">
      <label>Tipo de carga: (*)</label>
      {{ Form::select('emim_tipo_carga', $tipocarga, null, ['placeholder' => 'Selecciona un tipo de carga...', 'class' => 'form-control validemos', 'id' => 'emim_tipo_carga']) }} 
      <div class="help-block error-help-block" id='error_tipocarga'></div>
      <div class="help-block error-help-block has-error" id='errorgenerado'></div>
    </div>

    <div class="form-group" id="formTipocarga">
    </div>

    <!-- Table of proformas -->
    <div class="form-group" id="ocultar1">
      <div class="portlet-body form">
        @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="tablaContenedor" class="table table-hover">
          <!-- Aqui se generan los titulos de la tabla-->
          <thead>
            <tr>
              <td>Tipo Contenedor</td>
              <td>Cantidad</td>          
              <td>No. importacion</td>
              <td>Cubicaje</td>
              <td>Peso</td>
              <td>Eliminar</td>
            </tr>
          </thead>
          <tbody id="agregar">
          </tbody>
        </table>
      </div>
    </div>
    <!-- End Port of shipment -->

    <div class="form-group">
      <a class="btn btn-default pull-right" id="siguiente2" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

      <a class="btn btn-default pull-left" id="atras2" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
    </div>
    <br><br>

  </div>
  <!-- End Embarcador -->

  <!-- ************************************ -->
  <!-- Basic data                           -->
  <!-- ************************************ -->
  <div id="menu-3">
    <h3>Fechas</h3>
    

    <div class="row">
      <div class="col-sm-6" id="etd_div">
       <label  class="control-label">Fecha ETD: (*)</label>
       {{ Form::text("emim_fecha_etd", old("emim_fecha_etd") ? old("emim_fecha_etd") : $imp_fechaentregatotal, ['class' => 'form-control validemos', 'id' =>  'emim_fecha_etd', 'placeholder' =>  'Ingresar fecha del ETD', 'readonly' =>  'readonly']) }}
       <div class="help-block error-help-block" id='error_etd'></div>
     </div>     
     <div class="col-sm-6" id="eta_div">
      <label  class="control-label">Fecha ETA: (*)</label>
      {{ Form::text("emim_fecha_eta", old("emim_fecha_eta") ? old("emim_fecha_eta") : $imp_fechaentregatotal, ['class' => 'form-control validemos', 'id' =>  'emim_fecha_eta', 'placeholder' =>  'Ingresar fecha del ETA', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_eta'></div>
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-sm-6" id="fechrecb_div">
      <label  class="control-label">Fecha de recibido de documentos originales: (*)</label>
      {{ Form::text("emim_fecha_recibido_documentos_ori", old("emim_fecha_recibido_documentos_ori"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_recibido_documentos_ori', 'placeholder' =>  'Ingresar fecha de recibido documentos originales', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechrecb'></div>
    </div>
    <div class="col-sm-6" id="fechenvadu_div">
      <label  class="control-label">Fecha de envio documentos a agencia de aduanas: (*)</label>
      {{ Form::text("emim_fecha_envio_aduana", old("emim_fecha_envio_aduana"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_envio_aduana', 'placeholder' =>  'Ingresar fecha de envio documentos aduana', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechrecb'></div>
    </div>
  </div>
  <br>


  <div class="row" id="fechenvfich_div">
    <div class="col-sm-6">
      <label  class="control-label">Fecha de envio ficha tecnica: (*)</label>
      {{ Form::text("emim_fecha_envio_ficha_tecnica", old("emim_fecha_envio_ficha_tecnica"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_envio_ficha_tecnica', 'placeholder' =>  'Ingresar fecha de envio ficha tecnica', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechenvfich'></div>
    </div>
    <div class="col-sm-6" id="fechenvlistemp_div">
      <label  class="control-label">Fecha de envio lista de empaque: (*)</label>
      {{ Form::text("emim_fecha_envio_lista_empaque", old("emim_fecha_envio_lista_empaque"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_envio_lista_empaque', 'placeholder' =>  'Ingresar fecha de envio ficha tecnica', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechenvlistemp'></div>
    </div>
  </div>
  <br>



  <div class="row">
    <div class="col-sm-6" id="fechsolicreser_div">
      <label  class="control-label">Fecha solicitud de la reserva: (*)</label>
      {{ Form::text("emim_fecha_solicitud_reserva", old("emim_fecha_solicitud_reserva"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_solicitud_reserva', 'placeholder' =>  'Ingresar fecha solicitud de la reserva', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechsolicreser'></div>
    </div>
    <div class="col-sm-6" id="fechconfirreser_div">
      <label  class="control-label">Fecha confirmación de la reserva: (*)</label>
      {{ Form::text("emim_fecha_confirm_reserva", old("emim_fecha_confirm_reserva"), ['class' => 'form-control validemos', 'id' =>  'emim_fecha_confirm_reserva', 'placeholder' =>  'Ingresar fecha de confirmacion de la reserva
      ', 'readonly' =>  'readonly']) }}
      <div class="help-block error-help-block" id='error_fechconfirreser'></div>
    </div>
  </div>
  <div class="form-group">
    <a class="btn btn-default pull-right" id="siguiente3" role="button">Siguiente   <span class="glyphicon glyphicon-chevron-right"></span></a>

    <a class="btn btn-default pull-left" id="atras3" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
  </div>
  <br><br><br>

</div>

<!-- End Embarcador -->


<!-- ************************************ -->
<!-- Basic data                           -->
<!-- ************************************ -->
<div id="menu-4">
  <h3>Finalizar embarque</h3>
  <!-- Consecutive import  -->
  <div class="form-group" id="doctranspor_div">
    {{ Form::label('', "Documento de transporte: (*)") }}
    {{ Form::text("emim_documento_transporte", old("emim_documento_transporte"), ['class' => 'form-control validemos', 'id' =>  'emim_documento_transporte', 'placeholder' =>  'Ingresar el numero de documento de transporte','maxlength' => '200']) }}
    <div class="help-block error-help-block" id='error_doctranspor'></div>
  </div>
  <!-- End Consecutive import    -->

  <!-- Consecutive import  -->
  <div class="form-group" id="valorflete_div">
    {{ Form::label('', "Valor de flete: (*)") }}
    {{ Form::text("emim_valor_flete", old("emim_valor_flete"), ['class' => 'form-control validemos', 'id' =>  'emim_valor_flete', 'placeholder' =>  'Ingresar el valor del flete','maxlength' => '10']) }}
    <div class="help-block error-help-block" id='error_valorflete'></div>
  </div>
  <!-- End Consecutive import    -->

<input type="hidden" name="infoTipoContenedor" id="infoTipoContenedor" value="{{ $contenedores }}">
<input type="hidden" name="tablaContenedorGuardar" id="tablaContenedorGuardar" value="">
  <div class="form-group">
  {{ Form::submit('Crear Nueva', array('class' => 'btn btn-primary pull-right', 'id' => 'finalizar1')) }}

    <a class="btn btn-default pull-left" id="atras4" role="button"><span class="glyphicon glyphicon-chevron-left">   Atras</span></a>
  </div>
  <br><br>

</div>
<!-- End Embarcador -->


</div>
<!-- ************************************ -->
<!-- Menu with tabs                       -->
<!-- ************************************ -->






<script>
  $('#tabs').tabs()
</script>

{{ Form::close() }}

@endsection
