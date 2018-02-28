<!--Modal-->
<div class="modal fade" id="modalRechazar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog"  style="width: 70% !important;" role="document">
    <div class="modal-content panel-primary">
      <!--Titulo del modal-->
      <div class="panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Rechazar Negociación</h4>
      </div>
      <!--Fin Titulo del modal-->
      <form name="frmRechazar" ng-submit="frmRechazar.$valid && generarRechazo(infoSolicitud)" novalidate>
        <div class="modal-body">
          <!--Encabezado del modal-->
          <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
          <hr>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_ventmargilin < 0">
                <label><font color="red">ATENCIÓN: La Venta Marginal por Líneas ES NEGATIVA Resultado = @{{infoSolicitud.objetivo.soo_ventmargilin | currency : "$" : 2}}</font></label>
                <br>
              </div>
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_ventamargi < 0">
                <label><font color="red">ATENCIÓN: La Venta Marginal Cliente ES NEGATIVA Resultado = @{{infoSolicitud.objetivo.soo_ventamargi | currency : "$" : 2}}</font></label>
                <br>
              </div>
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_pvenmarlin > 20">
                <label><font color="red">ATENCIÓN: El % de Inversión sobre la Venta Marginal Lineas es MAYOR al 20% Resultado = @{{infoSolicitud.objetivo.soo_pvenmarlin | currency : "" : 2}}%</font></label>
                <br>
              </div>
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_pinvermargi > 20">
                <label><font color="red">ATENCION: El % de Inversión sobre la Venta Marginal Cliente Lineas es MAYOR al 20% Resultado = @{{infoSolicitud.objetivo.soo_pinvermargi | currency : "" : 2}}%</font></label>
                <br>
              </div>
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_pcrelin < 0">
                <label><font color="red">ATENCION: El % de Crecimiento Obtenido Venta Lineas es NEGATIVO Resultado = @{{infoSolicitud.objetivo.soo_pcrelin | currency : "" : 2}}%</font></label>
                <br>
              </div>
              <div class="form-group" ng-if="infoSolicitud.objetivo.soo_pcreciestima < 0">
                <label><font color="red">ATENCIÓN: El % de Crecimiento Obtenido Ventas Cliente es NEGATIVO Resultado = @{{infoSolicitud.objetivo.soo_pcreciestima | currency : "" : 2}}%</font></label>
              </div>
              <div class="form-group">
                <label>Favor realizar una observación del rechazo
                  <font color="red">*</font>
                </label>
                <br>
                <label>Observaciones:</label>
                <textarea required class="form-control" ng-model="infoSolicitud.observ"></textarea>
              </div>
            </div>
          </div>    
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-dismiss="modal" type="button">Cerrar</button>
          <button class="btn btn-danger" ng-if="correcciones == null" type="submit">Rechazar <i class="glyphicon glyphicon-edit"></i></button>

          <button class="btn btn-warning" ng-if="correcciones == 'corregir'" type="submit">Corregir <i class="glyphicon glyphicon-remove"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>