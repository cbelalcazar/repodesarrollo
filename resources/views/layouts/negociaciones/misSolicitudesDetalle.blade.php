<!--Modal-->
<style>
.col-sm-6{
  padding-right: 0px;
  padding-left: 0px;
}

.col-sm-12{
  padding-right: 0px;
  padding-left: 0px;
}

.md-tab {
    max-width: min-content !important;
}

hr {
    margin-top: 16px;
    margin-bottom: 5px;
    }

.btn{
    margin-top: 11px;
}

.row {
    margin-right: 3px;
    margin-left: 2px;
}

.md-padding {
    padding: 12px;
}

.modal-footer {
    border-top: 0px solid #e5e5e5;
}

.list-group-item {
    padding: 6px 15px;
}

body {
    font-size: 13px;
}

.panel-body {
    padding: 5px;
}
.panel-footer {
    padding: 5px;
}

</style>

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
                <div class="table-responsive">
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
                      <tr ng-repeat="historico in infoSolicitud.his_proceso | orderBy:'-sen_fechaenvio'">
                        <td>@{{historico.sen_fechaenvio}}</td>
                        <td>@{{historico.estado_his_proceso.ser_descripcion}}</td>
                        <td>@{{historico.tercero_envia.razonSocialTercero}}</td>
                        <td>@{{historico.tercero_recibe.razonSocialTercero}}</td>
                        <td>@{{historico.sen_observacion}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </md-content>
            </md-tab>
            <!--Pestaña No.2 Info. Solicitud-->
            <md-tab label="Info. Solicitud">
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
                          <label>Periodo de Ejecución: </label> @{{infoSolicitud.sol_peri_ejeini}} a @{{infoSolicitud.sol_peri_ejefin}}
                        </li>
                        <li class="list-group-item">
                          <label>Revision de Acta en Auditoria: </label> @{{infoSolicitud.sol_llegoacta == '1' ? 'Si' : 'Pendiente'}}
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
                          <label>Clasificación: </label> @{{infoSolicitud.clasificacion.clg_descripcion == null ? 'SIN CLASIFICACIÓN' : infoSolicitud.clasificacion.clg_descripcion}}
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
                        <div class="col-md-3">% Part.</div>
                      </div> 
                    </div>
                    <div class="panel-body">
                      <div class="row" ng-if="(infoSolicitud.soli_zona.length == 0) && (infoSolicitud.soli_sucu.length == 0)">
                        <div class="col-md-12">No se encontraron registros</div>
                      </div>
                      <div ng-if="infoSolicitud.sol_tipocliente == 1" class="row" ng-repeat="centroOperacion in infoSolicitud.soli_zona">
                        <div class="col-md-9">@{{centroOperacion.szn_coc_id}} - @{{centroOperacion.his_zona.c_operacion.cen_txt_descripcion}}</div>
                        <div class="col-md-3">@{{centroOperacion.szn_ppart}}</div>
                      </div>
                      <div ng-if="infoSolicitud.sol_tipocliente == 2" class="row" ng-repeat="centroOperacion in infoSolicitud.soli_sucu">
                        <div class="col-md-9">@{{centroOperacion.his_sucu.suc_num_codigo}}-@{{centroOperacion.his_sucu.suc_txt_nombre}} (@{{centroOperacion.his_sucu.suc_txt_direccion}})</div>
                        <div class="col-md-3">@{{centroOperacion.ssu_ppart}}</div>
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
                      <label>Impuestos Calculados (Informativo)</label>
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
                  <br>
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
            <md-tab label="Info. Objetivos">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="Info. Eval. Real">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="Evaluación">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="Veri. de Cobro">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="His. Tesoreria">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="His.Auditoria">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
                    
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