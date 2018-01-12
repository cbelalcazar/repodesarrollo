<!--ModalExhibicion-->
<div class="modal fade" id="ModalExhibicion" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="width: 70% !important;" role="document">
		<div class="modal-content panel-primary">
			<div class="modal-header panel-heading">
				<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Información de Exhibición y Actas de Premios</h4>
			</div>
			<div class="modal-body">
        <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
        <hr>
				<label>SOPORTES NEGOCIACIÓN (FOTOS)</label>
        <div class="panel panel-primary">
        	<div class="panel-heading">
            <div class="row">
           		<div class="col-md-1">Valor</div>
              <div class="col-md-1">¿Cumplio?</div>
           		<div class="col-md-2">Punto de Venta</div>
            	<div class="col-md-3">Observaciones</div>
           		<div class="col-md-2">Usuario Subio</div>
            	<div class="col-md-2">Fecha Subida</div>
           		<div class="col-md-1">Acción</div>
           	</div>
          </div>
          <div class="panel-body">
          	<div class="row" ng-repeat="foto in infoSolicitud.revi_exhibicion">
              <div class="col-md-1">Ver Foto</div>
              <div class="col-md-1">@{{foto.sre_cumplio}}</div>
              <div class="col-md-2">@{{foto.sre_puntovento}}</div>
              <div class="col-md-3">@{{foto.sre_observacion}}</div>
              <div class="col-md-2">@{{foto.usuario.razonSocialTercero}}</div>
              <div class="col-md-2">@{{foto.sre_fecha}}</div>
              <div class="col-md-1">
	        			<button class="btn btn-danger" type="button" style="padding: 3px 7px; margin-top: 2px;">
	       				<i class="glyphicon glyphicon-remove"></i>
	        				<md-tooltip>Eliminar 
        			</button>
             	</div>
              <br>
            </div>
          </div>
          <div class="panel-footer">
          	<div class="row">
              <form name="frmFotos" ng-submit="imprimir()">
              <div class="col-md-1">
                <input type="file" file-model="fotoGuardar">
               </div>
              <div class="col-md-1">
                <select>
                  <option value="1">Si</option>
                  <option value="2">No</option>
                </select>
              </div>
              <div class="col-md-2"><input type="text" placeholder="Punto de Venta"></div>
              <div class="col-md-3"><input type="text-area" placeholder="Observaciones"></div>
              <div class="col-md-2"></div>
              <div class="col-md-2"></div>
              <div class="col-sm-1">
                <button class="btn btn-success" type="submit" style="padding: 3px 7px; margin-top: 2px;">
	         				<i class="glyphicon glyphicon-plus"></i>
	        				<md-tooltip>Agregar 
	        			</button>
               </div>
               </form>
            </div>
          </div>
        </div>
        <hr>
        <label>VALIDACIÓN DE CONCURSOS, PREMIOS, ETC. (ACTA ENTREGA)</label>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-1">Acta</div>
              <div class="col-md-1">Cedula</div>
              <div class="col-md-2">Nombre</div>
              <div class="col-md-1">Direccion</div>
              <div class="col-md-1">Ciudad</div>
              <div class="col-md-2">Observaciones</div>
              <div class="col-md-1">Usuario Subio</div>
              <div class="col-md-2">Fecha Subida</div>
              <div class="col-md-1">Acción</div>
            </div>
          </div>
          <div class="panel-body">
            <div class="row" ng-repeat="acta in infoSolicitud.acta_entrega">
		          <div class="col-md-1">Ver Acta</div>
	            <div class="col-md-1">@{{acta.sae_cedula}}</div>
		          <div class="col-md-2">@{{acta.sae_nombre}}</div>
		          <div class="col-md-1">@{{acta.sae_direccion}}</div>
		          <div class="col-md-1">@{{acta.sae_ciudad}}</div>
		          <div class="col-md-2">@{{acta.sae_observaciones}}</div>
		          <div class="col-md-1">@{{acta.usuario.razonSocialTercero}}</div>
	            <div class="col-md-2">@{{acta.sae_fecha}}</div>
	            <div class="col-md-1">
		            <button class="btn btn-danger" type="button" style="padding: 3px 7px; margin-top: 2px;">
	         			  <i class="glyphicon glyphicon-remove"></i>
	        			  <md-tooltip>Eliminar 
	        		  </button>
	            </div>
             </div>
          </div>
          <div class="panel-footer">
            <div class="row">
		          <div class="col-md-1">
		            <button class="btn btn-default" type="button" style="padding: 3px 6px; margin-top: 2px;">Upload
	         			</button>
		          </div>
		          <div class="col-md-1"><input type="text" placeholder="Cedula"></div>
	            <div class="col-md-2"><input type="text" placeholder="Nombre"></div>
		          <div class="col-md-1"><input type="text" placeholder="Direccion"></div>
		          <div class="col-md-1"><input type="text" placeholder="Ciudad"></div>
		          <div class="col-md-2"><input type="text" placeholder="Observaciones"></div>
		          <div class="col-md-1"></div>
		          <div class="col-md-2"></div>
		          <div class="col-md-1">
	              <button class="btn btn-success" type="button" style="padding: 3px 7px; margin-top: 2px;">
          				<i class="glyphicon glyphicon-plus"></i>
	          			<md-tooltip>Agregar 
	          		</button>
		          </div>
            </div>
          </div>
        </div>
		    <div class="modal-footer">
  			  <button class="btn btn-success" data-dismiss="modal" type="button">Guardar</button>
    		  <button class="btn btn-danger" data-dismiss="modal" type="button">Cancelar</button>
     	  </div>
		  </div>
    </div>
	</div>
</div>