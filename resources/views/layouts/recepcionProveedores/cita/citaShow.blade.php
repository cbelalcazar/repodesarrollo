<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content panel-primary">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Informacion cita</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
	                    <div class="col-sm-12">
	                        <h4 class="text-primary">
	                            <strong>Consecutivo cita: @{{progShow[0]['cita']['id']}}</strong>
	                            <label ng-if="progShow[0]['cita']['id'] == undefined"></label>
	                        </h4><hr><br>
	                        <label>Proveedor: </label>  
	                        @{{progShow[0]['cita']['cit_nitproveedor']}} - @{{progShow[0]['cita']['cit_nombreproveedor']}} 
	                        @{{progShow[0]['cita']['title']}}<br>
	                        <label for="inicio">Hora de inicio: </label> 
	                        @{{progShow[0]['cita']['cit_fechafin']}} 
	                        @{{progShow[0]['cita']['start']}} <br>
	                        <label for="inicio">Hora fin estimada: </label> 
	                        @{{progShow[0]['cita']['cit_fechainicio']}} 
	                        @{{progShow[0]['cita']['end']}} <br>
	                        <label>Observaciones: </label> 
	                        @{{progShow[0]['prg_observacion']}} <label ng-if="progShow[0]['prg_observacion'] == ''">N/A</label>
	                        <br><hr>
	                        <table class="table">
	                            <thead>
	                                <tr>
	                                    <th>Orden</th>
	                                    <th>Referencia</th>
	                                    <th>Cantidad</th>
	                                    <th>Embalaje</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <tr ng-repeat="prog in progShow">
	                                    <td>@{{prog.prg_tipo_doc_oc}} - @{{prog.prg_num_orden_compra}}</td>
	                                    <td>@{{prog.prg_referencia}} - @{{prog.prg_desc_referencia}}</td>
	                                    <td>@{{prog.prg_cant_programada}}</td>
	                                    <td>@{{prog.prg_cantidadempaques}} - @{{prog.prg_tipoempaque}}</td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div> 
                    </div>
                </div>
            </div>
            <!-- End Modal Body -->
            <!-- Modal footer -->
            <div class="modal-footer">  
	            <button class="btn btn-secondary" ng-click="limpiar()" data-dismiss="modal" type="button">Cerrar</button>
          	</div>
			<!-- End Modal footer -->
        </div>
    </div>
</div>
