@extends('importacionesv2.importacionTemplate.titulosbase')
@section('generic')
<br><br><br>

@foreach($errors->all() as $key => $value)
<div class="alert alert-danger">{{$value}}</div>
@endforeach
{{ Form::open(array('url' => "$route", 'id' => "formajax")) }}
@foreach($campos as $key => $value )
@if($value[2] == 'hidden')
{{ Form::hidden("$value[0]") }}
@elseif($value[2] == 'text')
<div class="form-group">
    {{ Form::label('', "$value[3]") }}
    {{ Form::text("$value[0]", old("value[0]"), array('class' => 'form-control', 'id' => "$value[0]")) }}
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
<input type="text" style='display: none;' disabled="disabled" size="1">
<input type="button" class="btn btn-primary" value="Crear Nueva" onclick="storeajax(document.getElementById('formajax').action, $('#formajax').serialize());">
{{ Form::close() }}
{!! $validator  !!}
@endsection
