<!-- app/views/nerds/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>{{$titulo}}</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="{{$url}}">Consultar Todos</a></li>
        <li><a href="{{ $url.'/create' }}">Crear</a>
    </ul>
</nav>

<h1>{{ $titulo }}</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <!-- Aqui se generan los titulos de la tabla-->
    <thead>
        <tr>
            @foreach($titulosTabla as $key => $value)
            <td>{{$value}}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
      <!-- Aqui se generan los registros de la tabla-->
    @foreach($datos as $key => $value)
        <tr>

          @foreach($campos as $nombre => $campo)
                  @if($campo[1] == '' || $campo[1] == 'string' || $campo[1] == 'int')
                            <td>{{$value->$campo[0]}}</td>
                  @elseif($campo[1] == 'boolean')

                            @if($value->$campo[0] == 1)
                                <td>SI</td>
                            @elseif($value->$campo[0] == 0)
                                <td>NO</td>
                            @endif
                  @endif
          @endforeach
            <td>
                <a class="btn btn-small btn-success" href="{{ URL::to("$url/" . $value->$campos[0][0]) }}">Visualizar</a>
                <a class="btn btn-small btn-info" href="{{ URL::to("$url/" . $value->$campos[0][0] . '/edit') }}">Editar</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</div>
</body>
</html>
