@extends('importacionesv2.base')
@section('generic')
{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT')) }}

@foreach($campos as $key => $value )
@if($value[2] == 'hidden')
{{ Form::hidden("$value[0]") }}
@elseif($value[2] == 'text')
<div class="form-group">
    {{ Form::label('', "$value[3]") }}
    {{ Form::text("$value[0]", old("value[0]"), array('class' => 'form-control')) }}
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
