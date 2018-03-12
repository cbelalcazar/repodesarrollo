<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="formulario" class="form-horizontal" ng-submit="formulario.$valid && save()" novalidate>
      <div class="modal-content panel-primary">
         <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Referencia</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Referencia:</label>
              <input ng-model="objRefProg.iref_referencia" type="text" class="form-control">
            </div>
            <div class="form-group">
              <label>Tipo de Empaque:</label>
              <select ng-model="objRefProg.iref_tipoempaque" class="form-control">
                <option value="">Seleccione...</option>
              </select>
            </div>
            <div class="form-group">
              <label>Peso por Empaque:</label>
              <input ng-model="objRefProg.iref_tipoempaque" type="number" min="0" class="form-control">
            </div>
          </div>
          <div class="modal-footer">  
             <button class="btn btn-primary" type="submit">Crear</button> 
            <button class="btn btn-secondary" ng-click="limpiar()" data-dismiss="modal" type="button">Cerrar</button>
          </div>
      </div>
    </form>
  </div>
</div>
<!-- End modal -->
