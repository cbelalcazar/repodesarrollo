<!--ModalAnular-->
<div class="modal fade" id="ModalConfirBono" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width: 70% !important;" role="document">
		<form  name="confirForm" ng-submit="confirForm.$valid && confirmarBono()" novalidate>
			<div class="modal-content panel-primary">
				<div class="modal-header panel-heading">
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Confirmar Tesoreria Bonos en Solicitud de Negociación</h4>
				</div>
				<div class="modal-body">
		    	    <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
		        	<hr><br>
		        	<label>Observaciones: </label>
		        	<textarea required maxlength="150" rows="2" style=" width: 800px;" ng-model="infoSolicitud.sol_obsconfirbono"></textarea>
		        </div>
				<div class="modal-footer">
		  		    <button class="btn btn-success" type="submit">Confirmar</button>
		  		    <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
		   	    </div>		  
		    </div>
    	</form>
	</div>
</div>