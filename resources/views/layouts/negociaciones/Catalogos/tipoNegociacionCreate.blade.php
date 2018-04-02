<!--Modal-->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form name="claseForm" ng-submit="claseForm.$valid && saveTipo()" novalidate>
      <div class="modal-content panel-primary">
        <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" ng-if="isEdit == false">Creación de tipos de negocio</h4>
          <h4 class="modal-title" ng-if="isEdit == true">Edición de tipos de negocio</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label">Nombre del tipo:*</label>
            <input class="form-control" required ng-model="tipo.tneg_descripcion"/>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" ng-if="isEdit == false" type="submit">Guardar
            </button>
            <button class="btn btn-primary" ng-if="isEdit == true" type="submit">Actualizar
            </button>
            <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>