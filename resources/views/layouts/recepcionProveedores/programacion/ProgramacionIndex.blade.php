@extends('app')

@section('content')
@include('includes.titulo')
<div ng-controller="programacionCtrl" ng-cloak>

  <div class="row">
    <ul class="nav nav-tabs">
      <li  class="active"><a data-toggle="tab" href="#menu1">Ordenes en planeacion</a></li>
      <li><a data-toggle="tab" href="#menu2">Ordenes en solicitud cita</a></li>
    </ul>

    <div class="tab-content">
      <!-- tab ordenes en planeacion -->
      <div id="menu1" class="tab-pane fade in active">
        <div class="panel panel-default">
          <div class="panel-body">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setArea()">
              <i class="glyphicon glyphicon-plus"></i> Programar
            </button><br><br>
            <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Fecha inicio</th>
                  <th>Fecha Fin</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="periodo in periodos">
                  <td>@{{periodo.id}}</td>
                  <td>@{{periodo.per_fecha_inicio}}</td>

                  <td>@{{periodo.per_fecha_fin}}</td>
                  <td class="text-right">
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="editPeriodo(periodo.id)">
                      <i class="glyphicon glyphicon-pencil"></i> Editar
                    </button>
                    <button class="btn btn-danger btn-sm" ng-click="deleteActividad($event, periodo.id)">
                      <i class="glyphicon glyphicon-trash"></i> Borrar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- End tab ordenes en planeacion -->

      <!-- tab ordenes en solicitud cita -->
      <div id="menu2" class="tab-pane fade">
        <h3>Menu 2</h3>
        <p>Some content in menu 2.</p>
      </div>
    </div>

    
  </div>
  
  @include('layouts.recepcionProveedores.programacion.programacionForm')
  <div ng-if="progress" class="progress">
      <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
  </div>

</div>
@endsection

@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/programacion/programacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
