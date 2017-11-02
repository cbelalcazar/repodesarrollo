<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 65%;">
    <form name="personaForm" ng-submit="personaForm.$valid && save()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Crear persona</h4>
        </div>
        <div class="modal-body">
         
          <!-- Combo niveles -->
          <div class="form-group">
            <label>Seleccionar nivel:</label>
            <select ng-model="objeto.nivel"  ng-change="nivelesCambio()"  ng-options='nivel.niv_nombre for nivel in niveles track by nivel.id' required class="form-control">
              <option value="">Seleccione...</option>
            </select>
          </div>
          <!-- End combo niveles -->

           <!-- Combo tipo persona -->
          <div class="form-group" ng-if="objeto.nivel.id == 1">
            <label>Seleccionar tipo persona:</label>
            <select ng-model="objeto.tipo" ng-change="cambioConsultaArreglo()" ng-options='tipo.tip_descripcion for tipo in tipoPersona track by tipo.id' required class="form-control">
              <option value="">Seleccione...</option>
            </select>
          </div>
          <!-- End combo tipo persona -->

          <!-- Autocomplete -->
          <div class="form-group">
            <label>Usuario</label>
              <md-autocomplete
              md-no-cache="true"
              md-selected-item="objeto.selectedItem"
              md-search-text="objeto.searchText"
              md-items="item in querySearch(objeto.searchText)"
              md-item-text="item.razonSocialTercero"
              md-min-length="2"
              placeholder="Ingresar nombre de persona"
              required>
                <md-item-template>
                  <span md-highlight-text="objeto.searchText" md-highlight-flags="^i">@{{item.idTercero}}-@{{item.razonSocialTercero}}</span>
                </md-item-template>
                <md-not-found>
                  La persona "@{{objeto.searchText}}" no fue encontrada
                </md-not-found>
              </md-autocomplete>
          </div>
          <!-- End autocomplete -->
       

        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Guardar</button>
          <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>
