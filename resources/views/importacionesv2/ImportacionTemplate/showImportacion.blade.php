@extends('importacionesv2.ImportacionTemplate.titulosbase')
@section('generic')
<!-- ************************************ -->
<!-- /************************************
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 *****************************************
 *****************************************/ -->


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



<div class="panel panel-primary">
  <div class="panel-heading">Importacion:   {{$object->imp_consecutivo}} </div>
  <div class="panel-body">


    <div class="row"> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Razon social proveedor: </strong>{{$object->proveedor->razonSocialTercero}}</label>
      </div>  
      <div class="col-sm-2">
        <label  class="control-label"><strong>Nit proveedor: </strong>{{$object->proveedor->nitTercero}}</label>
      </div> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Puerto de embarque: </strong>{{$object->puerto_embarque->puem_nombre}}</label>
      </div> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>inconterm: </strong><br>{{$object->inconterm->inco_descripcion}}</label>
      </div> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Moneda negociación: </strong>{{$object->imp_moneda_negociacion}}</label>
      </div> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Fecha entrega total: </strong>{{$object->imp_fecha_entrega_total}}</label>
      </div> 
    </div>
    <br>

    <div class="row"> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Observaciones: </strong>{{$object->imp_observaciones}}</label>
      </div>  
      <div class="col-sm-2">
        <label  class="control-label"><strong>Estado: </strong><br>{{$object->estado->est_nombre}}</label>
      </div>
      <div class="col-sm-2">
        <label  class="control-label"><strong>Productos: </strong>
          <ul class="list-group">
            @foreach($tablaProductos as $key => $value)
            <li class="">{{$value[0]}}</li>
            @endforeach
          </ul>
        </label>
      </div>  
      <div class="col-sm-2">
        <label  class="control-label"><strong>Origenes: </strong>
          <ul class="list-group">
            @foreach($objeto2 as $key => $value)
            <li class="">{{$value->origenes[0]->ormer_nombre}}</li>
            @endforeach
          </ul>
        </label>
      </div>  
      <div class="col-sm-2">
        <label  class="control-label"><strong>Proformas: </strong>
          <ul class="list-group">
            @foreach($objeto4 as $key => $value)
            <li class="">{{$value->prof_numero}}</li>
            @endforeach
          </ul>
        </label>
      </div>  
    </div>

  </div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">Embarque:  {{$object->imp_consecutivo}}</div>
  <div class="panel-body">
    <div class="row"> 
      <div class="col-sm-2">
        <label  class="control-label"><strong>Embarcador: </strong>{{$objeto5[0]->embarcador->razonSocialTercero}} -- {{$objeto5[0]->embarcador->nitTercero}}</label>
      </div>   
      <div class="col-sm-2">
        <label  class="control-label"><strong>Linea maritima: </strong>{{$objeto5[0]->lineamaritima->razonSocialTercero}} -- {{$objeto5[0]->lineamaritima->nitTercero}}</label>
      </div>    
      <div class="col-sm-2">
        <label  class="control-label"><strong>Tipo carga: </strong><br>{{$objeto5[0]->tipoCarga->tcar_descripcion}}</label>
      </div>
      <div class="col-sm-2">
        <label  class="control-label"><strong>Fecha ETD: </strong><br>{{$objeto5[0]->emim_fecha_etd}}</label>
      </div>    
      <div class="col-sm-2">
        <label  class="control-label"><strong>Fecha ETA: </strong><br>{{$objeto5[0]->emim_fecha_eta}}</label>
      </div>      
      <div class="col-sm-2">
        <label  class="control-label"><strong>No. documento transporte: </strong><br>{{$objeto5[0]->emim_documento_transporte}}</label>
      </div>    

    </div>
    <br>
    <div class="row"> 
     <div class="col-sm-2">
      <label  class="control-label"><strong>Valor flete: </strong><br>{{$objeto5[0]->emim_valor_flete}}</label>
    </div>    

    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha recibido documentos originales: </strong><br>{{$objeto5[0]->emim_fecha_recibido_documentos_ori}}</label>
    </div>   

    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha de envio a la aduana: </strong><br>{{$objeto5[0]->emim_fecha_envio_aduana}}</label>
    </div>   

    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha de envio ficha tecnica: </strong><br>{{$objeto5[0]->emim_fecha_envio_ficha_tecnica}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Aduana: </strong><br>{{$objeto5[0]->aduana->razonSocialTercero}} -- {{$objeto5[0]->aduana->nitTercero}}</label>
    </div> 

    <div class="col-sm-2">
      <label  class="control-label"><strong>Transportador: </strong><br>{{$objeto5[0]->transportador->razonSocialTercero}} -- {{$objeto5[0]->transportador->nitTercero}}</label>
    </div> 
  </div>
  <br>

  <div class="row"> 
   <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha de solicitud de la reserva: </strong><br>{{$objeto5[0]->emim_fecha_solicitud_reserva}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha de confirmacion de la reserva: </strong><br>{{$objeto5[0]->emim_fecha_confirm_reserva}}</label>
  </div> 
</div>

<br>
</div>
</div>



<div class="panel panel-primary">
  <div class="panel-heading">Pagos:  {{$object->imp_consecutivo}}</div>
  <div class="panel-body">

   <div class="row"> 
     <div class="col-sm-2">
      <label  class="control-label"><strong>Valor anticipo: </strong><br>{{$objeto6[0]->pag_valor_anticipo}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Valor saldo: </strong><br>{{$objeto6[0]->pag_valor_saldo}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Valor comision: </strong><br>{{$objeto6[0]->pag_valor_comision}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>valor total: </strong><br>{{$objeto6[0]->pag_valor_total}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>valor FOB: </strong><br>{{$objeto6[0]->pag_valor_fob}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>fecha factura: </strong><br>{{$objeto6[0]->pag_fecha_factura}}</label>
    </div> 
  </div>
  <br>
  <div class="row"> 
   <div class="col-sm-2">
    <label  class="control-label"><strong>trm liquidacion factura: </strong><br>{{$objeto6[0]->trm_liquidacion_factura}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha envio a contabilidad: </strong><br>{{$objeto6[0]->pag_fecha_envio_contabilidad}}</label>
  </div> 
</div>

</div>
</div>


<div class="panel panel-primary">
  <div class="panel-heading">Nacionalizacion y costeo:  {{$object->imp_consecutivo}}</div>
  <div class="panel-body">

   <div class="row"> 
     <div class="col-sm-2">
      <label  class="control-label"><strong>Anticipo aduana: </strong><br>{{$objeto7[0]->naco_anticipo_aduana}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha anticipo anticipo aduana: </strong><br>{{$objeto7[0]->naco_fecha_anticipo_aduana}}</label>
    </div> 
    <div class="col-sm-2">
      @if($objeto7[0]->naco_preinscripcion == 1)
      <label  class="control-label"><strong>Preinscripcion: </strong><br>SI</label>
      @elseif($objeto7[0]->naco_preinscripcion == 0)
      <label  class="control-label"><strong>Preinscripcion: </strong><br>NO</label>
      @endif

    </div> 
    <div class="col-sm-2">
      @if($objeto7[0]->naco_control_posterior == 1)
      <label  class="control-label"><strong>Control posterior: </strong><br>SI</label>
      @elseif($objeto7[0]->naco_control_posterior == 0)
      <label  class="control-label"><strong>Control posterior: </strong><br>NO</label>
      @endif
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha recibo factura Belleza Express: </strong><br>{{$objeto7[0]->naco_fecha_recibo_fact_be}}</label>
    </div> 
    <div class="col-sm-2">
      <label  class="control-label"><strong>Fecha entrega factura a contabilidad: </strong><br>{{$objeto7[0]->naco_fecha_entrega_fact_cont}}</label>
    </div> 
  </div>
  <br>


  <div class="row"> 
   <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha entrega documentos transportador: </strong><br>{{$objeto7[0]->naco_fecha_entrega_docu_transp}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha retiro puerto: </strong><br>{{$objeto7[0]->naco_fecha_retiro_puert}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha de envio comex: </strong><br>{{$objeto7[0]->naco_fecha_envio_comex}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha de llegada a Belleza Express: </strong><br>{{$objeto7[0]->naco_fecha_llegada_be}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha recepcion lista de empaque: </strong><br>{{$objeto7[0]->naco_fecha_recep_list_empaq}}</label>
  </div> 
  <div class="col-sm-2">
    <label  class="control-label"><strong>Fecha envio liquidación y costeo: </strong><br>{{$objeto7[0]->naco_fecha_envi_liqu_costeo}}</label>
  </div> 
</div>
<br>

<div class="row"> 
 <div class="col-sm-2">
  <label  class="control-label"><strong>Fecha entrada al sistema: </strong><br>{{$objeto7[0]->naco_fecha_entrada_sistema}}</label>
</div> 
<div class="col-sm-2">
  @if($objeto6[0]->naco_sobrante)
  <label  class="control-label"><strong>Sobrante: </strong><br>{{$objeto7[0]->naco_sobrante}}</label>
  @elseif($objeto6[0]->naco_faltante)
  <label  class="control-label"><strong>Faltante: </strong><br>{{$objeto7[0]->naco_faltante}}</label>
  @endif
</div> 
<div class="col-sm-2">
  <label  class="control-label"><strong>Factor dolar porcentaje: </strong><br>{{$objeto7[0]->naco_factor_dolar_porc}}%</label>
</div> 
<div class="col-sm-2">
  <label  class="control-label"><strong>Factor dolar tasa: </strong><br>{{$objeto7[0]->naco_factor_dolar_tasa}}</label>
</div> 
<div class="col-sm-2">
  <label  class="control-label"><strong>Factor logistico porcentaje: </strong><br>{{$objeto7[0]->naco_factor_logist_porc}}%</label>
</div> 
<div class="col-sm-2">
  <label  class="control-label"><strong>Factor logistico tasa: </strong><br>{{$objeto7[0]->naco_factor_logist_tasa}}</label>
</div> 
</div>
<br>

<div class="row"> 
 <div class="col-sm-2">
  <label  class="control-label"><strong>Tipo nacionalización: </strong><br>{{$objeto7[0]->naco_tipo_nacionalizacion}}</label>
</div> 

</div>

<br>

</div>
</div>
@if($object->imp_estado_proceso != 6)
{{ Form::open(array('url' => route('cerrarImportacion'))) }}
<input type="hidden" name="OrdenId" value="{{$object->id}}">
<div class="form-group">
  <button type="submit" class="btn btn-large btn-block btn-primary" onclick="">CERRAR ORDEN DE IMPORTACION</button>
</div>
{{ Form::close() }}
@endif


@endsection
