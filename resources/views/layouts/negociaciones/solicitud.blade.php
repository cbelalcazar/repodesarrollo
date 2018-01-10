<!-- ******************************************************************** -->
<!-- 27-12-2017 Formulario crear solicitud negociaciones -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A. -->
<!-- ******************************************************************** -->
@extends('app')
@section('content')
@include('includes.titulo')
<link rel="stylesheet" href="{{url('/css/negociaciones/solicitudCss.css')}}">
<div ng-controller='solicitudCtrl as ctrl' class="col-md-12" ng-init="getInfo()" ng-cloak>
    <md-content>
        <md-tabs md-dynamic-height md-border-bottom>
            <md-tab label="Información de Solicitud">
				<form name="solicitudForm" class="form-horizontal" ng-submit="solicitudForm.$valid && save()" novalidate>
	               @include('layouts.negociaciones.paso1')
	            </form>
            </md-tab>
             <md-tab label="Información de Costos">
				<form name="costosForm" class="form-horizontal" ng-submit="costosForm.$valid && save()" novalidate>
	               @include('layouts.negociaciones.paso2')
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
