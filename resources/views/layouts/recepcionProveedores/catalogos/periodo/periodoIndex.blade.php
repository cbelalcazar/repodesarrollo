@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="periodoCtrl" ng-cloak>
    <div class="panel panel-default">
      <div class="panel-body">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="setArea()">
          <i class="glyphicon glyphicon-plus"></i> Crear
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
    @include('layouts.recepcionProveedores.catalogos.periodo.periodoForm')
  </div>
@endsection

@push('script_angularjs')
  <script src="{{url('/js/recepcionProveedores/catalogos/periodoCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush
