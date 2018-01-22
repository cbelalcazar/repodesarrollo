<!--ModalPeriodoEjecucion-->
<div class="modal fade" id="ModalPeriEjecucion" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width: 70% !important;" role="document">
    <form name="periEjeForm" ng-submit="periEjeForm.$valid && cambiarPeriEje()" novalidate>
  		<div class="modal-content panel-primary">
  			<div class="modal-header panel-heading">
  				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
  					<span aria-hidden="true">&times;</span>
  				</button>
  				<h4 class="modal-title">Cambiar Periodo de Ejecucion Negociacion</h4>
  			</div>
        <div class="modal-body">
          <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
          <hr><br>
          <div class="col-sm-12">
            <label>PERIODO DE EJECUCIÓN</label>
          </div>
          <br>
          <div class="row">
            <div class="form-group col-sm-3">
              <label>Inicio: </label>
              <md-datepicker required ng-model="infoSolicitud.sol_peri_ejeini" md-placeholder="Enter date" ng-change="diffmesesFechaEjecucion()"></md-datepicker>                     
            </div>
            <div class="form-group col-sm-3">
              <label>Fin: </label>
              <md-datepicker required ng-model="infoSolicitud.sol_peri_ejefin" md-placeholder="Enter date"  ng-change="diffmesesFechaEjecucion()"></md-datepicker>          
            </div>
            <div class="form-group col-sm-3">
              <label>Meses: </label>
                <input required type="text" disabled readonly class="form-control input-sm" ng-model="infoSolicitud.sol_meseseje">
            </div>
            <div class="form-group col-sm-3">
              <label>Observaciones: </label> 
              <input required type="text" class="form-control input-sm" ng-model="infoSolicitud.sol_observacioncameje">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit" ">Guardar</button>
          <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
        </div>
  		</div>
    </form>
	</div>
</div>