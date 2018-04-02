@extends('app')

@section('content')
  @include('includes.titulo')
  <div ng-controller="nivelesAutorizacion" ng-cloak>
    <div class="container-fluid">     

      <md-tabs md-dynamic-height md-border-bottom>
	      <md-tab label="Nivel 1">
	        <md-content class="md-padding">

				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(1)"><i class="glyphicon glyphicon-plus"></i> Crear Nuevo Nivel</button>

				<hr class="border-top-dotted">	

	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<th>Id</th>
	          			<th>Usuario</th>
	          			<th>Nombre</th>
	          			<th>Cedula</th>
	          			<th>Tipo persona</th>
	          			<th>Acción</th>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="uno in nivelUno">
	          			<td>@{{uno.id}}</td>
	          			<td>@{{uno.pen_usuario}}</td>
	          			<td>@{{uno.pen_nombre}}</td>
	          			<td>@{{uno.pen_cedula}}</td>
	          			<td>@{{uno.t_tipopersona.tpp_descripcion}}</td>
	          			<td>
	          				<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modal" ng-click="update(uno)"><i class="glyphicon glyphicon-pencil"></i></button>
	          				<button class="btn btn-danger" type="button" ng-click="delete(uno)"><i class="glyphicon glyphicon-trash"></i></button>
	          			</td>
	          		</tr>
	          	</tbody>
	          </table>				        	

	        </md-content>
	      </md-tab>
	      <md-tab label="Nivel 2">
	        <md-content class="md-padding">

				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(2)"><i class="glyphicon glyphicon-plus"></i> Crear Nuevo Nivel</button>

				<hr class="border-top-dotted">	

	           <table datatable="ng" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<th>Id</th>
	          			<th>Usuario</th>
	          			<th>Nombre</th>
	          			<th>Cedula</th>
	          			<th>Tipo persona</th>
	          			<th>Acción</th>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="dos in nivelDos">
	          			<td>@{{dos.id}}</td>
	          			<td>@{{dos.pen_usuario}}</td>
	          			<td>@{{dos.pen_nombre}}</td>
	          			<td>@{{dos.pen_cedula}}</td>
	          			<td>@{{dos.t_tipopersona.tpp_descripcion}}</td>
	          			<td>
	          				<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modal" ng-click="update(dos)"><i class="glyphicon glyphicon-pencil"></i></button>
	          				<button class="btn btn-danger" type="button" ng-click="delete(dos)"><i class="glyphicon glyphicon-trash"></i></button>
	          			</td>
	          		</tr>
	          	</tbody>
	          </table>						        	

	        </md-content>
	      </md-tab>
	      <md-tab label="Nivel 3">
	        <md-content class="md-padding">

				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(3)"><i class="glyphicon glyphicon-plus"></i> Crear Nuevo Nivel</button>

				<hr class="border-top-dotted">	

	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<th>Id</th>
	          			<th>Usuario</th>
	          			<th>Nombre</th>
	          			<th>Cedula</th>
	          			<th>Tipo persona</th>
	          			<th>Acción</th>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="tres in nivelTres">
	          			<td>@{{tres.id}}</td>
	          			<td>@{{tres.pen_usuario}}</td>
	          			<td>@{{tres.pen_nombre}}</td>
	          			<td>@{{tres.pen_cedula}}</td>
	          			<td>@{{tres.t_tipopersona.tpp_descripcion}}</td>
	          			<td>
	          				<button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modal" ng-click="update(tres)"><i class="glyphicon glyphicon-pencil"></i></button>
	          				<button class="btn btn-danger" type="button" ng-click="delete(tres)"><i class="glyphicon glyphicon-trash"></i></button>
	          			</td>
	          		</tr>
	          	</tbody>
	          </table>							        	

	        </md-content>
	      </md-tab>	      	      
	      <md-tab label="Nivel 4(GERENTE)">
	        <md-content class="md-padding">

				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#modal" ng-click="cambiarNivel(4)"><i class="glyphicon glyphicon-plus"></i> Crear Nuevo Nivel</button>

				<hr class="border-top-dotted">	

	           <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
	          	<thead>
	          		<tr>
	          			<th>Id</th>
	          			<th>Usuario</th>
	          			<th>Nombre</th>
	          			<th>Cedula</th>
	          			<th>Tipo persona</th>
	          			<th>Acción</th>
	          		</tr>
	          	</thead>
	          	<tbody>
	          		<tr ng-repeat="cuatro in nivelCuatro">
	          			<td>@{{cuatro.id}}</td>
	          			<td>@{{cuatro.pen_usuario}}</td>
	          			<td>@{{cuatro.pen_nombre}}</td>
	          			<td>@{{cuatro.pen_cedula}}</td>
	          			<td>@{{cuatro.t_tipopersona.tpp_descripcion}}</td>
	          			<td>
	          				<button class="btn btn-danger" type="button" ng-click="delete(cuatro)"><i class="glyphicon glyphicon-trash"></i></button>
	          			</td>
	          		</tr>
	          	</tbody>
	          </table>							        	

	        </md-content>
	      </md-tab>	      	      
	  </md-tabs>
    </div>

	@include('layouts.negociaciones.createNivelAutorizacion')

 	<div ng-if="progress" class="progress">
    	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
	</div> 

  </div>  


@endsection

@push('script_angularjs')
  <script src="{{url('/js/negociaciones/nivelesAutorizacion.js')}}" type="text/javascript" language="javascript"></script>
@endpush