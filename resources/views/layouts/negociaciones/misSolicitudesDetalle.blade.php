<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog"  style="width: 70% !important;" role="document">
    <div class="modal-content panel-primary">
      <!--Titulo del modal-->
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detalle de Negociación</h4>
      </div>
      <!--Fin Titulo del modal-->
      <div class="modal-body">
        <!--Encabezado del modal-->
        <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-6">
              <ul class="list-group">
                <li class="list-group-item">
                  <label>Cliente: </label> @{{infoSolicitud.cliente.razonSocialTercero_cli}}
                </li>
                <li class="list-group-item">
                  <label>Fecha de solicitud: </label> @{{infoSolicitud.sol_fecha}}
                </li>
              </ul>
            </div>
            <div class="col-sm-6">
              <ul class="list-group">
                <li class="list-group-item">
                  <label>Pendiente gestion de: </label> @{{pendienteGestion}}
                </li>
                <li class="list-group-item">
                  <label>Ultimo proceso realizado: </label> @{{ultimoProceso[0].estado_his_proceso.ser_descripcion}}
                </li>           
              </ul>
            </div>
          </div>
          <!--Fin Encabezado del modal-->
          <hr>
          <!--Empiezan las pestañas del modal-->
          <md-tabs md-dynamic-height md-border-bottom>
            <!--Pestaña No.1 His. Proceso-->
            <md-tab label="His. Proceso">
              <md-content class="md-padding">
                <div class="table-responsive" style="font-size: 11px;">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Fecha Envio</th>
                        <th>Estado</th>
                        <th>Usuario Envia</th>
                        <th>Usuario Recibe</th>
                        <th>Observaciones</th>
                      </tr>
                    </thead>
                    <!--Ingresar informacion historica de la solicitud-->
                    <tbody>
                      <tr ng-if="infoSolicitud.his_proceso.length != 0" ng-repeat="historico in infoSolicitud.his_proceso | orderBy:'-sen_fechaenvio'">
                        <td>@{{historico.sen_fechaenvio}}</td>
                        <td>@{{historico.estado_his_proceso.ser_descripcion}}</td>
                        <td>@{{historico.tercero_envia.razonSocialTercero}}</td>
                        <td>@{{historico.tercero_recibe.razonSocialTercero}}</td>
                        <td>@{{historico.sen_observacion}}</td>
                      </tr>
                      <tr ng-if="infoSolicitud.his_proceso.length == 0">
                          <td colspan="11" align="center">No se encontraron registros en Historial de la Solicitud
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.2 Info. Solicitud-->
            <md-tab label="Info. Solicitud" md-active="reset == true" md-on-deselect="resetTab()">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    <!--Creacion de tabla con la informacion basica de la solicitud-->
                    <ul class="list-group">
                      <div class="col-sm-6">
                        <li class="list-group-item">
                          <label>No. Negociación: </label> @{{infoSolicitud.sol_id}}
                        </li>
                        <li class="list-group-item">
                          <label>Fecha de solicitud: </label> @{{infoSolicitud.sol_fecha}}
                        </li>
                        <li class="list-group-item">
                          <label>Cliente: </label> @{{infoSolicitud.cliente.razonSocialTercero_cli}}
                        </li>
                        <li class="list-group-item">
                          <label>Canal: </label> @{{infoSolicitud.canal.can_txt_descrip}}
                        </li>
                        <li class="list-group-item">
                          <label>Lista de Precios: </label> @{{infoSolicitud.lista_precios.lis_txt_descrip}}
                        </li>
                        <li class="list-group-item">
                          <label>Periodo de Facturación: </label> @{{infoSolicitud.sol_peri_facturaini}} a @{{infoSolicitud.sol_peri_facturafin}}
                        </li>
                        <li class="list-group-item">
                          <label>Clase: </label> @{{infoSolicitud.sol_clase == '1' ? 'Negocio' : 'Evento'}}
                        </li>
                        <li class="list-group-item">
                          <label>Negociación Año Anterior: </label> @{{infoSolicitud.sol_huella_capitalizar = '1' ? 'Huella Año Anterior' : infoSolicitud.sol_huella_capitalizar = '2' ? 'Capitalizar Oportunidad' : 'SIN NEGOCIACION AÑO ANTERIOR'}}
                        </li>
                        <li class="list-group-item">
                          <label>Tipo de Negociación: </label> @{{infoSolicitud.sol_tipo == '1' ? 'Por Resultados' : infoSolicitud.sol_tipo == '2' ? 'Real' : 'SIN TIPO'}}
                        </li>
                        <li class="list-group-item">
                          <label>Revision de Acta en Auditoria: </label> @{{infoSolicitud.sol_llegoacta == '1' ? 'Si' : 'Pendiente'}}
                        </li>
                        <li class="list-group-item">
                          <label>Periodo de Ejecución: </label> @{{infoSolicitud.sol_peri_ejeini | date:'yyyy-MM-dd'}} a @{{infoSolicitud.sol_peri_ejefin | date:'yyyy-MM-dd'}}
                        </li>
                      </div>
                      <div class="col-sm-6">
                        <li class="list-group-item">
                          <label>Estado: </label> @{{infoSolicitud.estado.ser_descripcion}}
                        </li>
                        <li class="list-group-item">
                          <label>Vendedor: </label> @{{infoSolicitud.vendedor.razonSocialTercero}}
                        </li>
                        <li class="list-group-item">
                          <label>NIT: </label> @{{infoSolicitud.cliente.ter_id}}
                        </li>
                        <li class="list-group-item">
                          <label>Descuento Comercial: </label> @{{infoSolicitud.cliente.cli_txt_dtocome | currency : "" : 0}}%
                        </li>
                        <li class="list-group-item">
                          <label>Zona: </label> @{{infoSolicitud.zona.zon_txt_descrip}}
                        </li>
                        <li class="list-group-item">
                          <label>Meses: </label> @{{infoSolicitud.sol_mesesfactu}}
                        </li>
                        <li class="list-group-item">
                          <label>Clasificación: </label> @{{infoSolicitud.sol_clasificacion == '1' ? 'Mercadeo' : infoSolicitud.sol_clasificacion == '2' ? 'Comercial' : infoSolicitud.sol_clasificacion == '3' ? 'Comercial - Mercadeo' : 'SIN CLASIFICACIÓN'}}
                        </li>
                        <li class="list-group-item">
                          <label>Zona: </label> @{{infoSolicitud.sol_ppresupuestozona}}
                        </li>
                        <li class="list-group-item">
                          <label>Canal: </label> @{{infoSolicitud.sol_ppresupuestocanal}}
                        </li>           
                        <li class="list-group-item">
                          <label>Mercadeo: </label> @{{infoSolicitud.sol_ppresupuestomerca}}
                        </li>
                        <li class="list-group-item">
                          <label>Meses: </label> @{{infoSolicitud.sol_meseseje}}
                        </li>
                      </div>
                      <div class="col-sm-12">
                        <li class="list-group-item">
                          <label>Asociada a: </label> @{{infoSolicitud.evento.evt_descripcion == null ? 'SIN ASOCIADO' : infoSolicitud.evento.evt_descripcion}}
                        </li>   
                        <li class="list-group-item">
                          <label>Observaciones: </label> @{{infoSolicitud.sol_observaciones}}
                        </li>
                      </div>
                    </ul>
                  </div>
                  <br>
                  <!--Creacion de paneles-->
                  <!--Panel No. 1-->
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-9">Centro Operación</div>
                        <div class="col-md-3">Part.</div>
                      </div> 
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="(infoSolicitud.soli_zona.length == 0) && (infoSolicitud.soli_sucu.length == 0)">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div ng-if="infoSolicitud.sol_tipocliente == 1" class="row" ng-repeat="centroOperacion in infoSolicitud.soli_zona">
                        <div class="col-md-8">@{{centroOperacion.szn_coc_id}} - @{{centroOperacion.his_zona.c_operacion.cen_txt_descripcion}}</div>
                        <div class="col-md-2" align="right">@{{centroOperacion.szn_ppart}} %</div>
                        <div class="col-md-2"></div>
                      </div>
                      <div ng-if="infoSolicitud.sol_tipocliente == 2" class="row" ng-repeat="centroOperacion in infoSolicitud.soli_sucu">
                        <div class="col-md-8">@{{centroOperacion.his_sucu.suc_num_codigo}}-@{{centroOperacion.his_sucu.suc_txt_nombre}} (@{{centroOperacion.his_sucu.suc_txt_direccion}})</div>
                        <div class="col-md-2" align="right">@{{centroOperacion.ssu_ppart}} %</div>
                        <div class="col-md-2"></div>
                      </div>
                    </div>
                  </div>
                  <label>Tipo de Negociación</label>
                  <!--Panel No.2-->
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-9">Descripción</div>
                        <div class="col-md-3" align="center">Costo</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="infoSolicitud.soli_tipo_nego.length == 0">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div class="row" ng-repeat="tipoNego in infoSolicitud.soli_tipo_nego">
                        <div class="col-md-9">@{{tipoNego.tipo_nego.tin_descripcion}}</div>
                        <div class="col-md-2" align="right">@{{tipoNego.stn_costo | currency : "$" : 2}}</div>
                        <div class="col-md-1"></div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-1" align="right"><label>Total:</label></div>
                        <div class="col-md-2" align="right"><label>@{{infoSolicitud.soli_tipo_nego | map : 'stn_costo' | sum | currency : "$" : 2}}</label></div>
                        <div class="col-sm-1"></div>
                      </div>
                    </div>
                  </div>
                  <label>Causales de Negociación</label>
                  <!--Panel No.3-->
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-9">Descripción</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="infoSolicitud.causal.length == 0">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div class="row" ng-repeat="tipoCausal in infoSolicitud.causal">
                        <div class="col-md-9">@{{tipoCausal.causal_detalle.can_descripcion}}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.3 Info. Costos-->
            <md-tab label="Info. Costos">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    <!--Creacion de tabla No.1-->
                    <ul class="list-group">  
                        <li class="list-group-item">
                          <div class="row">
                            <div class="col-md-8"><label>Valor Negociación Cliente:</label></div>
                            <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_valornego | currency : "$" : 2}}</div>
                            <div class="col-md-2"></div>
                          </div>
                        </li>
                        <li class="list-group-item">
                          <div class="row">
                            <div class="col-md-8"><label>Gran TOTAL con Adicionales:</label></div>
                            <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_granvalor | currency : "$" : 2}}</div>
                            <div class="col-md-2"></div>
                          </div>
                        </li>
                        <li class="list-group-item">
                          <div class="row">
                            <div class="col-md-7"><label>Forma de Pago Pactada:</label></div>
                            <div class="col-md-3" align="right">@{{infoSolicitud.costo.soc_formapago == '1' ? 'Pago Directo' : infoSolicitud.costo.soc_formapago == '2' ? 'Cruce de Cuentas' : infoSolicitud.costo.soc_formapago == '3' ? 'Pago con Bono - ' + infoSolicitud.costo.tipo_bono.bono.tib_descripcion : 'FORMA DE PAGO NO ASIGNADA'}}</div>
                          </div>
                          <div class="col-md-2"></div>   
                        </li>
                      <hr>
                      <!--Creacion de tabla No.2-->
                      <label><font color="red">Impuestos Calculados (Informativo)</font></label>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-8"><label>IVA:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_iva | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-8"><label>SubTotal Cliente:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_subtotalcliente | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-8"><label>ReteFTE:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_retefte | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-8"><label>ReteICA:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_reteica | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-8"><label>ReteIVA:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_reteiva | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">                  
                        <div class="row">
                          <div class="col-md-8"><label>Total Cliente Despues Impuestos:</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.costo.soc_total | currency : "$" : 2}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <hr>
                  <!--Creacion de panel No.1-->
                  <label>Lineas de Negociación</label>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-3">Categoria</div>
                        <div class="col-md-4">Linea</div>
                        <div class="col-md-1">Part.</div>
                        <div class="col-md-2">Costo en Nego.</div>
                        <div class="col-md-2">Costo Adicional</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="infoSolicitud.costo.lineas.length == 0">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div class="row" ng-repeat="linea in infoSolicitud.costo.lineas">
                        <div class="col-md-3">@{{linea.scl_cat_id}} - @{{linea.lineas_detalle.categorias.cat_txt_descrip}}</div>
                        <div class="col-md-4">@{{linea.scl_lin_id}} - @{{linea.lineas_detalle.lin_txt_descrip}}</div>
                        <div class="col-md-1" align="right">@{{linea.scl_ppart}} %</div>
                        <div class="col-md-2" align="right">@{{linea.scl_costo | currency : "$" : 2}}</div>
                        <div class="col-md-2" align="right">@{{linea.scl_costoadi | currency : "$" : 2}}</div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-1"><label>Total:</label></div>
                        <div class="col-md-1" align="right"><label>100 %</label></div>
                        <div class="col-md-2" align="right"><label>@{{infoSolicitud.costo.lineas | map : 'scl_costo' | sum | currency : "$" : 2}}</label></div>
                        <div class="col-md-2" align="right"><label>@{{infoSolicitud.costo.lineas | map : 'scl_costoadi' | sum | currency : "$" : 2}}</label></div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <!--Creacion de panel No.2-->
                  <label>Costos Adicionales</label>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-5">Motivo</div>
                        <div class="col-md-3">Valor</div>
                        <div class="col-md-4">Mostrar</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="infoSolicitud.costo.motivo.length == 0">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div class="row" ng-if="infoSolicitud.costo.motivo.length != 0" ng-repeat="mot in infoSolicitud.costo.motivo">
                        <div class="col-md-5">@{{mot.mot_adicion.mta_descripcion}}</div>
                        <div class="col-md-3" align="right">@{{mot.sca_valor | currency : "$" : 2}}</div>
                        <div class="col-md-4">@{{mot.sca_mostrar == '1' ? 'SI' : 'NO'}}</div>
                      </div>
                    </div>
                    <div class="panel-footer" ng-if="infoSolicitud.costo.motivo.length != 0">
                      <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-1"><label>Total:</label></div>
                        <div class="col-md-3" align="right"><label>@{{infoSolicitud.costo.motivo | map : 'sca_valor' | sum | currency : "$" : 2}}</label></div>
                        <div class="col-md-4"></div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <!--Creacion de panel No.3-->
                  <label>Detalle Valores Adicionales</label>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-9">Detalle</div>
                        <div class="col-md-3">Valor</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="infoSolicitud.costo.detalle == null">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div class="row" ng-if="infoSolicitud.costo.detalle != null">
                        <div class="col-md-8">@{{infoSolicitud.costo.detalle.scd_detalle}}</div>
                        <div class="col-md-1">Total: </div>
                        <div class="col-md-3">@{{infoSolicitud.costo.detalle.scd_valor | currency : "$" : 2}}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>       
            <!--Pestaña No.4 Info. Objetivos-->
            <md-tab label="Info. Objetivos">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    <!--Primer panel de la pestaña-->
                    <div class="panel panel-danger">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12" align="center">Datos de Evaluación</div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <!--Informacion correspondiente a la parte izquierda del panel-->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Periodo de Comparación</label></div>
                              <div class="col-md-5 text-right" ng-if="((infoSolicitud.objetivo.soo_pecomini != null) && (infoSolicitud.objetivo.soo_pecomfin != null))">@{{infoSolicitud.objetivo.soo_pecomini}} a @{{infoSolicitud.objetivo.soo_pecomfin}}</div>
                              <div class="col-md-5 text-right" ng-if="((infoSolicitud.objetivo.soo_pecomini == null) || (infoSolicitud.objetivo.soo_pecomfin == null))">SIN INFORMACIÓN</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Periodo de Facturación</label></div>
                              <div class="col-md-5 text-right">@{{infoSolicitud.sol_peri_facturaini}} a @{{infoSolicitud.sol_peri_facturafin}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Costo de la Negociación</label></div>
                              <div class="col-md-5 text-right">@{{infoSolicitud.objetivo.soo_costonego | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Venta Promedio Mes Lineas Periodo Comparación</label></div>
                              <div class="col-md-5 text-right">@{{infoSolicitud.objetivo.soo_venpromeslin == null ? 0 : infoSolicitud.objetivo.soo_venpromeslin | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Estimada Lineas</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_venestlin == null ? 0 : infoSolicitud.objetivo.soo_venestlin | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Marginal Lineas</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventmargilin == null ? 0 : infoSolicitud.objetivo.soo_ventmargilin | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <!--Informacion correspondiente a la parte derecha del panel-->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Meses</label></div>
                              <div class="col-md-5" align="right" ng-if="infoSolicitud.objetivo.soo_mese != null">@{{infoSolicitud.objetivo.soo_mese}}</div>
                              <div class="col-md-5" align="right" ng-if="infoSolicitud.objetivo.soo_mese == null">SIN INFORMACIÓN</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>Meses</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.sol_mesesfactu}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% de Inversión sobre la venta Estimada Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pinventaestiline == null ? 0 : infoSolicitud.objetivo.soo_pinventaestiline | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Lineas a Activar (ult 6 meses)</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_venprolin6m == null ? 0 : infoSolicitud.objetivo.soo_venprolin6m | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% Crecimiento Estimado Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pcrelin == null ? 0 : infoSolicitud.objetivo.soo_pcrelin | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% de Inversión sobre la Venta Marginal Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pvenmarlin == null ? 0 : infoSolicitud.objetivo.soo_pvenmarlin | number:2}} %</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Segundo panel de la pestaña-->
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-6">Linea</div>
                            <div class="col-md-3" align="right">Valor Venta</div>
                            <div class="col-md-3" align="right">Part.</div>
                          </div>
                        </div>
                      </div>
                      <div class="panel-body">
                      <!--Recorrer el arreglo para mostrar la informacion referente a las lineas-->
                        <div class="row">
                          <div class="col-md-12" ng-repeat="line in infoSolicitud.costo.lineas">
                            <div class="col-md-6">@{{line.scl_lin_id}} - @{{line.lineas_detalle.lin_txt_descrip}}</div>
                            <div class="col-md-3 text-right">@{{line.scl_valorventa | currency : "$" : 2}}</div>
                            <div class="col-md-3 text-right">@{{line.scl_pvalorventa | number:2}} %</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Tercer panel de la pestaña-->
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12" align="center">Datos Informativos Total Cliente</div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <!--Informacion correspondiente a la parte izquierda del panel-->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Total Cliente Periodo Comparación</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventapromtotal == null ? 0 : infoSolicitud.objetivo.soo_ventapromtotal | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <!--Informacion correspondiente a la parte derecha del panel-->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Total Cliente (ult 6 meses)</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventapromseisme == null ? 0 : infoSolicitud.objetivo.soo_ventapromseisme | currency : "$" : 2}}</div>
                            </div>
                          </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="col-md-7"><label>% Crecimiento Estimado Cliente</label></div>
                                <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_pcreciestima == null ? 0 : infoSolicitud.objetivo.soo_pcreciestima | number:2}} %</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Venta Estimada del Total Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventaestitotal == null ? 0 : infoSolicitud.objetivo.soo_ventaestitotal | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Marginal Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventamargi == null ? 0 : infoSolicitud.objetivo.soo_ventamargi | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>% Inversión sobre la Venta Estimada Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_pinverestima == null ? 0 : infoSolicitud.objetivo.soo_pinverestima | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>% Inversión sobre la Venta Marginal Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_pinvermargi == null ? 0 : infoSolicitud.objetivo.soo_pinvermargi | number:2}} %</div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <hr>
                            <div class="row">
                              <div class="col-md-2"><label>Observaciones</label></div>
                              <div class="col-md-10">@{{infoSolicitud.objetivo.soo_observacion == null ? 'SIN OBSERVACIONES' : infoSolicitud.objetivo.soo_observacion}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Cuarto panel de la pestaña-->
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12" align="center">Datos Informativos Lineas No Incluidas</div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="col-md-4">
                              <div class="col-md-8"><label>Venta 1 Mes Antes periodo Comparación</label></div>
                              <div class="col-md-4">@{{infoSolicitud.objetivo.soo_vemesantes == null ? 0 : infoSolicitud.objetivo.soo_vemesantes | currency : "$" : 2}}</div>
                            </div>
                            <div class="col-md-4">
                              <div class="col-md-8"><label>Venta Promedio Mes periodo Comparación</label></div>
                              <div class="col-md-4">@{{infoSolicitud.objetivo.soo_veprome == null ? 0 : infoSolicitud.objetivo.soo_veprome | currency : "$" : 2}}</div>
                            </div>
                            <div class="col-md-4">
                              <div class="col-md-8"><label>Venta 1 Mes Despues periodo Comparación  </label></div>
                              <div class="col-md-4">@{{infoSolicitud.objetivo.soo_vemesdespues == null ? 0 : infoSolicitud.objetivo.soo_vemesdespues | currency : "$" : 2}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel-footer">
                        <div class="row">
                          <div class="col-md-8"></div>
                          <div class="col-md-2"><label>Variación</label></div>
                          <div class="col-md-2" text-align: right><label>@{{variacionObj == null ? 0 : variacionObj | number:2}} %</label></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.5 Info. Eval. Real (Esta pestaña solo se muestra si 
              el estado final de la solicitud es 6)-->
            <md-tab label="Info. Eval. Real" ng-if="infoSolicitud.sol_sef_id == 6">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    <!--Primer panel de la pestaña-->
                    <div class="panel panel-danger">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12" align="center">Datos de Evaluación (Venta Real, Costo Real)</div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-6">
                            <!--Informacion correspondiente a la parte izquierda del panel-->
                            <div class="row">
                              <div class="col-md-6" align="left"><label>Periodo de Comparación</label></div>
                              <div class="col-md-6 text-right" ng-if="((infoSolicitud.objetivo.soo_pecomini != null) && (infoSolicitud.objetivo.soo_pecomfin != null))">@{{infoSolicitud.objetivo.soo_pecomini}} a @{{infoSolicitud.objetivo.soo_pecomfin}}</div>
                              <div class="col-md-6 text-right" ng-if="((infoSolicitud.objetivo.soo_pecomini == null) || (infoSolicitud.objetivo.soo_pecomfin == null))">SIN INFORMACIÓN</div>
                            </div>
                            <div class="row">
                              <div class="col-md-6" align="left"><label>Periodo de Facturación</label></div>
                              <div class="col-md-6 text-right">@{{infoSolicitud.sol_peri_facturaini}} a @{{infoSolicitud.sol_peri_facturafin}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Costo Real Negociación (Verif. Cobro)</label></div>
                              <div class="col-md-5 text-right">@{{infoSolicitud.verificacion_cobro | map : 'svc_valorbruto' | sum | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7" align="left"><label>Venta Promedio Mes Lineas Periodo Comparación</label></div>
                              <div class="col-md-5 text-right">@{{infoSolicitud.objetivo.soo_venpromeslin == null ? 0 : infoSolicitud.objetivo.soo_venpromeslin | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Real Lineas</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.cumplimiento.scu_venreallineas == null ? 0 : infoSolicitud.cumplimiento.scu_venreallineas | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Marginal Lineas</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventmargilinReal == null ? 0 : infoSolicitud.objetivo.soo_ventmargilinReal | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!--Informacion correspondiente a la parte derecha del panel-->
                            <div class="row">
                              <div class="col-md-7"><label>Meses</label></div>
                              <div class="col-md-5" align="right" ng-if="infoSolicitud.objetivo.soo_mese != null">@{{infoSolicitud.objetivo.soo_mese}}</div>
                              <div class="col-md-5" align="right" ng-if="infoSolicitud.objetivo.soo_mese == null">SIN INFORMACIÓN</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>Meses</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.sol_mesesfactu}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% de Inversión sobre la venta Real Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pinventaestilineReal == null ? 0 : infoSolicitud.objetivo.soo_pinventaestilineReal | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Lineas a Activar (ult 6 meses)</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_venprolin6m == null ? 0 : infoSolicitud.objetivo.soo_venprolin6m | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% Crecimiento Estimado Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pcrelinReal == null ? 0 : infoSolicitud.objetivo.soo_pcrelinReal | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-9"><label>% de Inversión sobre la Venta Marginal Lineas</label></div>
                              <div class="col-md-3" align="right">@{{infoSolicitud.objetivo.soo_pvenmarlinReal == null ? 0 : infoSolicitud.objetivo.soo_pvenmarlinReal | number:2}} %</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Segundo panel de la pestaña-->
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-12" align="center">Datos Informativos Total Cliente</div>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-6">
                            <!--Informacion correspondiente a la parte izquierda del panel-->
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Total Cliente Periodo Comparación</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventapromtotal == null ? 0 : infoSolicitud.objetivo.soo_ventapromtotal | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Venta Promedio Mes Total Cliente (ult 6 meses)</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventapromseisme == null ? 0 : infoSolicitud.objetivo.soo_ventapromseisme | currency : "$" : 2}}</div>
                            </div>
                          </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="col-md-7"><label>% Crecimiento Real Cliente</label></div>
                                <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_pcreciestima == null ? 0 : infoSolicitud.objetivo.soo_pcreciestima | number:2}} %</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-7"><label>Venta Real del Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventatotalcliente == null ? 0 : infoSolicitud.objetivo.soo_ventatotalcliente | currency : "$" : 2}}</div>
                            </div>
                            <div class="row">
                              <div class="col-md-7"><label>Venta Marginal Cliente</label></div>
                              <div class="col-md-5" align="right">@{{infoSolicitud.objetivo.soo_ventamargiReal == null ? 0 : infoSolicitud.objetivo.soo_ventamargiReal | currency : "$" : 2}}</div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!--Informacion correspondiente a la parte derecha del panel-->
                            <div class="row">
                              <div class="col-md-8"><label>% Inversión sobre la Venta Real Cliente</label></div>
                              <div class="col-md-4" align="right">@{{infoSolicitud.objetivo.soo_pinverestimaReal == null ? 0 : infoSolicitud.objetivo.soo_pinverestimaReal | number:2}} %</div>
                            </div>
                            <div class="row">
                              <div class="col-md-8"><label>% Inversión sobre la Venta Real Marginal Cliente</label></div>
                              <div class="col-md-4" align="right">@{{infoSolicitud.objetivo.soo_pinvermargiReal == null ? 0 : infoSolicitud.objetivo.soo_pinvermargiReal | number:2}} %</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.6 Evaluación-->
            <md-tab label="Evaluación">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">  
                    <ul class="list-group">  
                      <li class="list-group-item">
                        <!--Informacipon Fecha de facturación de la solicitud-->
                        <div class="row">
                          <div class="col-md-6"><label>Fecha de Facturación</label></div>
                          <div class="col-md-4" align="right">@{{infoSolicitud.sol_peri_facturaini}} a @{{infoSolicitud.sol_peri_facturafin}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <hr>
                      <!--Creacion de la Informacion A, consolidada en la primera tabla-->
                      <label>CALIFICACIÓN FINANCIERA</label>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"></div>
                          <div class="col-md-2" align="right"><label>Valor</label></div>
                          <div class="col-md-2" align="left"><label>¿Cumplio?</label></div>
                          <div class="col-md-5"><label>Observaciones</label></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>Venta Real</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.cumplimiento.scu_venreallineas | currency : "$" : 2}}</div>
                          <div class="col-md-2" align="left">@{{infoSolicitud.cumplimiento.scu_cumpliovenreallineas == '1' ? 'Si' : 'No'}}</div>
                          <div class="col-md-5">@{{infoSolicitud.cumplimiento.scu_observenreallineas}}</div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>Venta Real Marginal</label></div>
                          <div class="col-md-2" align="right">@{{ventaRealMarginal == undefined ? 0 : ventaRealMarginal | currency : "$" : 2}}</div>
                          <div class="col-md-7"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>Inversión Total</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.cumplimiento.scu_invertotal == null ? 0 : infoSolicitud.cumplimiento.scu_invertotal | currency : "$" : 2}}</div>
                          <div class="col-md-2" align="left">@{{infoSolicitud.cumplimiento.scu_cumpliinvertotal == '1' ? 'Si' : 'No'}}</div>
                          <div class="col-md-5">@{{infoSolicitud.cumplimiento.scu_observinvertotal}}</div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>% Cumplimiento en Venta</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.cumplimiento.scu_pcumpventa == null ? 0 : infoSolicitud.cumplimiento.scu_pcumpventa | number:2}} %</div>
                          <div class="col-md-7"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>% Crecimiento vs Periodo Anterior</label></div>
                          <div class="col-md-2" align="right">@{{infoSolicitud.cumplimiento.scu_pcrevsante == null ? 0 : infoSolicitud.cumplimiento.scu_pcrevsante | number:2}} %</div>
                          <div class="col-md-7"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-3"><label>% Real de Inversión vs Venta Marginal Lineas</label></div>
                          <div class="col-md-2" align="right">@{{ventaReal == undefined ? 0 : ((infoSolicitud.objetivo.soo_costonego / ventaReal)*100) | number:2}} %</div>
                          <div class="col-md-7"></div>
                        </div>
                      </li>
                      <hr>
                      <!--Creacion de la Informacion B, consolidada en la segunda tabla-->
                      <label>CALIFICACIÓN NEGOCIACIÓN</label>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-7"><label>Satisfaccion Cliente</label> (10%)</div>
                          <div class="col-md-3" align="right">@{{infoSolicitud.cumplimiento.scu_reaccionmercado == '4' ? 'Excelente (4)' : infoSolicitud.cumplimiento.scu_reaccionmercado == '3' ? 'Bueno (3)' : infoSolicitud.cumplimiento.scu_reaccionmercado == '2' ? 'Regular (2)' : infoSolicitud.cumplimiento.scu_reaccionmercado == '1' ? 'Malo (1)' : 'SIN CLASIFICACIÓN'}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-7"><label>Dinamica Cliente</label> (@{{infoSolicitud.cumplimiento.scu_pdinamicacliente}}%)</div>
                          <div class="col-md-3" align="right">@{{infoSolicitud.cumplimiento.scu_dinamicacliente == '4' ? 'Excelente (4)' : infoSolicitud.cumplimiento.scu_dinamicacliente == '3' ? 'Bueno (3)' : infoSolicitud.cumplimiento.scu_dinamicacliente == '2' ? 'Regular (2)' : infoSolicitud.cumplimiento.scu_dinamicacliente == '1' ? 'Malo (1)' : 'SIN CLASIFICACIÓN'}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-7"><label>Financiero</label> (@{{infoSolicitud.cumplimiento.scu_pfinanciero}}%)</div>
                          <div class="col-md-3" align="right">@{{infoSolicitud.cumplimiento.scu_financiero == '4' ? 'Excelente (4)' : infoSolicitud.cumplimiento.scu_financiero == '3' ? 'Bueno (3)' : infoSolicitud.cumplimiento.scu_financiero == '2' ? 'Regular (2)' : infoSolicitud.cumplimiento.scu_financiero == '1' ? 'Malo (1)' : 'SIN CLASIFICACIÓN'}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-7"><label>Contraprestación</label> (@{{infoSolicitud.cumplimiento.scu_pcontraprestacion}}%)</div>
                          <div class="col-md-3" align="right">@{{infoSolicitud.cumplimiento.scu_contraprestacion == '4' ? 'Excelente (4)' : infoSolicitud.cumplimiento.scu_contraprestacion == '3' ? 'Bueno (3)' : infoSolicitud.cumplimiento.scu_contraprestacion == '2' ? 'Regular (2)' : infoSolicitud.cumplimiento.scu_contraprestacion == '1' ? 'Malo (1)' : 'SIN CLASIFICACIÓN'}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-md-7"><label>Calificación Total</label></div>
                          <div class="col-md-3" align="right">@{{infoSolicitud.cumplimiento.scu_calificaciontotal == '4' ? 'Excelente (4)' : infoSolicitud.cumplimiento.scu_calificaciontotal == '3' ? 'Bueno (3)' : infoSolicitud.cumplimiento.scu_calificaciontotal == '2' ? 'Regular (2)' : infoSolicitud.cumplimiento.scu_calificaciontotal == '1' ? 'Malo (1)' : 'SIN CLASIFICACIÓN'}}</div>
                          <div class="col-md-2"></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <hr>
                  <!--Creacion de la Informacion C, consolidada en un panel-->
                  <label>SOPORTES NEGOCIACIÓN (FOTOS)</label>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-2">Valor</div>
                        <div class="col-md-2">¿Cumplio?</div>
                        <div class="col-md-2">Punto de Venta</div>
                        <div class="col-md-3">Observaciones</div>
                        <div class="col-md-3">Fecha de Cargue</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <!--Validacion de la informacion que se muestra en el panel-->
                      <div class="row" ng-if="infoSolicitud.revi_exhibicion.length == 0">
                        <div class="col-md-12" align="center">No se encontraron registros</div>
                      </div>
                      <!--Recorrer el arreglo y mostrar la informacion registrada-->
                      <div class="row" ng-if="infoSolicitud.revi_exhibicion.length != 0" ng-repeat="foto in infoSolicitud.revi_exhibicion">
                        <div class="col-md-2" ng-if="foto.sre_foto != ''"><a ng-click="newVentana(foto)">Ver Foto</a></div>
                        <div class="col-md-2" ng-if="foto.sre_foto == ''"></div>
                        <div class="col-md-2">@{{foto.sre_cumplio}}</div>
                        <div class="col-md-2">@{{foto.sre_puntovento}}</div>
                        <div class="col-md-3">@{{foto.sre_observacion}}</div>
                        <div class="col-md-3">@{{foto.sre_fecha}}</div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <!--Creacion de la Informacion D, consolidada en un ultimo panel-->
                  <label>VALIDACIÓN DE CONCURSOS, PREMIOS, ETC. (ACTA ENTREGA)</label>
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-1">Acta</div>
                        <div class="col-md-1">Cedula</div>
                        <div class="col-md-2">Nombre</div>
                        <div class="col-md-2">Direccion</div>
                        <div class="col-md-2">Ciudad</div>
                        <div class="col-md-2">Observaciones</div>
                        <div class="col-md-2">Fecha de Cargue</div>
                      </div>
                    </div>
                    <div class="panel-body">
                      <!--Validacion de la informacion-->
                      <div class="row" ng-if="infoSolicitud.acta_entrega.length == 0">
                        <div class="col-md-12" align="center">No se encontraron registros</div>
                      </div>
                      <!--Recorrer el arreglo y mostrar la informacion registrada-->
                      <div class="row" ng-if="infoSolicitud.acta_entrega.length != 0" ng-repeat="acta in infoSolicitud.acta_entrega">
                        <div class="col-md-1" ng-if="acta.sae_acta != ''"><a ng-click="newVentana(acta)">Acta</a></div>
                        <div class="col-md-1" ng-if="acta.sae_acta == ''"></div>
                        <div class="col-md-1">@{{acta.sae_cedula}}</div>
                        <div class="col-md-2">@{{acta.sae_nombre}}</div>
                        <div class="col-md-2">@{{acta.sae_direccion}}</div>
                        <div class="col-md-2">@{{acta.sae_ciudad}}</div>
                        <div class="col-md-2">@{{acta.sae_observaciones}}</div>
                        <div class="col-md-2">@{{acta.sae_fecha}}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.7 Veri. de Cobro-->
            <md-tab label="Veri. de Cobro">
              <md-content class="md-padding">
                <div class="col-sm-12">
                    <div class="table-responsive" style="font-size: 11px;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Fecha de Registro</th>
                          <th>Proveedor</th>
                          <th>Tipo de Documento</th>
                          <th>No. de Documento</th>
                          <th>Fecha de Documento</th>
                          <th>Valor Bruto del Documento</th>
                          <th>Fecha de Recibido en Belleza Express</th>
                          <th>Valor Bruto Aprobado Negociación</th>
                          <th>Diferencia Valor Aprobado vs Documento</th>
                          <th>Observaciones</th>
                          <th>Usuario</th>
                        </tr>
                      </thead>
                      <!--Ingresar informacion historica de la verificacion de cobro-->
                      <tbody>
                        <tr ng-if="infoSolicitud.verificacion_cobro.length != 0" ng-repeat="evalua in infoSolicitud.verificacion_cobro | orderBy:'-svc_fecharegistro'">
                          <td>@{{evalua.svc_fecharegistro}}</td>
                          <td>@{{evalua.proveedor.razonSocialTercero}}</td>
                          <td>@{{evalua.documento.tdo_descripcion}}</td>
                          <td>@{{evalua.svc_ndocumento}}</td>
                          <td>@{{evalua.svc_fechadocumento}}</td>
                          <td align="right">@{{evalua.svc_valorbruto | currency : "$" : 2}}</td>
                          <td>@{{evalua.svc_fecharecibido}}</td>
                          <td align="right">@{{infoSolicitud.costo.soc_granvalor | currency : "$" : 2}}</td>
                          <td align="right">@{{evalua.svc_diferencia | currency : "$" : 2}}</td>
                          <td>@{{evalua.svc_observaciones}}</td>
                          <td>@{{evalua.svc_usuario}}</td>
                        </tr>
                        <!--Validación de registro-->
                        <tr ng-if="infoSolicitud.verificacion_cobro.length == 0">
                          <td colspan="11" align="center">No se encontraron registros en Verificación de cobros</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.8 His. Tesoreria-->
            <md-tab label="His. Tesoreria">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="table-responsive" style="font-size: 11px;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Fecha de Registro</th>
                          <th>Usuario</th>
                          <th>Tipo</th>
                          <th>Observaciones</th>
                          <th>Bonos Desde</th>
                        </tr>
                      </thead>
                      <!--Ingresar informacion historica de tesoreria-->
                      <tbody>
                        <tr ng-if="infoSolicitud.teso_historial.length != 0" ng-repeat="hist in infoSolicitud.teso_historial | orderBy:'-sth_fecha'">
                          <td>@{{hist.sth_fecha}}</td>
                          <td>@{{hist.sth_usuario}}</td>
                          <td>@{{hist.sth_tipo}}</td>
                          <td>@{{hist.stn_observaciones}}</td>
                          <td>@{{hist.sth_bonosdesde}}</td>
                        </tr>
                        <!--Validación de registro-->
                        <tr ng-if="infoSolicitud.teso_historial.length == 0">
                          <td colspan="5" align="center">No se encontraron registros de Historial de Tesoreria</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.9 His. Auditoria-->
            <md-tab label="His.Auditoria">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="table-responsive" style="font-size: 11px;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Formulario</th>
                          <th>Valores Antes</th>
                          <th>Valores Despues</th>
                          <th>Usuario</th>
                          <th>Fecha</th>
                        </tr>
                      </thead>
                      <!--Ingresar informacion historica de la auditoria-->
                      <tbody>
                        <tr ng-if="infoSolicitud.teso_auditoria.length != 0" ng-repeat="audit in infoSolicitud.teso_auditoria | orderBy:'-lga_fecha'">
                          <td>@{{audit.lga_formulario}}</td>
                          <td>@{{audit.lga_valoresantes}}</td>
                          <td>@{{audit.lga_valoresdespues}}</td>
                          <td>@{{audit.usuario.razonSocialTercero}}</td>
                          <td>@{{audit.lga_fecha}}</td>
                        </tr>
                        <!--Validación de registro-->
                        <tr ng-if="infoSolicitud.teso_auditoria.length == 0">
                          <td colspan="5" align="center">No se encontraron registros de Historial de Auditoria</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </md-content>
            </md-tab>
          </md-tabs>
        </div>        
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" type="button">Cerrar</button>
      </div>
    </div>
  </div>
</div>