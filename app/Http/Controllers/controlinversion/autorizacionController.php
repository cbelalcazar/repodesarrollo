<?php

namespace App\Http\Controllers\controlinversion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TLineas;
use App\Models\Genericas\TCanal;
use App\Models\controlinversion\TNiveles;
use App\Models\controlinversion\TSolestado;
use App\Models\controlinversion\TPerniveles;
use App\Models\controlinversion\TCanalpernivel;
use App\Models\controlinversion\TSolipernivel;
use App\Models\controlinversion\TSolhistorico;
use App\Models\controlinversion\TSolicitudctlinv;
use App\Models\BESA\VendedorZona;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class autorizacionController extends Controller
{


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      $ruta = "Control inversiones // Aprobacion de Solicitudes";
      $titulo = "Aprobar Solicitud";
      return view('layouts.controlinversion.solicitud.autorizacionSolicitud', compact('ruta', 'titulo'));
  }

  public function solicitudesAprobacionGetInfo()
  {

    $userLogged = Auth::user();
    $userExistPernivel = TPerniveles::where('pern_cedula', $userLogged->idTerceroUsuario)->get();
    $estados = TSolestado::whereIn('soe_id', ['5','2','3'])->get();

    if(count($userExistPernivel) > 0){

      if($userExistPernivel[0]->pern_nomnivel == 2 || $userExistPernivel[0]->pern_nomnivel == 3){

        if($userExistPernivel[0]->pern_nomnivel == 2){

            $solicitudesPorAceptar = TSolipernivel::where('sni_usrnivel', $userExistPernivel[0]->id)
            ->where('sni_estado',0)->with(
              'solicitud.tipoSalida',
              'solicitud.tpernivel',
              'solicitud.cargara',
              'solicitud.cargaralinea.lineasProducto',
              'solicitud.clientes.clientesReferencias.referencia',
              'solicitud.clientes.clientesReferencias.lineaProducto.lineasProducto',
              'solicitud.clientes.clientesZonas',
              'solicitud.estado',
              'solicitud.facturara.tercero',
              'solicitud.tipoPersona',
               'solicitud.clientes.clientesReferencias'
              )->get();

        }elseif($userExistPernivel[0]->pern_nomnivel == 3){
          $solicitudesPorAceptar = "No hay nada por ahora";
        }

      }else{
          return response()->json(['Message' => 'El usuario no tiene privilegios suficientes para aprobar solicitudes'],203);
      }

    }else{
      return response()->json(['Message' => 'El usuario no tiene privilegios suficientes para aprobar solicitudes'],203);
    }

    $response = compact('userLogged','userExistPernivel', 'solicitudesPorAceptar', 'estados');


    return response()->json($response);


  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->all();

    // Valida el estado de la solicitud, si es 3 se debe anular en la tabla y retornar exito
    if($data['estadoSolicitud']['soe_id'] == 3){
      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 3]);
      return 'exito';
    }
    // Valida el estado de la solicitud, si es 3 se debe ponerla en estado correcciones y retornar exito
    if($data['estadoSolicitud']['soe_id'] == 2){
      $actualizoEstadoSolicitud =  TSolicitudctlinv::where('sci_id', $data['sci_id'])->update(['sci_soe_id' => 2]);
      $objetoGuardar = TSolipernivel::where('sni_sci_id', $data['sci_id'])->orderBy('id', 'asc')->first();
      $borrapermisos = TSolipernivel::where('sni_sci_id', $data['sci_id'])->orderBy('id', 'asc')->delete();
      $borrapermisos;
      $creacion = TSolipernivel::create($objetoGuardar);

      return 'exito';
    }

    // Obtengo el canal
    $canal = $data['sci_can_id'];
    $clientes = $data['clientes'];

    // Obtengo las lineas de todas las referencias asociadas a cada cliente
    $lineasSolicitud = collect($data['clientes'])->pluck('clientes_referencias')->flatten(1)->groupBy('referencia.ite_cod_linea')->keys()->all();

    // Obtengo de los niveles de aprobacion las personas que aprueban para esa linea en ese canal
    $quienesSon = TCanalpernivel::where('cap_idcanal', trim($canal))->whereIn('cap_idlinea',$lineasSolicitud)->get();

    // Si no hay nadie que apruebe retorno error
    if (count($quienesSon) == 0) {
      return "errorNoExisteNivelTres";      
    }else{

      // Si no, creo la ruta de aprobacion
      $quienesSonAgrupados = $quienesSon->groupBy('cap_idpernivel')->keys()->all();
      $personaNiveles = TPerniveles::whereIn('id', $quienesSonAgrupados)->get();
      $contador = 1;

      // Actualizo estado anterior
      $update = TSolipernivel::where([['sni_cedula', $data['usuarioLogeado']['idTerceroUsuario']], ['sni_sci_id', $data['sci_id']]])->update(['sni_estado' => 1]);

      // Creo nuevos pasos
      foreach ($personaNiveles as $key => $value) {
        $grabo = TSolipernivel::create(['sni_usrnivel' => $value['id'], 'sni_cedula' => $value['pern_cedula'], 'sni_sci_id' => $data['sci_id'], 'sni_estado' => 0, 'sni_orden' => $contador]);
        $contador++;
      }

      // Genero el historico de aprobacion de nivel 2 a nivel 3
      $historico = new TSolhistorico;
      $historico->soh_sci_id = $data['sci_id'];
      $historico->soh_soe_id = $data['sci_soe_id'];
      $historico->soh_idTercero_envia = $data['usuarioLogeado']['idTerceroUsuario'];
      $historico->soh_idTercero_recibe = $personaNiveles[0]['pern_cedula'];
      if ($data['observacionEnvio'] == "") {
        $data['observacionEnvio'] = "SIN OBSERVACION";
      }
      $historico->soh_observacion =  $data['observacionEnvio'];
      $historico->soh_fechaenvio = Carbon::now();
      $historico->soh_estadoenvio = 1;
      $historico->save();


    }

    $response = compact('data', 'canal', 'lineasSolicitud', 'clientes', 'personaNiveles');
    return $response;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }


}
