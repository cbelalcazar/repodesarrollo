<!--Modal-->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog"  style="width: 70% !important;" role="document">
    <div class="modal-content panel-primary">
      <!--Titulo del modal-->
      <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal1" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Aprobacion tipo de negociacion</h4>
      </div>
      <!--Fin Titulo del modal-->
      <form name="frmAprobacion" ng-submit="frmAprobacion.$valid && generarAprobacion(infoSolicitud)" novalidate>
        <div class="modal-body">
          <!--Encabezado del modal-->
          <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
          <hr>
          <div class="col-sm-12">
              <div class="alert alert-danger" ng-if="errorMessage.length > 0">
                  <br>
                  <ul>
                      <li ng-repeat="(key, value) in errorMessage">
                          @{{value}}
                      </li>
                  </ul>
                  <br>
              </div>
          </div>  
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group" ng-if="pernivelUsu.pen_nomnivel == 2 && !validarTipoSolicitud(infoSolicitud)">
                  <label>Tipo de negociacion</label>
                    <select ng-model="infoSolicitud.tipoNegociacionSol" required class="form-control" ng-options="value for (key, value) in tipoNegociacion track by key">
                      <option value="">Seleccione...</option>
                    </select>
                </div>
                <div class="form-group">
                  <label>Observaciones:</label>
                  <textarea class="form-control" ng-model="infoSolicitud.observ"></textarea>
                </div>
              </div>
            </div>
          </div>
          <br><br><hr>     
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal1" type="button">Cerrar</button>
          <button class="btn btn-success" type="submit">Aprobar <i class="glyphicon glyphicon-ok"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>