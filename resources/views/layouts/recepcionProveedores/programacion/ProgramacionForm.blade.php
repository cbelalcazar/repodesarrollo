<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">

    <form name="periodoForm" ng-submit="periodoForm.$valid && save()" novalidate>
      <div class="modal-content panel-primary">
       <div class="modal-header panel-heading">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Programar Ordenes</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">

            <div class="alert alert-success" ng-if="mensajeExito">
              <strong>Exito!</strong> La programacion ha sido creada correctamente.
            </div>

            <div ng-if="alertas" class="col sm-12">
              <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h4>Favor solucionar los siguientes inconvenientes </h4>
                <ul>                                   
                  <li ng-repeat="msj in mensajes">@{{msj[0]}}</li>
                </ul>                  
              </div>
            </div>


            <!-- Autocomplete proveedores -->
            <div class="col-sm-4">
              <label>Consulta proveedores: (*)</label>
              <md-autocomplete
              md-selected-item="objeto.selectedItem" 
              md-selected-item-change="getReferenciasPorOc()" 
              md-search-text="searchTextProveedor" 
              md-items="item in query(searchTextProveedor)" 
              md-item-text="item.razonSocialTercero" required>
              <md-item-template>
                <span md-highlight-text="searchTextProveedor" md-highlight-flags="^i">@{{item.nitTercero}} - @{{item.razonSocialTercero}}</span>
              </md-item-template>
              <md-not-found>
                El proveedor "@{{searchTextProveedor}}" no fue encontrado.
              </md-not-found>
            </md-autocomplete>
          </div>            
          <!-- End autocomplete proveedores -->  
          
          <!-- Tipo de inventario -->
          <div class="form-group col-sm-4">
            <label>Referencias: (*)</label>
            <select ng-model="objeto.referencia" ng-options="opt.Referencia.trim() + ' - ' + opt.DescripcionReferencia for opt in referencias track by opt.Referencia.trim()" class="form-control" ng-change="filtrarOrdenes()" required>
              <option value="">Seleccione..</option>
            </select>
          </div>    
          <!-- End Tipo de inventario -->
          
          <!-- Descripción item -->
          <div class="form-group  col-sm-4">
            <label>Cantidad a pedir:  (*)</label>
            <input type="number"  ng-keyup="validarCantidadIngresada()" class="form-control" ng-model="objeto.cant_pedida" required/>
            <span ng-if="errorCantidad" class="has-error"><p><small>El dato ingresado supera la cantidad permitida</small></p></span>  
          </div>  
          <!-- End descripcion item -->

          <div class="form-group col-sm-4">
            <label>Fecha entrega:  (*)</label>
            <md-datepicker ng-model="objeto.fechaEntrega" md-placeholder="Enter date"
            md-date-filter="soloDiasSemana" required></md-datepicker>
          </div>

          <div class="col-sm-4">
            <label for="comment">Observacion:</label>
            <textarea ng-model="objeto.observacion" class="form-control" rows="2" maxlength="254"></textarea>
          </div>

          <div class="form-group col-sm-12">
            <br>
             <!-- Descripción item -->
            <div class="col-sm-9">
              <h5 class="text-primary"><strong>@{{objeto.orden}}</strong></h5>
            </div>  
             <!-- Descripción item -->
            <div class="col-sm-3">
              <button class="btn btn-primary pull-right" type="submit">Adicionar</button>
            </div>  
            <!-- End descripcion item -->
            
          </div>

        </div>
        <div class="col-sm-12">
          <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
            <thead>
              <tr>
                <th>Orden</th>
                <th>Referencia</th>
                <th>Fecha entrega</th>
                <th>Cant. solicitada</th>
                <th>Cant. entregada</th>
                <th>Cant. pendiente</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="orden in ordenes">
                <td><a href="#" ng-click="seleccionarOrden(orden)">@{{orden.ConsDocto}} - @{{orden.TipoDocto}}</a></td>
                <td>@{{orden.Referencia.trim()}} - @{{orden.DescripcionReferencia}}</td>
                <td>@{{cambiarFormato(orden.f421_fecha_entrega) | date:'M/dd/yyyy'}}</td>                
                <td>@{{orden.CantPedida | number:0 }}</td>
                <td>@{{orden.CantEntrada | number:0}}</td>
                <td>@{{orden.CantPendiente | number:0}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="modal-footer">      
      <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
    </div>

  </div>
</form>
</div>
</div>
