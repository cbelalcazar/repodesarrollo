@extends('app')

@section('content')
@include('includes.titulo')
<div ng-controller="citaCtrl as ctrl" ng-cloak>
    <div ui-calendar ng-model="eventSources">
      
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