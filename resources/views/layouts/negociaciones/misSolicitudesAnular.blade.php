<!--ModalAnular-->
<div class="modal fade" id="ModalAnular" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width: 70% !important;" role="document">
		<div class="modal-content panel-primary">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Anular Solicitud de Negociación</h4>
			</div>
			<div class="modal-body">
        <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
        <hr>
        <br>
        <div class="row">
          <ul class="list-group">
            <div class="col-sm-6">  
              <li class="list-group-item">
                <label>Cliente: </label> @{{infoSolicitud.cliente.razonSocialTercero_cli}}
              </li>
            </div>
            <div class="col-sm-6">
              <li class="list-group-item">
                <label>Fecha de solicitud: </label> @{{infoSolicitud.sol_fecha}}
              </li>
            </div>
          </ul>
        </div>
        <hr>
        <label>Observaciones: </label>
        <textarea maxlength="150" rows="2" style=" width: 800px;" ng-model="infoSolicitud.sol_observacionanulacion"></textarea>
      </div>
		  <div class="modal-footer">
  		  <button class="btn btn-primary" data-dismiss="modal" type="button">Anular</button>
  		  <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
   	  </div>		  
    </div>
	</div>
</div>