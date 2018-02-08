<?php

namespace App\Http\Controllers\negociaciones;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;


use App\Models\negociaciones\TSolEnvioNego;
use App\Models\negociaciones\TPernivele;
use App\Models\negociaciones\TSolicitudNego;
use App\Models\negociaciones\TSoliCostosLineas;

class bandejaAprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "NEGOCIACIONES V2 // BANDEJA APROBACIÓN";
        $titulo = "BANDEJA APROBACIÓN";   
        $response = compact('ruta', 'titulo');
        return view('layouts.negociaciones.bandejaAprobacion', $response);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()
    {
        // obtengo usuario logueado
        $usuario = Auth::user();
        $pernivelUsu = TPernivele::where('pen_cedula', $usuario['idTerceroUsuario'])->first();
        $solEnvioNego = TSolEnvioNego::where([['sen_idTercero_recibe', $usuario['idTerceroUsuario']], ['sen_estadoenvio', 1]])->get();
        $solEnvioNego = collect($solEnvioNego)->groupBy('sen_sol_id')->keys()->all();
        $solicitudes = TSolicitudNego::with('costo', 'costo.lineas', 'costo.lineas.lineasDetalle', 'costo.lineas.lineasDetalle.categorias', 'costo.motivo', 'costo.motivo.motAdicion', 'costo.detalle', 'estado', 'cliente', 'canal', 'listaPrecios', 'vendedor', 'zona', 'clasificacion', 'hisProceso', 'hisProceso.estadoHisProceso', 'hisProceso.terceroEnvia', 'hisProceso.terceroRecibe', 'costo.tipoBono.bono', 'soliZona', 'soliZona.hisZona', 'soliZona.hisZona.cOperacion', 'soliSucu', 'soliSucu.hisSucu', 'soliTipoNego', 'soliTipoNego.tipoNego', 'causal', 'causal.causalDetalle', 'evento', 'objetivo', 'cumplimiento', 'verificacionCobro', 'verificacionCobro.documento', 'verificacionCobro.proveedor', 'reviExhibicion', 'reviExhibicion.usuario', 'actaEntrega', 'actaEntrega.usuario', 'tesoHistorial', 'tesoAuditoria', 'tesoAuditoria.usuario')->whereIn('sol_id', $solEnvioNego)->where('sol_sef_id', 1)->get();
        $response = compact('usuario', 'solEnvioNego', 'solicitudes', 'pernivelUsu');
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
        //
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
        $data = $request->all();
        $negociacion = TSolicitudNego::find($data['sol_id']);
        $errorRuta = [];
        $pernivel = TPernivele::with('canales')->where('pen_cedula', $data['usuarioAprobador']['idTerceroUsuario'])->first();

        if ($pernivel['pen_nomnivel'] == 2 && $data['tipoNegociacionSol'] == "Comercial") {
            if (!isset($pernivel)) {
                array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{
                 if($pernivel['canales'] == null){
                    array_push($errorRuta, 'No se encontraron canales asociados al usuario aprobador');
                }else{
                    $pernivCanal = collect($pernivel['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
                    if (count($pernivCanal) > 0) {
                        $padre = TPernivele::with('canales')->where('id', $pernivCanal[0]['pcan_aprobador'])->first();
                        $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $padre['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                        $validaCanal = collect($padre['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
                        $cedulaPersona = $negociacion['sol_ven_id'];
                        $pernivelVendedor = TPernivele::where('pen_cedula', $cedulaPersona)->first();
                        if ($pernivelVendedor['pen_idtipoper'] == 1) {
                            $pasoSig = 3;
                        }else if ($pernivelVendedor['pen_idtipoper'] == 2) {
                            $pasoSig = 13;
                        }
                        if (isset($padre) && count($validacion) == 0 && count($validaCanal) > 0) {
                            $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                            $negociacion->update(['sol_ser_id' => 13, 'sol_tipnegoniv' => 'Comercial']);
                            $objTSolEnvioNego = new TSolEnvioNego;
                            $objTSolEnvioNego['sen_sol_id'] = $data['sol_id'];
                            $objTSolEnvioNego['sen_ser_id'] = $pasoSig;
                            $objTSolEnvioNego['sen_idTercero_envia'] = $pernivel['pen_cedula'];
                            $objTSolEnvioNego['sen_idTercero_recibe'] = $padre['pen_cedula'];
                            $objTSolEnvioNego['sen_observacion'] = $data['observ']; 
                            $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
                            $objTSolEnvioNego['sen_estadoenvio'] = 1;
                            $objTSolEnvioNego['sen_run_id'] = null;
                            $objTSolEnvioNego->save();
                        }else{
                            array_push($errorRuta, 'No se encontro ruta de aprobacion para el canal seleccionado');
                        }
                    }else{
                        array_push($errorRuta, 'Favor validar el nivel siguiente al usuario actual en los niveles de autorizacion');
                    }
                }
            } 
        }

        if ($pernivel['pen_nomnivel'] == 2 && $data['tipoNegociacionSol'] == "Mercadeo") {
          $costo = $negociacion->costo()->get();
          $arrLineas = TSoliCostosLineas::where('scl_soc_id', $costo['soc_id'])->get();
          if (count($arrLineas) > 0) {
              $idsLineas = collect($arrLineas)->pluck('scl_lin_id');
          }else{
            array_push($errorRuta, 'No se encontraron lineas en la solicitud por favor validar');
          }
        }

        if ($pernivel['pen_nomnivel'] == 3 && $data['sol_tipnegoniv'] == "Comercial") {
           if (!isset($pernivel)) {
                array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{
                $padre = TPernivele::with('canales')->where([['pen_idtipoper', 1], ['pen_nomnivel', 4]])->first();
                $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $padre['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();

                if (isset($padre) && count($validacion) == 0) {
                    $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                    $negociacion->update(['sol_ser_id' => 6]);
                    $objTSolEnvioNego = new TSolEnvioNego;
                    $objTSolEnvioNego['sen_sol_id'] = $data['sol_id'];
                    $objTSolEnvioNego['sen_idTercero_envia'] = $pernivel['pen_cedula'];
                    if ($data['costo']['soc_valornego'] > 5000000) {
                        $objTSolEnvioNego['sen_idTercero_recibe'] = $padre['pen_cedula'];
                        $objTSolEnvioNego['sen_estadoenvio'] = 1;
                        $objTSolEnvioNego['sen_ser_id'] = 6;
                    }else{
                        $objTSolEnvioNego['sen_idTercero_recibe'] = null;
                        $objTSolEnvioNego['sen_estadoenvio'] = 0;
                        $objTSolEnvioNego['sen_ser_id'] = 12;
                    }

                    if (isset($data['observ'])) {
                        $objTSolEnvioNego['sen_observacion'] = $data['observ']; 
                    }else{                        
                        $objTSolEnvioNego['sen_observacion'] = ""; 
                    }
                    
                    $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
                    $objTSolEnvioNego['sen_run_id'] = null;
                    $objTSolEnvioNego->save();

                    if ($data['costo']['soc_valornego'] <= 5000000) {
                        $negociacion->update(['sol_sef_id' => 6, 'sol_ser_id' => 12]);
                    }
                }else{
                    array_push($errorRuta, 'No se encontro ruta de aprobacion para el canal seleccionado');
                }
              
            } 
        }

        if ($pernivel['pen_nomnivel'] == 4 && $data['sol_tipnegoniv'] == "Comercial") {
            $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
            $negociacion->update(['sol_sef_id' => 6, 'sol_ser_id' => 12]);     
            $objTSolEnvioNego = new TSolEnvioNego;
            $objTSolEnvioNego['sen_sol_id'] = $data['sol_id'];
            $objTSolEnvioNego['sen_ser_id'] = 12;
            $objTSolEnvioNego['sen_idTercero_envia'] = $pernivel['pen_cedula'];
            $objTSolEnvioNego['sen_idTercero_recibe'] = null;
            if (isset($data['observ'])) {
                $objTSolEnvioNego['sen_observacion'] = $data['observ']; 
            }else{                        
                $objTSolEnvioNego['sen_observacion'] = ""; 
            }
            $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
            $objTSolEnvioNego['sen_estadoenvio'] = 0;
            $objTSolEnvioNego['sen_run_id'] = null;
            $objTSolEnvioNego->save();          
        }
        

        $response = compact('data', 'id', 'validacion', 'errorRuta', 'pernivCanal', 'padre', 'validaCanal', 'objTSolEnvioNego', 'pernivelVendedor', 'negociacion', 'idsLineas');
        return response()->json($response);
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
