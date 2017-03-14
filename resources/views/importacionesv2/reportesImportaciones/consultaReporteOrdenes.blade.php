@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')

<!-- ************************************ -->
<!-- General errors in form -->
<!-- ************************************ -->

<div class="form-group">
	@if ($errors->all())
	<div class="alert alert-danger" id="mensajealerta">
		@foreach($errors->all() as $key => $value)
		<span class="glyphicon glyphicon-remove red"></span>  {{$value}} <br>
		@endforeach
		<script> setTimeout(function(){ 
			$( "#mensajealerta" ).fadeToggle("slow");
		}, 5000);</script>
	</div>
	@endif
	@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
	@endif
</div>

<!-- ************************************ -->
<!-- End General errors in form -->
<!-- ************************************ -->

{{ Form::open(array('url' => "$url",'id' => "importacionform"))}}

<div class="col-xs-12">
	{{ Form::label('', "Consulta por estado") }}
	{{ Form::select('imp_estado_proceso', $estados, null, ['placeholder' => 'Selecciona un estado...', 'class' => 'form-control']) }}
</div>
<br><br><br><br>
<div class="form-group">
	
{{ Form::submit('Generar reporte', array('class' => 'btn btn-primary pull-right', 'id' => 'finalizar1')) }}

</div>
{{ Form::close() }}
@endsection

