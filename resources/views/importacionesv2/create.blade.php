@extends('app')
@section('content')
<div class="container">

<nav class="navbar navbar-inverse">
  <ul class="nav navbar-nav">
        <li><a href="{{ $url }}">Consultar Todos</a></li>
        <li><a href="{{ $url.'/create' }}">Crear</a>
    </ul>
</nav>

<h1>CREAR {{$titulo}}</h1>

<!-- if there are creation errors, they will show here -->
{{ Html::ul($errors->all()) }}

{{ Form::open(array('url' => "$url")) }}
{{Form::token()}}

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
          <div class="checkbox disabled">
              <label>{{ Form::checkbox("$value[0]", '1') }}{{$value[3]}}</label>
          </div>
    @endif

    @endforeach
    {{ Form::submit('Crear', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}
{!! $validator  !!}
</div>
@endsection
