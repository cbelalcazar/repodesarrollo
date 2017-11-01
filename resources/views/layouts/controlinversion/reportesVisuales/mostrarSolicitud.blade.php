<!-- Modal -->
<style>
.col-sm-6{
  padding-right: 0px;
  padding-left: 0px;
}
</style>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;" role="document">
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Detalle de la Solicitud - Obsequios y Muestras</h4>
        </div>

        <div class="modal-body">

          <h3>Solicitud No. @{{solicitud.sci_id}} / Estado:  @{{solicitud.estado.soe_descripcion}}</h3>
          <p></p>

          <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="Historial de proceso">
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
                      <td colspan="5"></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              </md-content>
            </md-tab>
            <md-tab label="Info. de Solicitud">
              <md-content class="md-padding">

                <div class="row">
                  <h4>Datos basicos de la solicitud</h4>
                  <div class="col-sm-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <label>No. Solicitud: </label> @{{solicitud.sci_id}}
                      </li>
                      <li class="list-group-item">
                        <label>Fecha de solicitud: </label> @{{solicitud.sci_fecha}}
                      </li>
                      <li class="list-group-item">
                        <label>Tipo de Salida: </label> @{{solicitud.tipo_salida.tsd_descripcion}}
                      </li>
                      <li class="list-group-item">
                        <label>Tipo de Persona: </label> @{{solicitud.tipo_persona.tpe_tipopersona}}
                      </li>
                      <li class="list-group-item">
                        <label>Observaciones: </label> @{{solicitud.sci_observaciones}}
                      </li>
                    </ul>
                  </div>
                  <div class="col-sm-6">
                    <ul class="list-group">
                      <li class="list-group-item">
                        <label>Estado: </label> @{{solicitud.estado.soe_descripcion}}
                      </li>
                      <li class="list-group-item">
                        <label>Facturar a: </label> @{{solicitud.facturara.tercero.razonSocialTercero}}
                      </li>
                      <li class="list-group-item">
                        <label>Motivo: </label>@{{solicitud.sci_mts_id}}
                      </li>
                      <li class="list-group-item">
                        <label>Carga a gasto: </label>@{{solicitud.cargara.cga_descripcion}}
                      </li>
                      <li class="list-group-item"><label>&nbsp;</label></li>
                    </ul>
                  </div>
                </div>


              </md-content>
            </md-tab>
          </md-tabs>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
  </div>
</div>
