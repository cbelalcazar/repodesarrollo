@extends('app')
@section('content')
@include('includes.titulo')

<div ng-controller='autorizacionCtrl' ng-cloak class="col-md-12">

  <md-content class="md-padding">

    <table datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs0" class="row-border hover">
      <thead>
        <tr>
          <td>No. Solicitud</td>
          <td>Tipo de Solicitud</td>
          <td>Usuario</td>
          <td>Fecha de Solicitud</td>
          <td>Solicitante</td>
          <td>Periodo de Descuento</td>
          <td>Venta Esperada</td>
          <td>Ver</td>
          <td>Aprobar</td>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="solicitud in solicitudes">
          <td>@{{toda.sci_id}}</td>
          <td>@{{toda.estado.soe_descripcion}}</td>
          <td>@{{toda.sci_fecha | date: 'dd/MM/yyyy'}}</td>
          <td>@{{toda.facturara.tercero.razonSocialTercero}}</td>
          <td>@{{toda.tipo_salida.tsd_descripcion}}</td>
          <td>@{{toda.tipo_persona.tpe_tipopersona}}</td>
          <td>@{{toda.cargara.cga_descripcion}}</td>
          <td>@{{toda.sci_observaciones}}</td>
          <td><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal" ng-click="setSolicitud(toda)"><i class="glyphicon glyphicon-eye-open"></i></button></td>
        </tr>
      </tbody>
    </table>

  </md-content>

<div ng-if="progress" class="progress">
	<md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
</div>

</div>

@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/controlinversion/autorizacionCtrl.js')}}"></script>
@endpush
