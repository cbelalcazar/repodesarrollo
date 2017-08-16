@extends('app')

@section('content')
@include('includes.titulo')
<div ng-controller="citaCtrl as ctrl" ng-cloak>
  <div class="panel panel-primary col-md-12">
    <div class="panel-body" >
      <h3>Programaciones:</h3>
      <br>
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" ng-repeat="(fecha, array) in programaciones">      
        <div class="panel panel-primary">

          <div class="panel-heading" role="tab">
            <h4 class="panel-title row">
              <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{fecha}}">
                <div class="col-sm-12">
                  <h4>@{{fecha | date: 'EEEE - d/MMMM/yyyy'}}<span class="glyphicon glyphicon-chevron-down pull-right"></span></h4>
                </div>
              </a>
            </h4>
          </div>

        </div>

        <div id="collapse@{{fecha}}" class="panel-collapse collapse" role="tabpanel">
          <div class="panel-body">
            <ul class="list-group">
              <li class="list-group-item" ng-repeat="(key, value) in array | groupBy: 'prg_nit_proveedor'">
                <div class="row">
                  <div class="col-sm-12">
                    
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">     
                      <div class="panel panel-default">

                        <div class="panel-heading" role="tab">
                          <h4 class="panel-title row">
                            <a class="pro-name" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse@{{key}}@{{fecha}}">
                              <div class="col-sm-12">
                                   <h4>@{{value[0].prg_razonSocialTercero}} &nbsp;<span class="label label-danger">@{{value.length}}</span><span class="glyphicon glyphicon-chevron-down pull-right"></span></h4>
                              </div>
                            </a>
                          </h4>
                        </div>

                      </div>

                      <div id="collapse@{{key}}@{{fecha}}" class="panel-collapse collapse" role="tabpanel">
                        <div class="panel-body">
                          <ul class="list-group">
                            <li class="list-group-item" ng-repeat="programacion in value">
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="col-sm-6">
                                    <label>Orden de compra:</label> @{{programacion.prg_tipo_doc_oc}} - @{{programacion.prg_num_orden_compra}}
                                  <br>
                                  <label>Referencia:  </label>  @{{programacion.prg_referencia}} - @{{programacion.prg_desc_referencia}}
                                  <br>
                                  <label>Cantidad programada:</label>  @{{programacion.prg_cant_programada}}
                                  <br>
                                  <label>Cantidad:</label> @{{programacion.prg_cantidadempaques}} Embalaje: @{{programacion.prg_tipoempaque}}
                                  <br>
                                  <label>Fecha programada</label>: @{{programacion.prg_fecha_programada}}
                                  </div>                                  
                                </div>                 
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <br>
                    </div>

                  </div>                 
                </div>
              </li>
            </ul>
          </div>
        </div>
        <br>
      </div>
      
    </div>
  </div>

  <div ng-if="progress" class="progress">
    <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
  </div>
</div>

@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/cita/citaCtrl.js')}}" type="text/javascript" language="javascript"></script>
<script src="{{url('/js/angularJs/angular-locale_es-co.js')}}"></script>
@endpush