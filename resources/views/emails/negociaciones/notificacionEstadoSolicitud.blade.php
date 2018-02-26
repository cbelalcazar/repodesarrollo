@extends('emails.notificaciones')

<style>
  body {
    font-family: Arial, Helvetica, sans-serif !important;
    font-size: 15px !important;
  }
</style>

@section('content')

  @if ($objTSolEnvioNego['sen_ser_id'] == 2)   
    @if($objTSolEnvioNego['creacion'] == 'true')
      <p>Señor(a) <strong>{{$objTSolEnvioNego['terceroEnvia']['nombreTercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido1Tercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido2Tercero']}}</strong> ha creado la <strong>NEGOCIACIÓN No. {{$objTSolEnvioNego['sen_sol_id']}}</strong>.</p>
      <div class="form-group">
        <label><strong>Estado: </strong></label> En Solicitud
      </div>
      <p>Para ir al Aplicativo haga clic <a href="http://www.bellezaexpress.com/aplicativos">aqui</a>.</p>
    @else
      <p>El usuario <strong>{{$objTSolEnvioNego['terceroEnvia']['nombreTercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido1Tercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido2Tercero']}}</strong> ha creado la <strong>NEGOCIACIÓN No. {{$objTSolEnvioNego['sen_sol_id']}}</strong> la cual
      corresponde al cliente <strong>{{$objTSolEnvioNego['solicitud']['cliente']['razonSocialTercero_cli']}}</strong>.</p>
      <div class="form-group">
        <label><strong>Estado: </strong></label> Filtro
      </div>
      <div class="form-group">
        <label><strong>Observaciones: </strong></label>{{$objTSolEnvioNego['sen_observacion']}}
      </div>
      <div class="form-group">
        <label><strong>Forma de Pago: </strong></label>{{$objTSolEnvioNego['solicitud']['costo']['formaPago']['fpag_descripcion']}}
      </div>
      <p>Debe ingresar al sistema y realizar la aprobación de la negociación en menos de 24 horas.</p>
      <p>Para ir al Aplicativo haga clic <a href="http://www.bellezaexpress.com/aplicativos">aqui</a>.</p>

      <table class="subtexto" align="center" width="90%" cellpadding="5" cellspacing="0">
        @if ($objTSolEnvioNego['objetivo']['soo_ventmargilin'] < 0)
          <tr>
            <td align="left">
              <font color="red"><strong>ATENCIÓN: LA Venta Marginal por Líneas ES NEGATIVA</strong></font>
            </td>
            <td align="left">
              <font color="red"><strong>Resultado = {{$objTSolEnvioNego['objetivo']['soo_ventmargilin']}}</strong></font>
            </td>
          </tr>
        @endif

        @if ($objTSolEnvioNego['objetivo']['soo_ventamargi'] < 0)
          <tr>
            <td align="left">
              <font color="red"><strong>ATENCIÓN: LA Venta Marginal Cliente ES NEGATIVA</strong></font>
            </td>
            <td align="left">
              <font color="red"><strong>Resultado = {{$objTSolEnvioNego['objetivo']['soo_ventamargi']}}</strong></font>
            </td>
          </tr>
        @endif

        @if ($objTSolEnvioNego['objetivo']['soo_pinvermargi'] > 20)
          <tr>
            <td align="left">
              <font color="red"><strong>ATENCIÓN: El % de Inversión sobre la Venta Marginal Cliente Lineas es MAYOR al 20%</strong></font>
            </td>
            <td align="left">
              <font color="red"><strong>Resultado = {{$objTSolEnvioNego['objetivo']['soo_pinvermargi']}}</strong></font>
            </td>
          </tr>
        @endif

        @if ($objTSolEnvioNego['objetivo']['soo_pcrelin'] < 0)
          <tr>
            <td align="left">
              <font color="red"><strong>ATENCIÓN: El % de Crecimiento Obtenido Venta Lineas es NEGATIVO</strong></font>
            </td>
            <td align="left">
              <font color="red"><strong>Resultado = {{$objTSolEnvioNego['objetivo']['soo_pcrelin']}}</strong></font>
            </td>
          </tr>
        @endif

        @if ($objTSolEnvioNego['objetivo']['soo_pcreciestima'] < 0)
          <tr>
            <td align="left">
              <font color="red"><strong>ATENCION: El % de Crecimiento Obtenido Ventas Cliente es NEGATIVO</strong></font>
            </td>
            <td align="left">
              <font color="red"><strong>Resultado = {{$objTSolEnvioNego['objetivo']['soo_pcreciestima']}}</strong></font>
            </td>
          </tr>
        @endif
      </table>

      <div class="form-group">
        <label><strong>Tipo de Negociacion: </strong></label>
      </div>
      <br>
      <table cellspacing='3' cellpadding='3' width='100%' class='subtexto' align='left'>
        <thead>
          <tr>
            <th width='200' height='30' align='left'>Descripción</th>
            <th width='200' height='30' align='left'>Tipo Servicio</th>
            <th width='100' height='30' align='left'>Costo</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($objTSolEnvioNego['solicitud']['soliTipoNego'] as $datosTiposNego)
            <tr>
              <td height='30'>{{$datosTiposNego['tipoNego']['tin_descripcion']}}</td>
              <td height='30'>{{$datosTiposNego['tipoServicio']['ser_descripcion']}}</td>
              <td>{{number_format($datosTiposNego['stn_costo'], 2)}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <br>
      @if ($objTSolEnvioNego['solicitud']['sol_tipocliente'] == 1)
        <table class="subtexto" align="center" cellpadding="5" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th height="30" width="60%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Centro de Operacion</th>
              <th height="30" width="10%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">% Part.</th>
              <th height="30" width="10%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Valor</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($objTSolEnvioNego['solicitud']['soliZona'] as $datosZonas)
              <tr>
                <td height="30" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif;">
                  {{$datosZonas['hisZona']['cen_txt_descripcion']}}</td>
                <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif;">{{$datosZonas['szn_ppart']}}</td>
                <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif;">{{number_format(($datosZonas['szn_ppart']/100)*($objTSolEnvioNego['solicitud']['costo']['soc_granvalor']), 2)}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @elseif ($objTSolEnvioNego['solicitud']['sol_tipocliente'] == 2)
        <table class="subtexto" align="center" cellpadding="5" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th height="30" width="60%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Sucursal</th>
              <th height="30" width="10%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">% Part.</th>
              <th height="30" width="10%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Valor</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($objTSolEnvioNego['solicitud']['soliSucu'] as $datosSucus)
              <tr>
                <td height="30" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif;">
                  {{$datosSucus['hisSucu']['suc_txt_nombre']}}</td>
                <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif;">{{$datosSucus['ssu_ppart']}}</td>
                <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif;">{{number_format(($datosSucus['ssu_ppart']/100)*($objTSolEnvioNego['solicitud']['costo']['soc_granvalor']), 2)}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif

      <br>
      <table class="subtexto" align="center" cellpadding="5" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Costo Con Cliente</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Costo Adicional</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Iva</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">ReteFuente</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">ReteIca</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">ReteIva</th>
            <th height="30" width="20%" align="left" style="font: bold 11px verdana, arial, helvetica, sans-serif; background: #4F81BD; color: white;">Valor Neto Cliente</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_valornego'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_granvalor'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_iva'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_retefte'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_reteica'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_reteiva'], 2)}}</td>
            <td height="30" align="right" style="font: bold 11px verdana, arial, helvetica, sans-serif; background-color: #D0D8E8;">{{number_format($objTSolEnvioNego['solicitud']['costo']['soc_total'], 2)}}</td>
          </tr>
        </tbody>
      </table>
    @endif

  @elseif ($objTSolEnvioNego['sen_ser_id'] == 8)
    <!-- Correcciones -->

  @elseif ($objTSolEnvioNego['sen_ser_id'] == 9)
    <!-- Anulaciones -->

  @else
      
      <p>El usuario <strong>{{$objTSolEnvioNego['terceroEnvia']['nombreTercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido1Tercero']}} {{$objTSolEnvioNego['terceroEnvia']['apellido2Tercero']}}</strong> ha aprobado la <strong>NEGOCIACIÓN No. {{$objTSolEnvioNego['sen_sol_id']}}</strong> la cual
        corresponde al cliente <strong>
        {{$objTSolEnvioNego['solicitud']['cliente']['razonSocialTercero_cli']}}</strong>.</p>
      
      <div class="form-group">
        <label><strong>Estado: </strong></label>{{$objTSolEnvioNego['estadoHisProceso']['ser_descripcion']}}
      </div>
      <div class="form-group">
        <label><strong>Observacisdsdsdones: </strong></label> {{$objTSolEnvioNego['sen_observacion']}}
      </div>
      <div class="form-group">
        <label><strong>Forma de Pago: </strong></label> {{$objTSolEnvioNego['solicitud']['costo']['formaPago']['fpag_descripcion']}}
      </div>
      @if($objTSolEnvioNego['verificar'] == null)
        <p>Debe ingresar al sistema y realizar la aprobación de la negociación en menos de 24 horas.</p>
      @elseif($objTSolEnvioNego['verificar'] == 'evaluacion')
        <p>Esta solicitud ya tiene todas las aprobaciones. Pendiente por Evaluación</p>
      @endif
      
      <p>Para ir al Aplicativo haga clic <a href="http://www.bellezaexpress.com/aplicativos">aqui</a>.</p>

  @endif




@endsection
