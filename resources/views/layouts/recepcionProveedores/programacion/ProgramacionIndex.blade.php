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
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal1" ng-click="limpiar()">
              <i class="glyphicon glyphicon-plus"></i> Programar
            </button><br><br>
            <table  datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs" class="row-border hover">
              <thead>
                <tr>
                  <th>
                    <md-checkbox class="md-primary" aria-label="Select All"
                    ng-checked="isChecked()"
                    md-indeterminate="isIndeterminate()"
                    ng-click="toggleAll()">
                  </md-checkbox>
                </th>
                <th>Referencia</th>
                <td>Proveedor</td>
                <th>Orden de compra</th>
                <th>Fecha programada</th>
                <th>Cantidad programada</th>
                <th>Cant. Solicitada OC</th>
                <th>Cant. Entregada OC</th>
                <th>Cant. Pendiente OC</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="prg in progPendEnvio">
               <td>
                  <md-checkbox ng-checked="exists(prg, progSelected)" ng-click="toggle(prg, progSelected)" class="md-primary">
                   @{{prg.id}}
                 </md-checkbox>                   
               </td>                 
               <td>@{{prg.prg_referencia}} - @{{prg.prg_desc_referencia}}</td>                       
               <td>@{{prg.prg_razonSocialTercero}}</td>
               <td>@{{prg.prg_tipo_doc_oc}} - @{{prg.prg_num_orden_compra}}</td>
               <td>@{{prg.prg_fecha_programada}}</td>
               <td>@{{prg.prg_cant_programada}}</td>
               <td>@{{prg.prg_cant_solicitada_oc}}</td>
               <td>@{{prg.prg_cant_entregada_oc}}</td>
               <td>@{{prg.prg_cant_pendiente_oc}}</td>    
               <td class="text-right"> 
                 <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal1" ng-click="edit(prg)">
                  <i class="glyphicon glyphicon-pencil"></i> 
                 </button>
               </td>     
               <td>
                 <button class="btn btn-danger btn-sm" ng-click="delete(prg)">
                  <i class="glyphicon glyphicon-trash"></i>
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
