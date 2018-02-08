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
        <div class="alert alert-success" ng-if="mensajeExito">
          <strong>Proceso exitoso!</strong> El archivo fue cargado con exito.
        </div>
        <h3>Negociación No. @{{infoSolicitud.sol_id}} / Estado:  @{{infoSolicitud.estado.ser_descripcion}}</h3>
        <hr>
				<label>SOPORTES NEGOCIACIÓN (FOTOS)</label>
        <div class="panel panel-primary">
        	<div class="panel-heading">
            <div class="row">
           		<div class="col-md-1" align="center">Valor</div>
              <div class="col-md-1" align="center">¿Cumplio?</div>
           		<div class="col-md-2" align="center">Punto de Venta</div>
            	<div class="col-md-3" align="center">Observaciones</div>
           		<div class="col-md-3" align="center">Usuario Subio</div>
            	<div class="col-md-2" align="center">Fecha Subida</div>
           	</div>
          </div>
          <div class="panel-body">
          	<div class="row" ng-repeat="foto in infoSolicitud.revi_exhibicion">
              <div class="col-md-1" align="center" ng-if="foto.sre_foto != ''"><a ng-click="newVentana(foto)">Ver</a></div>
              <div class="col-md-2" ng-if="foto.sre_foto == ''"></div>
              <div class="col-md-1" align="center">@{{foto.sre_cumplio == '1' ? 'Si' : 'No'}}</div>
              <div class="col-md-2" align="left">@{{foto.sre_puntovento}}</div>
              <div class="col-md-3" align="left">@{{foto.sre_observacion}}</div>
              <div class="col-md-3" align="left">@{{foto.usuario.razonSocialTercero}}</div>
              <div class="col-md-2" align="left">@{{foto.sre_fecha | date:'yyyy-MM-dd'}}</div>
            </div>
          </div>
          <div class="panel-footer">
          	<div class="row">
              <form method="POST" action="{{route('saveFotos')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="col-md-4">
                  <input type="file" name="fileFoto" required>
                  <input type="hidden" name="idUsuario" value="@{{infoSolicitud.sol_ven_id}}">
                  <input type="hidden" name="sol_id" value="@{{infoSolicitud.sol_id}}">
                </div>
                <div class="col-md-2">
                  <select name="cumplio" required="">
                    <option value="">¿Cumplio?</option>
                    <option value="1">Si</option>
                    <option value="2">No</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <input type="text" name="puntoVenta" placeholder="Punto de Venta">
                </div>
                <div class="col-md-2">
                  <input type="text-area" name="observaciones" placeholder="Observaciones">
                </div>
                <div class="col-md-1"></div>
                <div class="col-sm-1">
                  <button class="btn btn-success" type="submit" style="padding: 3px 7px; margin-top: 2px;">
  	         				<i class="glyphicon glyphicon-plus"></i>
  	        				<md-tooltip>Agregar</md-tooltip>
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
              <div class="col-md-1" align="center">Acta</div>
              <div class="col-md-1" align="center">Cedula</div>
              <div class="col-md-2" align="center">Nombre</div>
              <div class="col-md-2" align="center">Direccion</div>
              <div class="col-md-1" align="center">Ciudad</div>
              <div class="col-md-2" align="center">Observaciones</div>
              <div class="col-md-2" align="center">Usuario Subio</div>
              <div class="col-md-1" align="center">Fecha Subida</div>
            </div>
          </div>
          <div class="panel-body">
            <div class="row" ng-repeat="acta in infoSolicitud.acta_entrega">
		          <div class="col-md-1" align="center" ng-if="acta.sae_acta != ''"><a ng-click="newVentana(acta)">Ver</a></div>
              <div class="col-md-1" ng-if="acta.sae_acta == ''"></div>
	            <div class="col-md-1" align="center">@{{acta.sae_cedula}}</div>
		          <div class="col-md-2" align="center">@{{acta.sae_nombre}}</div>
		          <div class="col-md-2" align="center">@{{acta.sae_direccion}}</div>
		          <div class="col-md-1" align="center">@{{acta.sae_ciudad}}</div>
		          <div class="col-md-2" align="center">@{{acta.sae_observaciones}}</div>
		          <div class="col-md-2" align="left">@{{acta.usuario.razonSocialTercero}}</div>
	            <div class="col-md-1" align="center">@{{acta.sae_fecha | date:'yyyy-MM-dd'}}</div>
            </div>
          </div>
          <div class="panel-footer">
            <div class="row">
		          <form method="POST" action="{{route('saveActas')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                <div class="col-md-4">
                  <input type="file" name="fileActa" required>
                  <input type="hidden" name="idUsuario" value="@{{infoSolicitud.sol_ven_id}}">
                  <input type="hidden" name="sol_id" value="@{{infoSolicitud.sol_id}}">
                </div>
  		          <div class="col-md-1">
                  <input type="text" name="cedula" placeholder="Cedula" required>
                </div>
  	            <div class="col-md-1">
                  <input type="text"  name="nombre" placeholder="Nombre" required>
                </div>
  		          <div class="col-md-1">
                  <input type="text" name="direccion" placeholder="Direccion" required>
                </div>
  		          <div class="col-md-1">
                  <input type="text" name="ciudad" placeholder="Ciudad" required>
                </div>
  		          <div class="col-md-2">
                  <input type="text" name="observaciones" placeholder="Observaciones">
                </div>
  		          <div class="col-md-1"></div>
  		          <div class="col-md-1">
  	              <button class="btn btn-success" type="submit" style="padding: 3px 7px; margin-top: 2px;">
            				<i class="glyphicon glyphicon-plus"></i>
  	          			<md-tooltip>Agregar</md-tooltip>
  	          		</button>
  		          </div>
              </form>
            </div>
          </div>
        </div>
		    <div class="modal-footer">
    		  <button class="btn btn-primary" data-dismiss="modal" type="button">Cerrar</button>
     	  </div>
		  </div>
    </div>
	</div>
</div>