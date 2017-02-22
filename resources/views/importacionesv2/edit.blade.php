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
@endsection
