<?php

namespace App\Http\Controllers\negociaciones;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Mail;
use App\Mail\notificacionEstadoSolicitudNego;

use App\Models\negociaciones\TSolEnvioNego;
use App\Models\negociaciones\TPernivele;
use App\Models\negociaciones\TPernivLinea;
use App\Models\negociaciones\TSolicitudNego;
use App\Models\negociaciones\TSoliCostosLineas;
use App\Models\Genericas\TDirNacional;

class bandejaAprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ruta = "NEGOCIACIONES V2 // BANDEJA APROBACIÓN";
        $titulo = "BANDEJA APROBACIÓN";   
        if (isset($request->all()['redirecTo'])) {
          $adelante = $request->all()['redirecTo']; 
          $id = $request->all()['id'];
          if ($adelante == 'elaboracion') {
              $solicitud = TSolicitudNego::where('sol_id', $id)->first();

              if ($solicitud['sol_ser_id'] == 2 && $solicitud['sol_sef_id'] == 2) {
                $aprobador = TSolEnvioNego::with('estadoHisProceso', 'terceroRecibe', 'dirNacionalRecibe')->where('sen_sol_id', $id)->orderBy('sen_id', 'desc')->take(2)->get();
              }else{
                $aprobador = TSolEnvioNego::with('estadoHisProceso', 'terceroRecibe', 'dirNacionalRecibe')->where([['sen_sol_id', $id], ['sen_estadoenvio', 1]])->get();
              }
              // Retorna la url de misolicitudes
              $urlMisSolicitudes = route('bandejaAprobacionNegociacion.index');
              $negociacion = TSolicitudNego::with('cliente', 'costo')->where('sol_id', $id)->first();
              $validacion = true;
              $response = compact('aprobador', 'ruta', 'titulo', 'negociacion', 'urlMisSolicitudes', 'validacion');
              return view('layouts.negociaciones.mensajeEnvioSolicitud', $response);
          }
        }    
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
        // Obtengo la informacion del request
        $data = $request->all();
        // Obtengo la negociacion
        $negociacion = TSolicitudNego::find($data['sol_id']);
        // Creo arreglo de errores
        $errorRuta = [];
        // Obtengo el pernivel del usuario aprobador
        $pernivel = TPernivele::with('canales')->where('pen_cedula', $data['usuarioAprobador']['idTerceroUsuario'])->first();

        if ($pernivel == null) {
            array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
        }

        // Valido si ahi tiponegociacionsol
        if (isset($data['tipoNegociacionSol'])) {
          // Si el nivel es 2 y la negociacion es comercial
          if ($pernivel['pen_nomnivel'] == 2 && $data['tipoNegociacionSol'] == "Comercial") {
            // Valido que exista el pernivel 
            if (!isset($pernivel)) {
              // Genero error si no encuentro la persona en los niveles de autorizacion
              array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{
              // Valido si el pernivel tiene canales
              if($pernivel['canales'] == null){
                // si no encuentra canales genera error
                array_push($errorRuta, 'No se encontraron canales asociados al usuario aprobador');
              }else{
                // Si encuentra canales busca entre esos canales el canal de la solicitud
                $pernivCanal = collect($pernivel['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
                $pernivCanal = array_values($pernivCanal);
                // Valida si encuentra el canal de la solicitud
                if (count($pernivCanal) > 0) {
                    // Si lo encuentra busca el aprobador osea el padre
                    $padre = TPernivele::with('canales')->where('id', $pernivCanal[0]['pcan_aprobador'])->first();
                    // Busco en base de datos si existe otro registro con el mismo usuario envia - recibe y numero de solicitud
                    $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $padre['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                    // Busco en los canales del padre algun otro registro on el mismo canal
                    $validaCanal = collect($padre['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
                    // Busco en perniveles al vendedor
                    $cedulaPersona = $negociacion['sol_ven_id'];
                    $pernivelVendedor = TPernivele::where('pen_cedula', $cedulaPersona)->first();
                    // Con el vendedor valido el paso siguiente
                    if ($pernivelVendedor['pen_idtipoper'] == 1) {
                        $pasoSig = 3;
                    }else if ($pernivelVendedor['pen_idtipoper'] == 2) {
                        $pasoSig = 13;
                    }
                    // Si encuentra padre y cumple con las validaciones
                    if (isset($padre) && count($validacion) == 0 && count($validaCanal) > 0) {
                      // Actualiza el estado de todas la ruta de aprobacion a cero
                      $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                      // Actualiza la negociacion como comercial
                      $negociacion->update(['sol_ser_id' => 13, 'sol_tipnegoniv' => 'Comercial']);
                      // Crea un nuevo paso
                      $observacion = "";
                      if (isset($data['observ'])) {
                          $observacion = $data['observ']; 
                      }
                      // Crea la ruta
                      $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$padre['pen_cedula'], 1, $observacion, $pasoSig, null);
                    }else{
                      // Error cuando no se encuentra la persona para la siguiente ruta
                      array_push($errorRuta, 'No se encontro ruta de aprobacion para el canal seleccionado');
                    }
                }else{
                  // Error con el pernivel
                  array_push($errorRuta, 'Favor validar el nivel siguiente al usuario actual en los niveles de autorizacion');
                }
              }
            } 
          }          
          // Valido si es nivel 2 y el tipo de negociacion seleccionado en la vista es comercial o mercadeo
          if ($pernivel['pen_nomnivel'] == 2 && ($data['tipoNegociacionSol'] == "Mercadeo" || $data['tipoNegociacionSol'] == "Comercial y Mercadeo")) {
            // Obtengo los costos de la negociacion
            $costo = $negociacion->costo()->get();
            // Obtengo las lineas de los costos de la solicitud
            $arrLineas = TSoliCostosLineas::where('scl_soc_id', $costo[0]['soc_id'])->get();
            if (count($arrLineas) > 0) {
              // Obtengo los id de las lineas de la solicitud 
              $idsLineas = collect($arrLineas)->pluck('scl_lin_id');
              // Consulto pernivel y obtengo los canales y de cada canal obtengo las lineas donde el tipo persona sea 3 y el nivel sea 2
              $perniveles = TPernivele::with('canales', 'canales.lineas', 'canales.lineas.canal', 'canales.lineas.canal.pernivel')->where([['pen_idtipoper', 3], ['pen_nomnivel', 2]])->get();
              // Obtengo solo los canales
              $collection = collect($perniveles)->pluck('canales')->collapse()->all();
              // Filtro los canales por el canal de la solicitud
              $collection = collect($collection)->where('pcan_idcanal', $data['sol_can_id'])->all();
              // Obtengo las lineas de los canales filtrados y las filtro por el id de las lineas de la solicitud
              $collection = collect(collect($collection)->pluck('lineas')->collapse()->all())->whereIn('pcan_idlinea', $idsLineas)->all();
              // Otengo de cada linea obtenida su pernivel asociado regresandome en la relacion
              $perniveles = collect($collection)->pluck('canal.pernivel');
              // Agrupo los perniveles por cedula para no repetir registros
              $perniveles = collect($perniveles)->groupBy('pen_cedula')->toArray();
              $arreglo = [];
              foreach ($perniveles as $key => $value) {
                array_push($arreglo, $value[0]);
              }
              $perniveles = $arreglo;
              // Actualizo los estados anteriores de el historico
              $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
              // Actualizo la negociacion con el tipo de solicitud sea mercadeo o comercial y mercadeo
              $negociacion->update(['sol_ser_id' => 4, 'sol_tipnegoniv' => $data['tipoNegociacionSol']]);
              // Recorro las personas de mercadeo que apruban para estas lineas
              $estado = 1;
              foreach ($perniveles as $key => $value) {
                // Valido si existe el registro que quiero crear en los niveles de aprobacion
                if($key == 0){
                  $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $value['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                }else{
                  $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $perniveles[$key - 1]['pen_cedula']], ['sen_idTercero_recibe', $value['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                }
                
                // Si no existe el registro que quiero crear lo creo
                if (count($validacion) == 0) {
                  // Crea la ruta
                  if($key == 0){
                    $envia = $pernivel['pen_cedula'];
                  }else{
                    $envia = $perniveles[$key - 1]['pen_cedula'];
                  } 
                  // Genero la ruta
                  $observacion = "";
                  if (isset($data['observ'])) {
                      $observacion = $data['observ']; 
                  }
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $envia, $value['pen_cedula'], $estado, $observacion, 4, $key + 1);
                  $estado = 2;
                }
              }     
            }else{
              array_push($errorRuta, 'No se encontraron lineas en la solicitud por favor validar');
            }
          }
        }   

        // Valida si el nivel es 3 y es comercial
        if ($data['sol_tipnegoniv'] == "Comercial") {
          if ($pernivel['pen_nomnivel'] == 3) {
            // Valida que el pernivel exista
            if (!isset($pernivel)) {
              // Si no existe genera error
              array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{
              // Si existe consulta los perniveles con canales donde el tipo de persona sea 1 y el nivel sea 4
              $padre = TPernivele::with('canales')->where([['pen_idtipoper', 1], ['pen_nomnivel', 4]])->first();
              // Valida que no exista una ruta con el mismo usuario envia, recibe y id de la negociacion
              $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $padre['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
              // Si encunetra el padre y la consulta no retorna nada
              if (isset($padre) && count($validacion) == 0) {
                // Actualiza el estado de los historicos a inactivos
                $updateEstadosAnterior =  TSolEnvioNego::where('sen_sol_id', $data['sol_id'])
                                          ->update(['sen_estadoenvio' => 0]);
                // Actualiza el estado de la negociacion
                $negociacion->update(['sol_ser_id' => 6]);
                // Crea un nuevo paso
                $observacion = "";
                if (isset($data['observ'])) {
                    $observacion = $data['observ']; 
                }
                // Si la negociacion es mayor a 5000000
                if ($data['costo']['soc_valornego'] > 5000000) {
                  // Crea la ruta
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$padre['pen_cedula'], 1, $observacion, 6, null);
                }else{
                  // Busco en la ruta de aprobacion el filtro
                  $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$filtro['sen_idTercero_recibe'], 0, $observacion, 2, null);
                  // Creo el paso siguiente 
                  $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$data['sol_ven_id'], 0, $observacion, 3, null);
                }
              }else{
                  array_push($errorRuta, 'No se encontro ruta de aprobacion para el canal seleccionado');
              }            
            } 
          }
          // si el nivel es 4 y el tipo de negociacion es comercial 
          if ($pernivel['pen_nomnivel'] == 4) {
            if (!isset($pernivel)) {
              // Si no existe genera error
              array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{              
              // Actualizo los estados de historico a inactivos
              $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
              // Cambio el estado de la solicitud a aprobada
              $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);     
              // Crea un nuevo paso
              $observacion = "";
              if (isset($data['observ'])) {
                  $observacion = $data['observ']; 
              }
              // Rutas de la evaluacion 
              // Ruta creador
              $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$data['sol_ven_id'], 0, $observacion, 6, null, 'evaluacion');
              // Ruta Filtro
              $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
              $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$filtro['sen_idTercero_recibe'], 0, $observacion, 6, null, 'evaluacion');
            }
          }
        }

        // si el nivel es 2 y el tipo de negociacion es mercadeo o comercial y mercadeo
        if ($pernivel['pen_nomnivel'] == 2 && ($data['sol_tipnegoniv'] == "Mercadeo" || $data['sol_tipnegoniv'] == "Comercial y Mercadeo")) {
          // Busco en los nvieles de autorizacion los que tengan en estado dos que implica que estan en cola de aprobacion
          $nivelesSinActivar = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'estadoHisProceso', 'solicitud.cliente', 'solicitud.costo', 'solicitud.costo.formaPago')->where('sen_estadoenvio', 2)
          ->where('sen_sol_id',  $data['sol_id'])->get();
          // Si hay niveles sin activar entonces activo el primero que me encuentro
          if (count($nivelesSinActivar) > 0) {
            // Consulto en la ruta donde el usuario que recibe es igual a el que entro a aprobar y inactivo este registro en los niveles de autorizacion
            $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
            ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
            // Activa el siguiente
            $primerNivel = $nivelesSinActivar[0]->update(['sen_estadoenvio' => 1]);
            $correo = TDirNacional::where('dir_txt_cedula', $nivelesSinActivar[0]['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
            Mail::to($correo)->send(new notificacionEstadoSolicitudNego($nivelesSinActivar[0]));
            if(Mail::failures()){
              return response()->json(Mail::failures());
            }
          }else{
            // Si no voy a crear la nueva ruta para el siguiente nivel
            // Obtengo los costos de la negociacion
            $costo = $negociacion->costo()->get();            
            // Obtengo las lineas de los costos de la solicitud
            $arrLineas = TSoliCostosLineas::where('scl_soc_id', $costo[0]['soc_id'])->get();
            $idsLineas = collect($arrLineas)->pluck('scl_lin_id');
            // consulto los perniveles con sus canales y lineas por canales donde el tipo de persona sea 3 y el nivel sea 3
            $perniveles = TPernivele::with('canales', 'canales.lineas', 'canales.lineas.canal', 'canales.lineas.canal.pernivel')->where([['pen_idtipoper', 3], ['pen_nomnivel', 3]])->get();
            $collection = collect($perniveles)->pluck('canales')->collapse()->all();
            // Filtro lo obtenido por las lineas de la solicitud obteniendo los perniveles de nivel 3 que aprueban esas lineas
            $collection = collect(collect($collection)->pluck('lineas')->collapse()->all())->whereIn('pcan_idlinea', $idsLineas)->all();
            $perniveles = collect($collection)->pluck('canal.pernivel');
            $perniveles = collect($perniveles)->groupBy('pen_cedula')->toArray();
            $arreglo = [];
            foreach ($perniveles as $key => $value) {
              array_push($arreglo, $value[0]);
            }
            $perniveles = $arreglo;

            if ($data['sol_tipnegoniv'] == "Comercial y Mercadeo") {
              // Consulta la cedula de la persona que esta como filtro en el historial de aprobacion 
              $cedulaFiltro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first()['sen_idTercero_recibe'];
              // obtengo el pernivel de la persona que esta como filtro
              $canalesFiltro = TPernivele::with('canales')->where('pen_cedula', $cedulaFiltro)->first();
              // Filtro los canales del filtro por el canal de la solicitud
              $pernivCanal = collect($canalesFiltro['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
              // Obtengo el id del aprobador par esos canales
              $padre = TPernivele::with('canales')->where('id', $pernivCanal[0]['pcan_aprobador'])->first();
            }
           
            $condicionales = true;
            if (count($perniveles) == 0) {
              array_push($errorRuta, 'No existe ruta de aprobacion de mercadeo para las lineas de la solicitud');
              $condicionales = false;
            }
            if($data['sol_tipnegoniv'] == "Comercial y Mercadeo" && $padre == null){
              array_push($errorRuta, 'No existe un nivel comercial en la ruta de aprobacion');
              $condicionales = false;
            }

            if ($condicionales) { 
              // Actualizo los estados anteriores
              $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
              // Actualizo el estado de la solicitud
              $negociacion->update(['sol_ser_id' => 5]);
              $estado = 1;

              // Recorro los perniveles
              foreach ($perniveles as $key => $value) {
                // Valido que lo que intento crear no exista ya para esta solicitud
                if($key == 0){
                  $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $value['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                }else{
                  $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $perniveles[$key - 1]['pen_cedula']], ['sen_idTercero_recibe', $value['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                }
                // Si no existe empiezo a crear
                if (count($validacion) == 0) {
                  if($key == 0){
                    $envia= $pernivel['pen_cedula'];
                  }else{
                    $envia = $perniveles[$key - 1]['pen_cedula'];
                  }
                  // Genero la ruta
                  $observacion = "";
                  if (isset($data['observ'])) {
                      $observacion = $data['observ']; 
                  }
                  // Guardo la ruta
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $envia, $value['pen_cedula'], $estado, $observacion, 5, $key + 1);
                  $estado = 2;
                  // Variable que al final de la iteracion va a tener el ultimo
                  $siguiente = $objTSolEnvioNego;
                }
              } 
              // Si la ruta es comercial y mercadeo debe crear un paso adicional que es para comercial canal
              if ($data['sol_tipnegoniv'] == "Comercial y Mercadeo") {
                // Valido cual es el estado del paso que voy a crear dependiendo del tipo de persona
                $cedulaPersona = $negociacion['sol_ven_id'];
                $pernivelVendedor = TPernivele::where('pen_cedula', $cedulaPersona)->first();
                $negociacion->update(['sol_ser_id' => 13]);
                if ($pernivelVendedor['pen_idtipoper'] == 1) {
                  $pasoSig = 3;
                }else if ($pernivelVendedor['pen_idtipoper'] == 2) {
                  $pasoSig = 13;
                }
                // Crea la ruta faltante que seria para comercial debido a que la de mercadeo ya se creo arriba
                $objTSolEnvioNego = self::createObject($data['sol_id'], $siguiente['sen_idTercero_recibe'], $padre['pen_cedula'], 2, $observacion, $pasoSig, $key + 2);
              }
            }
          }
        }

        // Si el nivel es 3 y el tipo de negociacion es mercadeo
        if ($pernivel['pen_nomnivel'] == 3 && $data['sol_tipnegoniv'] == "Mercadeo") {
          // valida si el usuario se encuentra creado en los niveles de autorizacion
          if (!isset($pernivel)) {
            // Si no esta creado genera error
            array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
          }else{
            // Si esta creado busca en la ruta de aprobacion el registro y le cambia el estado a aprobado
            $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
            ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
            // Busca en la ruta de aproabcion si hay otro paso por activar
            $nivelesSinActivar = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'estadoHisProceso', 'solicitud.cliente', 'solicitud.costo', 'solicitud.costo.formaPago')->where('sen_estadoenvio', 2)
            ->where('sen_sol_id',  $data['sol_id'])->get();

            if (count($nivelesSinActivar) > 0) {
              // Si encuentra uno lo pone activo para que aparesca en la bandeja
              $primerNivel = $nivelesSinActivar[0]->update(['sen_estadoenvio' => 1]);
              $correo = TDirNacional::where('dir_txt_cedula', $nivelesSinActivar[0]['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
              Mail::to($correo)->send(new notificacionEstadoSolicitudNego($nivelesSinActivar[0]));
              if(Mail::failures()){
                return response()->json(Mail::failures());
              }
            }else{
              // Si no hay mas empieza la creacion de la nueva ruta de aprobacion

              $observacion = "";
              if (isset($data['observ'])) {
                  $observacion = $data['observ']; 
              }
              // Valida si el monto es menor a 5000000
              if ($data['costo']['soc_valornego'] <= 5000000) {
                // Cambia el estado de la solicitud a aprobada
                $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);

                // Ruta creador
                $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$data['sol_ven_id'], 0, $observacion, 5, null);
                // Ruta Filtro
                $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
                $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'],$filtro['sen_idTercero_recibe'], 0, $observacion, 5, null);
              }
              // Si el monto es mayor a 5000000
              if ($data['costo']['soc_valornego'] > 5000000) { 
                $padre = TPernivele::with('canales')->where([['pen_idtipoper', 3], ['pen_nomnivel', 4]])->first();
                if ($padre == null) {
                  array_push($errorRuta, 'No existe un nivel comercial en la ruta de aprobacion');
                }else{
                  // Acutualiza el estado de la solicitud
                  $negociacion->update(['sol_ser_id' => 7]);      
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $padre['pen_cedula'], 1, $observacion, 7, null);
                }                
              }
            }
          } 
        }

        // Si el nivel es 3 y el tipo de negociacion es Comercial y mercadeo
        if ($pernivel['pen_nomnivel'] == 3 && $data['sol_tipnegoniv'] == "Comercial y Mercadeo") {
           if (!isset($pernivel)) {
              // Genera error si el usuario que aprueba la solicitud no esta en los niveles de autorizacion 
              array_push($errorRuta, 'El usuario que aprueba la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{
              // Consulta la ruta si existe un paso sin activar consecutivo
              $nivelesSinActivar = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'estadoHisProceso', 'solicitud.cliente', 'solicitud.costo', 'solicitud.costo.formaPago')->where('sen_estadoenvio', 2)
              ->where('sen_sol_id',  $data['sol_id'])->get();

              if (count($nivelesSinActivar) > 0) {
                // Cambia el estado de la ruta para el usuario que aprueba a aprobado
                $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
                ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                // Si encuentra un paso sin activar lo activa
                $primerNivel = $nivelesSinActivar[0]->update(['sen_estadoenvio' => 1]);
                $correo = TDirNacional::where('dir_txt_cedula', $nivelesSinActivar[0]['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
                Mail::to($correo)->send(new notificacionEstadoSolicitudNego($nivelesSinActivar[0]));
                if(Mail::failures()){
                  return response()->json(Mail::failures());
                }
              }else{
                // Si no empieza la creacion del siguiente nivel
                $observacion = "";
                if (isset($data['observ'])) {
                    $observacion = $data['observ']; 
                }
                // Si el monto es menor a 5000000
                if ($data['costo']['soc_valornego'] <= 5000000) {
                  // Cambia el estado de la ruta para el usuario que aprueba a aprobado
                  $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
                  ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                  // Cambia el estado de la negociacion a aprobado
                  $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);

                  // Ruta creador                 
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $data['sol_ven_id'], 0, $observacion, 5, null);

                  // Ruta filtro                  
                  $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
                  $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $filtro['sen_idTercero_recibe'], 0, $observacion, 5, null);                  
                }

                // Si el monto de la negociacion es mayor a 5000000
                if ($data['costo']['soc_valornego'] > 5000000) { 
                  // Consulta los niveles de autorizacion con sus canales donde el nivel sea 4
                  $padres = TPernivele::with('canales')->where('pen_nomnivel', 4)->get();

                  if (count($padres) > 0) {
                    // Cambia el estado de la ruta para el usuario que aprueba a aprobado
                    $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]); 
                    // Actualiza el estado de la negociacion a 7
                    $negociacion->update(['sol_ser_id' => 7]);    
                    
                    $estado = 1;
                    // Por cada nivel genera un registro en la ruta de aprobacion 
                    foreach ($padres as $key => $value) {
                      if ($key == 0) {
                        $envia = $pernivel['pen_cedula'];
                      }else{
                        $envia = $anterior['sen_idTercero_recibe'];
                      }
                      if ($value['pen_idtipoper'] == 1) {
                        $ser = 6;  
                      }else{
                        $ser = 7; 
                      }   
                      $objTSolEnvioNego = self::createObject($data['sol_id'], $envia, $value['pen_cedula'], $estado, $observacion, $ser, $key + 1);      
                      $estado = 2;
                      $anterior = $objTSolEnvioNego;
                    }  
                  }                                 
                }else{
                  array_push($errorRuta, 'No se encontro ruta de aprobacion para el siguiente nivel, por favor');
                }
              }
            } 
        }

        // Si el nivel es 4 y el tipo de negociacion es Mercadeo
        if ($pernivel['pen_nomnivel'] == 4 && $data['sol_tipnegoniv'] == "Mercadeo") {
          // Busca en la ruta el paso del aprobador a actual y le cambia el estado a probado
          $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
            ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
          // Deja la solicitud en estado aproabada
          $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);

          // Si no empieza la creacion del siguiente nivel
          $observacion = "";
          if (isset($data['observ'])) {
              $observacion = $data['observ']; 
          }
          // Ruta creador                 
          $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $data['sol_ven_id'], 0, $observacion, 7, null);
          // Ruta filtro                  
          $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
          $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $filtro['sen_idTercero_recibe'], 0, $observacion, 7, null);  
        }

        // Si el nivel es 4 y el tipo de solicitud es comercial y mercadeo
        if ($pernivel['pen_nomnivel'] == 4 && $data['sol_tipnegoniv'] == "Comercial y Mercadeo") {
          // Cambia el estado al paso actual
          $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
          ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
          // Consulta si ahi pasos sin activar
          $nivelesSinActivar = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'estadoHisProceso', 'solicitud.cliente', 'solicitud.costo', 'solicitud.costo.formaPago')->where('sen_estadoenvio', 2)
          ->where('sen_sol_id',  $data['sol_id'])->get();
          if (count($nivelesSinActivar) > 0) {
            // Si encuentra pasos sin activar, activa el primero
            $primerNivel = $nivelesSinActivar[0]->update(['sen_estadoenvio' => 1]);
            $correo = TDirNacional::where('dir_txt_cedula', $nivelesSinActivar[0]['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
            Mail::to($correo)->send(new notificacionEstadoSolicitudNego($nivelesSinActivar[0]));
            if(Mail::failures()){
              return response()->json(Mail::failures());
            }
          }else{
            // consulta la ruta de aprobacion y actualiza los que esten en estado 0
            $nivelesCreados = TSolEnvioNego::where('sen_idTercero_recibe', $pernivel['pen_cedula'])
              ->where('sen_sol_id',  $data['sol_id'])->update(['sen_estadoenvio' => 0]);
            // Cambia el estado de la solicitud a aprobada
            $negociacion->update(['sol_sef_id' => 2, 'sol_ser_id' => 2]);
            // Ruta creador          
            $observacion = "";
            if (isset($data['observ'])) {
                $observacion = $data['observ']; 
            }       
            $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $data['sol_ven_id'], 0, $observacion, 7, null);
            // Ruta filtro                  
            $filtro = TSolEnvioNego::where([['sen_sol_id', $data['sol_id']], ['sen_ser_id', 2]])->first();
            $objTSolEnvioNego = self::createObject($data['sol_id'], $pernivel['pen_cedula'], $filtro['sen_idTercero_recibe'], 0, $observacion, 7, null); 
          }            
        } 
        
        $url = route('bandejaAprobacionNegociacion.index', ['id' => $data['sol_id'], 'redirecTo' => 'elaboracion']);


        $response = compact('data', 'id', 'validacion', 'errorRuta', 'pernivCanal', 'padre', 'validaCanal', 'objTSolEnvioNego', 'pernivelVendedor', 'negociacion', 'idsLineas', 'costo', 'arrLineas', 'perniveles', 'pernivel', 'nivelesCreados', 'collection', 'anterior', 'arrrr', 'comprobacionruta', 'url');
        return response()->json($response);
    }

    public function createObject($sen_sol_id, $sen_idTercero_envia, $sen_idTercero_recibe, $sen_estadoenvio, $sen_observacion, $sen_ser_id, $sen_run_id, $verificar = null){
        $objTSolEnvioNego = new TSolEnvioNego;
        $objTSolEnvioNego['sen_sol_id'] = $sen_sol_id;
        $objTSolEnvioNego['sen_idTercero_envia'] = $sen_idTercero_envia;
        $objTSolEnvioNego['sen_idTercero_recibe'] = $sen_idTercero_recibe;
        $objTSolEnvioNego['sen_estadoenvio'] = $sen_estadoenvio;                     
        $objTSolEnvioNego['sen_observacion'] = $sen_observacion;      
        $objTSolEnvioNego['sen_ser_id'] = $sen_ser_id;                      
        $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
        $objTSolEnvioNego['sen_run_id'] = $sen_run_id;
        $objTSolEnvioNego->save();

        $objTSolEnvioNego = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'estadoHisProceso', 'solicitud.cliente', 'solicitud.costo', 'solicitud.costo.formaPago')->where('sen_id', $objTSolEnvioNego['sen_id'])->first();
        $objTSolEnvioNego['verificar'] = $verificar;

        if ($objTSolEnvioNego['sen_estadoenvio'] == 1 || ($objTSolEnvioNego['solicitud']['sol_ser_id'] == 2 && $objTSolEnvioNego['solicitud']['sol_sef_id'] == 2 && $objTSolEnvioNego['sen_estadoenvio'] == 0)) {
          $correo = TDirNacional::where('dir_txt_cedula', $objTSolEnvioNego['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
          Mail::to($correo)->send(new notificacionEstadoSolicitudNego($objTSolEnvioNego));
          if(Mail::failures()){
            return response()->json(Mail::failures());
          }
        }
        return $objTSolEnvioNego;
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
