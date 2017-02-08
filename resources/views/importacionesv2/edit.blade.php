@extends('importacionesv2.base')
@section('generic')
<!-- if there are creation errors, they will show here -->


{{ Form::model($objeto, array('route' => array($route, $id), 'method' => 'PUT')) }}

@foreach($campos as $key => $value )

@if($value[2] == 'hidden')
{{ Form::hidden("$value[0]") }}
@endif

@if($value[2] == 'text')
<div class="form-group">
    {{ Form::label('', "$value[3]") }}

    @if($value[2] == 'text')
    {{ Form::text("$value[0]", old("value[0]"), array('class' => 'form-control')) }}
    @endif
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
@endsection
