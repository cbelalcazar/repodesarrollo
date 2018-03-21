@extends('app')

@section('content')
@include('includes.titulo')
<link href="{{url('/css/recepcionProveedores/cita.css')}}" type="text/css" rel="stylesheet"/>
<div ng-controller="citaCtrl as ctrl" class="row" ng-cloak>
	<div class="container">        
		<div ui-calendar="uiConfig.calendar"  calendar="myCalendar" ng-model="eventSources">   
		</div>
	</div>
	@include('layouts.recepcionProveedores.cita.citaShow')
</div>
@endsection
@push('script_angularjs')
<script src="{{url('/js/recepcionProveedores/cita/citaCtrl.js')}}" type="text/javascript" language="javascript"></script>
@endpush