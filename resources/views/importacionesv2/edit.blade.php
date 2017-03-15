@extends('importacionesv2.base')
@section('generic')
<!-- /**
 * Template creado por
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */ -->
@foreach($errors->all() as $key => $value)
<div class="alert alert-danger">{{$value}}</div>
@endforeach
{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT')) }}
@foreach($campos as $key => $value )
@if($value[2] == 'hidden')
{{ Form::hidden("$value[0]") }}
@elseif($value[2] == 'text')
<div class="form-group">
    {{ Form::label('', "$value[3]") }}
    {{ Form::text("$value[0]", old("value[0]"), array('class' => 'form-control')) }}
</div>
@elseif($value[2] == 'autocomplete')
 <!-- Linea maritima -->
    <div class="form-group" id="linea_div">
      {{ Form::open(['action' => ['Importacionesv2\TImportacionController@autocomplete'], 'method' => 'post']) }}
      {{ Form::label('', "$value[3]:") }}
      {{ Form::text("$value[0]", old("value[0]"), ['class' => 'form-control', 'id' =>  "$value[0]"])}}

      {{ Form::label('', "") }}
      {{ Form::text("razonsocial$value[0]", '', ['class' => 'form-control', 'id' =>  "razonsocial$value[0]", 'readonly' =>  'readonly'])}}
    </div>
    <!-- End Linea maritima -->
@elseif($value[2] == 'select')
<div class="form-group">
    <label>{{$value[3]}}</label>
    {{  Form::select($value[0],$value[5], null, ['placeholder'=>$value[4], 'class' => 'form-control'] ) }}
</div>
@elseif($value[2] == 'checkbox')
<div class="mt-checkbox-list">
    <label class="mt-checkbox mt-checkbox-outline">{{$value[3]}}
        {{ Form::checkbox("$value[0]", '1') }}
        <span></span>
    </label>
</div>
@endif
@endforeach
{{ Form::submit('Editar', array('class' => 'btn btn-primary')) }}
{{ Form::close() }}
{!! $validator  !!}
@if(isset($javascriptImport))
<script src="{{url('/js/importacionesv2/crudsImportaciones.js')}}" type="text/javascript" language="javascript"></script>
 <input type="hidden" id="route1" value="{{route('search')}}">
 <link href="{{url('/css/importacionesv2.css')}}" type="text/css" rel="stylesheet"/>
@endif
@endsection
