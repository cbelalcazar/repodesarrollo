@extends('app') 

@section('content')
  @include('includes.titulo')
  	<div ng-controller="claseNegociacionCtrl" ng-cloak class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
    	<div class="panel panel-default">
      	<div class="panel-body">
          <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
    			  <button type="button" class="btn btn-success btn-sm" ng-click="resetForm()" data-toggle="modal" data-target="#modal">
              <i class="glyphicon glyphicon-plus"></i>Agregar
            </button>
          </div>
          <div class="panel-group">	  
            <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12 col-sm-12">
              <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
                <thead>
                  <tr>
                    <th class="text-center">Nombre</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="clase in clases"> 
                    <td class="text-left">@{{clase.cneg_descripcion}}</td>
                    <td class="text-right">
                      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal" ng-click="editarClase(clase)">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <md-tooltip>Editar
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" ng-click="eliminarClase(clase)">
                        <i class="glyphicon glyphicon-trash"></i>
                        <md-tooltip>Eliminar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
      		</div>
      	</div>
        @include('layouts.negociaciones.Catalogos.claseNegociacionCreate')
    	</div>

    	<div ng-if="progress" class="progress">
      	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    	</div>
  	</div>
  @endsection

@push('script_angularjs')
<script src="{{url('/js/negociaciones/claseNegociacionCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush