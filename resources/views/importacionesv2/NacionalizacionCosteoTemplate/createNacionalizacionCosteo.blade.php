@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')


<link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
<link href="{{url('/css/font-awesome.min.css')}}" type="text/css" rel="stylesheet"/>
<script src="{{url('/js/importacionesv2/pago.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/bootstrap-toggle.min.js')}}" type="text/javascript" language="javascript"></script>
<link href="{{url('/css/bootstrap-toggle.min.css')}}" type="text/css" rel="stylesheet"/>

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
  {{ Form::select('naco_tipo_importacion', $naco_tipo_importacion, null, ['placeholder' => 'Selecciona un tipo  de importación...', 'class' => 'form-control validemosText', 'id' => 'naco_tipo_importacion']) }}
  <div class="help-block error-help-block" id='error'></div><br>
</div>   

<!-- Currency trading -->


<div class="col-sm-6">
  <div class="col-sm-6">
    <br>{{ Form::label('', "Preinspeccion: (*)") }}<br>
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

<!-- Submit proforma -->

  <div class="form-group col-sm-12 panel panel-default" id="declaracion-div">
  <h4>Asociar declaraciones de importación</h4>
  <br>
   <div class="row">
    <div class="col-sm-3">
      <label  class="control-label">No de declaracion: (*)</label>
      {{ Form::text('decl_numero', '', ['class' => 'form-control', 'id' =>  'decl_numero', 'placeholder' =>  'Ingresar el numero de declaracion de importacion'])}}
    </div>
    <div class="col-sm-3">
      <label  class="control-label">Numero de sticker: (*)</label>
      {{ Form::text("decl_sticker", old("decl_sticker"), ['class' => 'form-control', 'id' =>  'decl_sticker', 'placeholder' =>  'Ingresar el numero de sticker']) }}
    </div>
    <div class="col-sm-3">
      <label  class="control-label">Arancel: (*)</label>
      {{ Form::number("decl_arancel", old("decl_arancel"), ['class' => 'form-control', 'id' =>  'decl_arancel', 'placeholder' =>  'Ingresar el arancel de importacion','min' => '0','max' => '999999999','step' => '0.01']) }}
    </div>
    <div class="col-sm-3">
      <label  class="control-label">Iva: (*)</label>
      {{ Form::number("decl_iva", old("decl_iva"), ['class' => 'form-control', 'id' =>  'decl_iva', 'placeholder' =>  'Ingresar el iva','min' => '0','max' => '999999999','step' => '0.01']) }}
    </div>
  </div>
  <br><br>
  <div class="row">

    <div class="col-sm-3">
      <label  class="control-label">Valor otros: (*)</label>
      {{ Form::number("decl_valor_otros", old("decl_valor_otros"), ['class' => 'form-control', 'id' =>  'decl_valor_otros', 'placeholder' =>  'Ingresar el valor otros','min' => '0','max' => '999999999','step' => '0.01']) }}
    </div>  
    <div class="col-sm-3">
      <label  class="control-label">Valor TRM: (*)</label>
      {{ Form::number("decl_trm", old("decl_trm"), ['class' => 'form-control', 'id' =>  'decl_trm', 'placeholder' =>  'Ingresar el valor de la TRM', 'min' => '0','max' => '999999999','step' => '0.01']) }}
    </div>  
    <div class="col-sm-3">
      {{ Form::label('', "Tipo levante: (*)") }}
      {{ Form::select('decl_tipo_levante', $decl_tipo_levante, null, ['placeholder' => 'Selecciona una tipo  de levante...', 'class' => 'form-control', 'id' => 'decl_tipo_levante']) }}
    </div>   
    <!-- Combobox administracion dian -->
    <div class="col-sm-3">
      {{ Form::label('', "Administracion dian: (*)") }}
      {{ Form::select('decl_admin_dian', $decl_admin_dian, null, ['placeholder' => 'Selecciona una administración dian...', 'class' => 'form-control', 'id' => 'decl_admin_dian']) }}
      <div class="help-block error-help-block" id='error'></div><br>
    </div>   

  </div>
  <br>
  <div class="row">
    <!-- Combobox tipo levante -->

    <!-- Valor fecha envio a contabilidad  -->
    <div class="col-sm-3">
      {{ Form::label('', "Fecha aceptacion: (*)") }}
      {{ Form::text("decl_fecha_aceptacion", old("decl_fecha_aceptacion"), ['class' => 'form-control datepickerClass', 'id' =>  'decl_fecha_aceptacion', 'placeholder' =>  'Ingresar la fecha de aceptacion','readonly' => 'readonly','required' => 'required']) }}
      <div class="help-block error-help-block" id='error'></div>
    </div>
    <div class="col-sm-3">
      {{ Form::label('', "Fecha levante: (*)") }}
      {{ Form::text("decl_fecha_levante", old("decl_fecha_levante"), ['class' => 'form-control datepickerClass', 'id' =>  'decl_fecha_levante', 'placeholder' =>  'Ingresar la fecha de levante','readonly' => 'readonly','required' => 'required']) }}
      <div class="help-block error-help-block" id='error'></div>
    </div>
    <div class="col-sm-3">
      {{ Form::label('', "Fecha de legalizacion: (*)") }}
      {{ Form::text("decl_fecha_legaliza_giro", old("decl_fecha_legaliza_giro"), ['class' => 'form-control datepickerClass', 'id' =>  'decl_fecha_legaliza_giro', 'placeholder' =>  'Ingresar la fecha de legalizacion','readonly' => 'readonly','required' => 'required']) }}
      <div class="help-block error-help-block" id='error'></div>
    </div>
    <div class="col-sm-3">
      <br>
      <button type="button" class="btn btn-primary " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Procesando declaracion" onclick="tabladeclaracion(this);">Agregar
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
      <table id="tabladeclaracion" class="table table-hover">
        <!-- Aqui se generan los titulos de la tabla-->
        <thead>
          <tr>
            <td>No. de declaracion</td>
            <td>No. Sticker:</td>          
            <td>Arancel:</td>
            <td>Iva:</td>
            <td>Valor otros:</td>
            <td>Valor TRM</td>
            <td>Tipo levante</td>
            <td>Administracion dian</td>
            <td>Fecha aceptación</td>
            <td>Fecha levante</td>
            <td>Fecha legalizacion</td>
            <td>Borrar</td>
            <td>Actualizar</td>
          </tr>
        </thead>
        <tbody id="añadir2">
        </tbody>
      </table>
    </div>
  </div>
  <!-- End Table of proformas -->
