<!-- ******************************************************************** -->
<!-- 27-12-2017 Mensaje solicitud aprobada				                  -->
<!-- Carlos Andres Belalcazar Mendez - Analista desarrollador de software -->
<!-- Belleza Express S.A.                                                 -->
<!-- ******************************************************************** -->
@extends('app')
@section('content')
@include('includes.titulo')
<link rel="stylesheet" href="{{url('/css/negociaciones/mensajeEnvioSolicitud.css')}}">
<div class="row">
	<div class="col-sm-12">
		<div class="container">
			<div class="panel-group">
			  <div class="panel panel-primary">
	  			<div class="panel-heading">
	  				<h3>Solicitud de Negociación Creada con Exito</h3>
	  			</div>
			    <div class="panel-body">
			    	<h4>
			    		<strong>Estado Negociación: {{$aprobador[0]['estadoHisProceso']['ser_descripcion']}}</strong>
			    	</h4>
			    	<div class="col-sm-4">
			    		<ul class="list-group">
						  <li class="list-group-item"><strong>No. Negociación:</strong></li>
						  <li class="list-group-item"><strong>Cliente: </strong></li>
						  <li class="list-group-item"><strong>Periodo de Negociación: </strong></li>
						  <li class="list-group-item"><strong>Costo Total Negociación: </strong></li>
						</ul>
			    	</div>
			    	<div class="col-sm-4">
			    		<ul class="list-group">
						  <li class="list-group-item">{{$negociacion['sol_id']}}</li>
						  <li class="list-group-item">{{$negociacion['cliente']['razonSocialTercero_cli']}}</li>
						  <li class="list-group-item">{{$negociacion['sol_peri_ejeini']}} a {{$negociacion['sol_peri_ejefin']}}</li>
						  <li class="list-group-item">{{number_format($negociacion['costo']['soc_valornego'], 0, '.', ',' )}}</li>
						</ul>
			    	</div>
			    	<div class="col-sm-4">
			    		<ul class="list-group">
							<li class="list-group-item">
								<img src="{{url('/images/negociaciones/negociacion.jpg')}}" class="img-rounded" alt="Cinque Terre" width="100%" height="100%"> 
						  	</li>
						</ul>
			    	</div>
			    	<div class="col-sm-12">
			    		<ul class="list-group">
							<li class="list-group-item">
								<strong>Se ha enviado la solicitud para ser evaluada a los siguientes usuarios:</strong>
						  	</li>
							@foreach ($aprobador as $key => $value)
							  	<li class="list-group-item">
							  		{{$value['terceroRecibe']['razonSocialTercero']}} <br>
							  		({{$value['dirNacionalRecibe']['dir_txt_email']}})
							  	</li>
							@endforeach
						</ul>
			    	</div>
			    </div>
			    <div class="panel-footer">
			    	@if(isset($validacion))
				    	@if($validacion == false)
		  					<a type="button" class="btn btn-primary" href="{{$urlMisSolicitudes}}"><i class="glyphicon glyphicon-home"></i> Mis solicitudes </a>
						@else
							<a type="button" class="btn btn-primary" href="{{$urlMisSolicitudes}}"><i class="glyphicon glyphicon-home"></i> Bandeja de Aprobación </a>
						@endif
	  				@endif
	  			</div>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection
