@extends('importacionesv2.base')
@section('generic')
<div class="portlet-body form">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif

  <table id="example" class="display" cellspacing="0" width="100%">
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
<script type="text/javascript">
$(document).ready( function () {
  $('#example').DataTable({
    responsive: true,
  });
} );
</script>
@endsection
