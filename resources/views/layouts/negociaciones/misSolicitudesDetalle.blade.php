<!--Modal-->
<style>
.col-sm-6{
  padding-right: 0px;
  padding-left: 0px;
}

.md-tab {
    max-width: min-content !important;
}

.hr {
    margin-top: 16px;
    margin-bottom: 5px;
    }
</style>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog"  style="width: 70% !important;" role="document">
    <div class="modal-content panel-primary">
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Detalle de Negociación</h4>
      </div>

      <div class="modal-body">
        <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
        <p></p>
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
                  <label>Pendiente de gestion: </label>
                </li>
                <li class="list-group-item">
                  <label>Ultimo proceso realizado: </label>
                </li>           
              </ul>
            </div>
          </div>
          <hr>
          <md-tabs md-dynamic-height md-border-bottom>
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
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="Info. Solicitud">
              <md-content class="md-padding">
                <div class="col-sm-12">
                  <div class="row">
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
                          <label>Canal: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Lista de Precios: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Periodo de Facturación: </label> @{{infoSolicitud.sol_peri_facturaini}} a @{{infoSolicitud.sol_peri_facturafin}}
                        </li>
                        <li class="list-group-item">
                          <label>Clase: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Negociación Año Anterior: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Tipo de Negociación: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Observaciones: </label> @{{infoSolicitud.sol_observaciones}}
                        </li>
                        <li class="list-group-item">
                          <label>Periodo de Ejecución: </label> @{{infoSolicitud.sol_peri_ejeini}} a @{{infoSolicitud.sol_peri_ejefin}}
                        </li>
                        <li class="list-group-item">
                          <label>Revision de Acta en Auditoria: </label>
                        </li>
                      </div>
                      <div class="col-sm-6">
                        <li class="list-group-item">
                          <label>Estado: </label> @{{infoSolicitud.estado.ser_descripcion}}
                        </li>
                        <li class="list-group-item">
                          <label>Vendedor: </label> ***Pendiente***
                        </li>
                        <li class="list-group-item">
                          <label>NIT: </label> @{{infoSolicitud.cliente.ter_id}}
                        </li>
                        <li class="list-group-item">
                          <label>Descuento Comercial: </label> @{{infoSolicitud.cliente.cli_txt_dtocome | currency : "" : 0}}%
                        </li>
                        <li class="list-group-item">
                          <label>Zona: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Meses: </label> @{{infoSolicitud.sol_mesesfactu}}
                        </li>
                        <li class="list-group-item">
                          <label>Clasificación: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Zona: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Canal: </label>
                        </li>           
                        <li class="list-group-item">
                          <label>Mercadeo: </label>
                        </li>
                        <li class="list-group-item">
                          <label>Meses: </label> @{{infoSolicitud.sol_meseseje}}
                        </li>
                        <li class="list-group-item">
                          <label>Documento Provisión: </label>
                        </li>
                    </div>

                      </ul>
                  </div>
                </div>
              </md-content>
            </md-tab>
            <md-tab label="Info. Costos">

            </md-tab>
            <md-tab label="Info. Objetivos">

            </md-tab>
            <md-tab label="Info. Eval. Real">

            </md-tab>
            <md-tab label="Evaluación">

            </md-tab>
            <md-tab label="Veri. de Cobro">

            </md-tab>
            <md-tab label="His. Tesoreria">

            </md-tab>
            <md-tab label="His.Auditoria">

            </md-tab>
          </md-tabs>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>