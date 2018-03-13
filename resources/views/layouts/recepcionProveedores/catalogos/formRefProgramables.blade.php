<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="formulario" class="form-horizontal" ng-submit="formulario.$valid && save()" novalidate>
      <div class="modal-content panel-primary">
         <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">@{{accion}} Referencia</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Referencia:</label>
               <md-autocomplete
                  md-selected-item="objRefProg.iref_referencia" 
                  md-search-text="searchText" 
                  md-items="item in query(searchText)" 
                  md-no-cache = "true"
                  md-item-text="item.ite_descripcion"
                  required
                  ng-disabled="accion == 'Actualizar'">
                  <md-item-template>
                    <span md-highlight-text="searchText" md-highlight-flags="^i">@{{item.ite_referencia}} - @{{item.ite_descripcion}}</span>
                  </md-item-template>
                  <md-not-found>
                    El proveedor "@{{searchText}}" no fue encontrado.
                  </md-not-found>
                </md-autocomplete>
            </div>
            <div class="form-group">
              <label>Tipo de Empaque:</label>
              <select ng-model="objRefProg.iref_tipoempaque" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="Bidon">Bidon</option>
                <option value="Caja">Caja</option>
                <option value="Tambor">Tambor</option>
                <option value="Saco">Saco</option>
              </select>
            </div>
            <div class="form-group">
              <label>Peso por Empaque:</label>
              <input ng-model="objRefProg.iref_pesoporempaque" type="number" min="0" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">  
              <button class="btn btn-primary" type="submit">@{{accion}}</button> 
              <button class="btn btn-secondary" ng-click="limpiar()" data-dismiss="modal" type="button">Cerrar</button>
          </div>
      </div>
    </form>
  </div>
</div>
<!-- End modal -->