</div>
<input type="hidden" name="tabladeclaracionguardar" id="tabladeclaracionguardar" value="">

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
  {{ Form::label('', "Fecha retiro puerto / Aeropuerto: (*)") }}
  {{ Form::text("naco_fecha_retiro_puert", old("naco_fecha_retiro_puert"), ['class' => 'form-control validemosText validemosDate datepickerClass', 'id' =>  'naco_fecha_retiro_puert', 'placeholder' =>  'Ingresar la fecha de retiro puerto / aeropuerto','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->


<!-- Valor anticipo  -->
<div class="col-sm-6">
  {{ Form::label('', "Valor anticipo a la agencia de aduanas: (*)") }}
  {{ Form::number("naco_anticipo_aduana", old("naco_anticipo_aduana"), ['class' => 'form-control', 'id' =>  'naco_anticipo_aduana', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor anticipo    -->
<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  {{ Form::label('', "Fecha de anticipo agencia de aduanas: (*)") }}
  {{ Form::text("naco_fecha_anticipo_aduana", old("naco_fecha_anticipo_aduana"), ['class' => 'form-control datepickerClass', 'id' =>  'naco_fecha_anticipo_aduana', 'placeholder' =>  'Ingresar fecha del anticipo agencia de aduanas','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->
<!-- numero comex  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "No. Comex: (*)") }}
  {{ Form::text("naco_numero_comex", old("naco_numero_comex"), ['class' => 'form-control', 'id' =>  'naco_numero_comex', 'placeholder' =>  'Ingresar el numero de comex']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<br><br>
<!-- End numero comex -->
<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de envio comex: (*)") }}
  {{ Form::text("naco_fecha_envio_comex", old("naco_fecha_envio_comex"), ['class' => 'form-control  datepickerClass', 'id' =>  'naco_fecha_envio_comex', 'placeholder' =>  'Ingresar fecha de envio comex','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de llegada a Belleza Express: (*)") }}
  {{ Form::text("naco_fecha_llegada_be", old("naco_fecha_llegada_be"), ['class' => 'form-control datepickerClass', 'id' =>  'naco_fecha_llegada_be', 'placeholder' =>  'Ingresar la fecha de llegada a Belleza Express','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de recepción lista de empaque + Ciego: (*)") }}
  {{ Form::text("naco_fecha_recep_list_empaq", old("naco_fecha_recep_list_empaq"), ['class' => 'form-control datepickerClass', 'id' =>  'naco_fecha_recep_list_empaq', 'placeholder' =>  'Ingresar la fecha de recepción lista de empaque','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de envio liquidación y costeo: (*)") }}
  {{ Form::text("naco_fecha_envi_liqu_costeo", old("naco_fecha_envi_liqu_costeo"), ['class' => 'form-control datepickerClass', 'id' =>  'naco_fecha_envi_liqu_costeo', 'placeholder' =>  'Ingresar la fecha de envio lista de empaque de empaque','readonly' => 'readonly']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- End Valor fecha envio a contabilidad     -->

<!-- Valor fecha envio a contabilidad  -->
<div class="col-sm-6">
  <br>
  {{ Form::label('', "Fecha de entrada al sistema: (*)") }}
  {{ Form::text("naco_fecha_entrada_sistema", old("naco_fecha_entrada_sistema"), ['class' => 'form-control datepickerClass', 'id' =>  'naco_fecha_entrada_sistema', 'placeholder' =>  'Ingresar la fecha de entrada al sistema','readonly' => 'readonly']) }}
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
    {{ Form::radio("naco_opcion", 'sobrante', null , ['id' => 'sobrante']) }}
    {{ Form::label('', "Sobrante") }}  
  </div>
  <div class="col-sm-3 hide radios1">
    <br>
    {{ Form::radio("naco_opcion", 'faltante', null , ['id' => 'faltante']) }}
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
      $('#sobrante').prop('checked', false);
      $('#faltante').prop('checked', false);
      $('.cajas1').addClass('hide');
    }
    
  });
  $('#sobrante').click(function(event) {
    $('.cajas1').removeClass('hide');
  });
  $('#faltante').click(function(event) {
    $('.cajas1').removeClass('hide');
  });


</script>


<!-- Valor anticipo  -->
<div class="col-sm-12 hide cajas1">
  <br>
  {{ Form::label('', "Valor ajuste: (*)") }}
  {{ Form::number("naco_valorseleccion", old("naco_valorseleccion"), ['class' => 'form-control', 'id' =>  'naco_valorseleccion', 'placeholder' =>  'Ingresar el valor del anticipo a la agencia de aduanas','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<br><br>

<div class="col-sm-12 hide cajas1">
  <br>
  {{ Form::label('', "Valor ajuste Euros: (*)") }}
  {{ Form::number("naco_valorseleccion_euro", old("naco_valorseleccion_euro"), ['class' => 'form-control', 'id' =>  'naco_valorseleccion_euro', 'placeholder' =>  'Ingresar el valor del ajuste en euros','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<br><br>

<div class="col-sm-6"><br>
  {{ Form::label('', "Factor total: (*)") }}
  {{ Form::number("naco_factor_dolar_tasa", old("naco_factor_dolar_tasa"), ['class' => 'form-control', 'id' =>  'naco_factor_dolar_tasa', 'placeholder' =>  'Ingresar el factor total','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- Valor anticipo  -->
<div class="col-sm-6"><br>
  {{ Form::label('', "Factor total porcentual: (*)") }}
  {{ Form::number("naco_factor_dolar_porc", old("naco_factor_dolar_porc"), ['class' => 'form-control', 'id' =>  'naco_factor_dolar_porc', 'placeholder' =>  'Ingresar el factor total porcentual','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>


<div class="col-sm-6"><br>
  {{ Form::label('', "Factor logistico: (*)") }}
  {{ Form::number("naco_factor_logist_tasa", old("naco_factor_logist_tasa"), ['class' => 'form-control', 'id' =>  'naco_factor_logist_tasa', 'placeholder' =>  'Ingresar el factor logistico','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- Valor anticipo  -->
<div class="col-sm-6"><br>
  {{ Form::label('', "Factor logistico en pesos: (*)") }}
  {{ Form::number("naco_factor_logist_porc", old("naco_factor_logist_porc"), ['class' => 'form-control', 'id' =>  'naco_factor_logist_porc', 'placeholder' =>  'Ingresar el factor logistico en pesos','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>
<!-- Valor anticipo  -->
<div class="col-sm-6"><br>
  {{ Form::label('', "Factor arancel: (*)") }}
  {{ Form::number("naco_factor_arancel_porc", old("naco_factor_arancel_porc"), ['class' => 'form-control', 'id' =>  'naco_factor_arancel_porc', 'placeholder' =>  'Ingresar el factor arancel','min' => '0','max' => '999999999','step' => '0.01']) }}
  <div class="help-block error-help-block" id='error'></div>
</div>


<!-- End Valor anticipo    -->
<!-- End Valor fecha envio a contabilidad     -->
<div class="col-sm-12">
  <br>
  {{ Form::submit('Crear', array('class' => 'btn btn-primary pull-right', 'id' => 'finalizar1')) }}
</div>
{{ Form::close() }}
@endsection
