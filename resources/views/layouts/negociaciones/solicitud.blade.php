<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario crear solicitud negociaciones                  -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A.                                                 -->
<!-- ******************************************************************** -->
@extends('app')
@section('content')
@include('includes.titulo')
<link rel="stylesheet" href="{{url('/css/negociaciones/solicitudCss.css')}}">
<div ng-controller='solicitudCtrl as ctrl' class="col-md-12" ng-init="objeto.sol_id = {{$id}}; siguiente = '{{$adelante}}'; getInfo();" ng-cloak>
    <md-content>     
        <md-tabs md-dynamic-height md-border-bottom>
            <md-tab md-on-select="cambiarPestanaSeleccionada(0, 'solicitudForm')" label="Información de Solicitud"  md-active="pasoUnoSelect"  ng-disabled="pasoUno">
				<form name="solicitudForm" class="form-horizontal" ng-init="solicitudForm.$valid" ng-submit="save(solicitudForm)" novalidate>
	               @include('layouts.negociaciones.paso1')
	            </form>
            </md-tab>
             <md-tab md-on-select="cambiarPestanaSeleccionada(1, 'costosForm')" md-active="pasoDosSelect" ng-disabled="pasoDos" label="Información de Costos">
				<form name="costosForm" class="form-horizontal" ng-init="solicitudForm.$valid" ng-submit="save(costosForm)" novalidate>
	               @include('layouts.negociaciones.paso2')
	            </form>
            </md-tab>
             <md-tab md-on-select="cambiarPestanaSeleccionada(2, 'objetivosForm')" ng-disabled="pasoTres"  md-active="pasoTresSelect"  label="Información de objetivos">
                <form name="objetivosForm" class="form-horizontal" ng-init="solicitudForm.$valid" ng-submit="save(objetivosForm)" novalidate>
                   @include('layouts.negociaciones.paso3')
                </form>
            </md-tab>
        </md-tabs>
    </md-content>   

    <div ng-if="progress" class="progress">
        <md-progress-circular md-mode="indeterminate" md-diameter="96"></md-progress-circular>
    </div>

</div>
@endsection

@push('script_angularjs')
<script type="text/javascript" src="{{url('/js/negociaciones/solicitudCtrl.js')}}"></script>
@endpush
