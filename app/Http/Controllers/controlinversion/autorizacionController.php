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
use App\Models\BESA\VendedorZona;
use Illuminate\Support\Facades\Auth;


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
              'solicitud.tipoPersona'
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
