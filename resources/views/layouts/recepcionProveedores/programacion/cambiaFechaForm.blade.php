<!-- Modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form name="fechaForm" ng-submit="fechaForm.$valid && cambiaFechaProgs()" novalidate>
      <div class="modal-content panel-primary">
         <div class="modal-header panel-heading">
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Cambiar Fechas</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="container-fluid">
                <div class="form-group">
                  <label>Ingresar fecha nueva</label>
                  <md-datepicker ng-model="fechaNueva" md-placeholder="Enter date"
                  md-date-filter="soloDiasSemana" md-min-date="dateNow" required></md-datepicker>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">  
             <button class="btn btn-primary" type="submit">Cambiar Fecha</button> 
            <button class="btn btn-secondary" data-dismiss="modal" type="button">Cerrar</button>
          </div>
      </div>
    </form>
  </div>
</div>
