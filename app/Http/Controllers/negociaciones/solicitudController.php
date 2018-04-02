<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\negociaciones\ClaseNegociacion;
use App\Models\negociaciones\NegociacionAnoAnterior;
use App\Models\negociaciones\TipNegociacion;
use App\Models\negociaciones\TipoNegociacion;
use App\Models\negociaciones\NegociacionPara;
use App\Models\negociaciones\EventoTemp;
use App\Models\negociaciones\TipoServicio;
use App\Models\negociaciones\CausalesNego;
use App\Models\negociaciones\TSolicitudNego;
use App\Models\negociaciones\TSoliZona;
use App\Models\negociaciones\TSoliSucursal;
use App\Models\negociaciones\TSoliCausalNego;
use App\Models\negociaciones\TBaseImpuesto;
use App\Models\negociaciones\TFormaPago;
use App\Models\negociaciones\TSoliTipoNego;
use App\Models\negociaciones\TSoliCostos;
use App\Models\negociaciones\TPernivele;
use App\Models\negociaciones\TSoliCostosLineas;
use App\Models\negociaciones\TSolEnvioNego;
use App\Models\negociaciones\TSoliObjetivos;
use App\Models\negociaciones\TKeyAccount;
use App\Models\negociaciones\TipoBono;
use App\Models\Genericas\TVendedor;
use App\Models\Genericas\TCanal;
use App\Models\Genericas\TCliente;
use App\Models\Genericas\TLineas;
use App\Models\Genericas\TListaPrecios;
use App\Models\Genericas\TSucursal;
use App\Models\Genericas\TDirNacional;
use App\Models\Genericas\TCentroOperaciones;
use App\Models\BESA\NegociacionesVentas;

use Mail;
use App\Mail\notificacionEstadoSolicitudNego;

class solicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ruta = "NEGOCIACIONES V2 // CREAR SOLICITUD";
        $titulo = "CREAR SOLICITUD";
        $id = "undefined";        
        $adelante = "create";
        $response = compact('ruta', 'titulo', 'id', 'adelante');
        return view('layouts.negociaciones.solicitud', $response);
    }

    /**
     * return json with information
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudGetInfo(Request $request)  
    {
        $data = $request->all();
        if (isset($data['id'])) {
            $id = $data['id'];
            $objeto = TSolicitudNego::with('soliZona', 'soliSucu', 'soliTipoNego', 'causal', 'costo', 'costo.lineas', 'objetivo')
            ->where('sol_id', $id)->first();
        }
        // obtengo usuario logueado
        $usuario = Auth::user();
        // obtengo las clases de negociacion
        $claseNegociacion = ClaseNegociacion::all();
        // obtengo las negociacion año anterior
        $negoAnoAnterior = NegociacionAnoAnterior::all();
        // obtengo los tipos de negociacion
        $tipNegociacion = TipNegociacion::all();
        $tipoDeNegociacion = TipoNegociacion::where('tin_estado', 1)->get();
        $negociacionPara = NegociacionPara::all();
        $eventoTemp = EventoTemp::where('evt_estado', 1)->get();

        // Busco en la tabla t_keyaccount si la persona que crea esta ahi entonces es KAM
        $consultaKam = TKeyAccount::with('cliente')->where([['kea_idTercero_res', $usuario['idTerceroUsuario']], ['kea_estado', 1]])->get();
        $VendedorSucursales = [];
        if (count($consultaKam) > 0) {
            $idClientesKam = collect($consultaKam)->pluck('cliente.cli_id')->all();
            $VendedorSucursales['TSucursal'] = TSucursal::whereIn('cli_id', $idClientesKam)->where('suc_txt_estado', 'ACTIVO')->get();
            $VendedorSucursales['t_sucursal'] = $VendedorSucursales['TSucursal'];
            $vendedorSucursales['ter_id'] = $usuario['idTerceroUsuario'];
        }else{
            // Obtengo el vendedor con sus sucursales
            $VendedorSucursales = TVendedor::with('TSucursal')
            ->where('ter_id', $usuario['idTerceroUsuario'])
            ->first();
        }
        // Obtengo los canales de cada sucursal
        $agruCanalSucursal = collect($VendedorSucursales['TSucursal'])
        ->groupBy('codcanal')->keys()->all();
        // Obtengo solo los canales asociados al vendedor en sus sucursales.
        $canales = TCanal::whereIn('can_id', $agruCanalSucursal)->get();
        // Obtengo los id de los clientes a consultar 
        $idClientes = collect($VendedorSucursales['TSucursal'])->groupBy('cli_id')->keys()->all();
        // Obtengo los clientes a mostrar
        $clientes = TCliente::whereIn('cli_id', $idClientes)->get();
        // obtengo la lista de precios
        $listaPrecios = TListaPrecios::all();
        // obtengo los tipos de serviciios
        $tipoDeServicio = TipoServicio::where('ser_estado', 1)->get();
        // obtengo causales de negociacion
        $causalesNego = CausalesNego::where('can_estado', 1)->get();
        // Obtengo los canales de cada sucursal
        $agruZonasSucursal = collect($VendedorSucursales['TSucursal'])
        ->groupBy('cen_movimiento_id')->keys()->all();
        // Retorna centros de operacion como zonas
        $zonas = TCentroOperaciones::whereIn('cen_id', $agruZonasSucursal)->get();
        // Obtengo los clientes a mostrar
        $clientesTodos = TCliente::all();
        // Retorna la url de misolicitudes
        $urlMisSolicitudes = route('misSolicitudesNegociaciones.index');
        // Forma de pago
        $formaPago = TFormaPago::all();
        // Lineas
        $lineas = TLineas::with('categorias')->get();
        // Base impuesto
        $baseImpuesto = TBaseImpuesto::all();
        // Tipo de bono 
        $tipoBono = TipoBono::with('bonosTerc')->where('tib_estado', 1)->get();


        $response = compact('usuario', 'claseNegociacion', 'negoAnoAnterior', 'tipNegociacion', 'VendedorSucursales', 'canales', 'clientes', 'idClientes', 'negociacionPara', 'agruZonasSucursal', 'zonas', 'listaPrecios', 'eventoTemp', 'tipoDeNegociacion', 'tipoDeServicio', 'causalesNego', 'objeto', 'clientesTodos', 'urlMisSolicitudes', 'formaPago', 'lineas', 'baseImpuesto', 'consultaKam', 'idClientesKam', 'tipoBono');
        return response()->json($response);
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

        try {

            $objSoliNego = TSolicitudNego::create($data);
          
            $objSoliNego = $this->crearSoliZonas($data['arrayZona'], $objSoliNego);
            $objSoliNego = $this->crearSoliSucursales($data['arraySucursales'], $objSoliNego);
            $objSoliNego = $this->crearSoliTipoNego($data['arrayTipoNegociacion'], $objSoliNego, $data['sol_cli_id']);
            $objSoliNego = $this->crearSoliCausales($data['arrayCausalNegociacion'], $objSoliNego);

            $url = route('solicitudNegociaciones.edit', ['id' => $objSoliNego['sol_id'], 'redirecTo' => $data['redirecTo']]);

        } catch (Exception $e) {
            return response()->json(['Error' => 'Error']);
        }

        $response = compact('data', 'contacto', 'url');
        return response()->json($response);
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
    public function edit($id, Request $request)
    {
        $ruta = "NEGOCIACIONES V2 // EDITAR SOLICITUD";
        $titulo = "EDITAR SOLICITUD";
        $adelante = $request->all()['redirecTo'];
        if ($adelante == 'elaboracion') {
            $aprobador = TSolEnvioNego::with('estadoHisProceso', 'terceroRecibe', 'dirNacionalRecibe')->where([['sen_sol_id', $id], ['sen_estadoenvio', 1]])->get();
            // Retorna la url de misolicitudes
            $urlMisSolicitudes = route('misSolicitudesNegociaciones.index');
            $negociacion = TSolicitudNego::with('cliente', 'costo')->where('sol_id', $id)->first();
            $response = compact('aprobador', 'ruta', 'titulo', 'negociacion', 'urlMisSolicitudes');
            return view('layouts.negociaciones.mensajeEnvioSolicitud', $response);
        }
        $response = compact('ruta', 'titulo', 'id', 'adelante');
        return view('layouts.negociaciones.solicitud', $response);
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
        $negociacion = TSolicitudNego::find($id);
            $negociacion->update($data);
            // Zonas update
            if (count($data['arrayZona']) > 0) {
                $deleteZonas = TSoliZona::where('szn_sol_id', $id)->delete();
                $negociacion = $this->crearSoliZonas($data['arrayZona'], $negociacion);
            }
            

            if (count($data['arraySucursales']) > 0) {
                // Sucursales update
                $delteSucursales = TSoliSucursal::where('ssu_sol_id', $id)->delete();
                $negociacion = $this->crearSoliSucursales($data['arraySucursales'], $negociacion);
            }
           
            if (count($data['arrayTipoNegociacion']) > 0) {
                // tipo negociacion update
                $delteSoliTipoNego = TSoliTipoNego::where('stn_sol_id', $id)->delete();
                $negociacion = $this->crearSoliTipoNego($data['arrayTipoNegociacion'], $negociacion, $data['sol_cli_id']);
            }
          

            if (count($data['arrayCausalNegociacion']) > 0) {
                // tipo negociacion update
                $deleteSoliCausalNego = TSoliCausalNego::where('scn_sol_id', $id)->delete();
                $negociacion = $this->crearSoliCausales($data['arrayCausalNegociacion'], $negociacion);
            }
            
            if (count($data['arrayLineas']) > 0) {
                $deleteSoliCostos = TSoliCostos::where('soc_sol_id', $id)->delete();
                $negociacion = $this->crearSoliCostos($data['objCostos'], $negociacion);
                $soliCostos = TSoliCostos::where('soc_sol_id', $id)->first();
                $deleteSoliCostosLineas = TSoliCostosLineas::where('scl_soc_id', $soliCostos['soc_id'])->delete();
                $soliCostos = $this->crearSoliCostosLinea($data['arrayLineas'], $soliCostos, $soliCostos['soc_id']);                           
            }
            

            if (isset($data['objObjetivos']['soo_costonego'])) {
                $deleteSoliObjetivos = TSoliObjetivos::where('soo_sol_id', $id)->delete();
                $data['objObjetivos']['soo_sol_id'] = $id;
                $data['objObjetivos']['soo_pecomini'] = Carbon::parse($data['objObjetivos']['soo_pecomini'])->format('Y-m-d');
                $data['objObjetivos']['soo_pecomfin'] = Carbon::parse($data['objObjetivos']['soo_pecomfin'])->format('Y-m-d');

                $soliObjetivos = TSoliObjetivos::create($data['objObjetivos']);
            }
       
        if (isset($data['objObjetivos']['soo_costonego']) && $data['redirecTo'] == "elaboracion") {
            $errorRuta = [];
            $pernivel = TPernivele::with('canales')->where('pen_cedula', $data['sol_ven_id'])->first();
            if (!isset($pernivel)) {
                array_push($errorRuta, 'El usuario que crea la solicitud no se encuentra creado en los niveles de autorizacion');
            }else{

                 if($pernivel['canales'] == null){
                    array_push($errorRuta, 'No se encontraron canales para la solicitud');
                }else{
                    $pernivCanal = collect($pernivel['canales'])->where('pcan_idcanal', $data['sol_can_id'])->all();
                    $pernivCanal = array_values($pernivCanal);
                    if (count($pernivCanal) > 0) {
                        $padre = TPernivele::where('id', $pernivCanal[0]['pcan_aprobador'])->first();
                        $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', $padre['pen_cedula']], ['sen_sol_id', $data['sol_id']]])->get();
                        if (isset($padre) && count($validacion) == 0) {
                            $updateEstadosAnterior = TSolEnvioNego::where('sen_sol_id', $data['sol_id'])->update(['sen_estadoenvio' => 0]);
                            $negociacion->update(['sol_ser_id' => 2]);
                            $objTSolEnvioNego = new TSolEnvioNego;
                            $objTSolEnvioNego['sen_sol_id'] = $data['sol_id'];
                            $objTSolEnvioNego['sen_ser_id'] = 2;
                            $objTSolEnvioNego['sen_idTercero_envia'] = $pernivel['pen_cedula'];
                            $objTSolEnvioNego['sen_idTercero_recibe'] = $padre['pen_cedula'];
                            $objTSolEnvioNego['sen_observacion'] = $data['objObjetivos']['soo_observacion']; 
                            $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
                            $objTSolEnvioNego['sen_estadoenvio'] = 1;
                            $objTSolEnvioNego['sen_run_id'] = null;
                            $objTSolEnvioNego->save();
                            $objTSolEnvioNego = TSolEnvioNego::with('terceroEnvia', 'terceroRecibe', 'solicitud', 'solicitud.soliSucu', 'solicitud.soliSucu.hisSucu', 'solicitud.soliZona', 'solicitud.soliZona.hisZona', 'solicitud.soliZona.hisZona', 'solicitud.objetivo', 'solicitud.soliTipoNego', 'solicitud.soliTipoNego.tipoNego', 'solicitud.soliTipoNego.tipoServicio', 'solicitud.costo', 'solicitud.costo.formaPago', 'solicitud.cliente')->where('sen_id', $objTSolEnvioNego['sen_id'])->first();

                            // Enviar el primer correo creacion
                            $correo = TDirNacional::where('dir_txt_cedula', $objTSolEnvioNego['sen_idTercero_envia'])->pluck('dir_txt_email')->first();
                            // Valida que el correo exista en el Directorio Nacional
                            if ($correo == null) {
                                $correo = TDirNacional::where('dir_txt_cedula', '1151955318')->pluck('dir_txt_email')->first();
                                $objTSolEnvioNego['creacion'] = true;
                                $objTSolEnvioNego['validacionAuditoria'] = false;
                                $respCorreo = self::enviaCorreo($correo, $objTSolEnvioNego);
                            }else{
                                $objTSolEnvioNego['creacion'] = true;
                                $objTSolEnvioNego['validacionAuditoria'] = false;
                                $respCorreo = self::enviaCorreo($correo, $objTSolEnvioNego);
                            }

                            // Envia correo paso creado
                            $correo = TDirNacional::where('dir_txt_cedula', $objTSolEnvioNego['sen_idTercero_recibe'])->pluck('dir_txt_email')->first();
                            // Valida que el correo exista en el Directorio Nacional
                            if ($correo == null) {
                                $correo = TDirNacional::where('dir_txt_cedula', '1151955318')->pluck('dir_txt_email')->first();
                                $objTSolEnvioNego['creacion'] = false;
                                $objTSolEnvioNego['validacionAuditoria'] = false;
                                $respCorreo = self::enviaCorreo($correo, $objTSolEnvioNego);
                            }else{
                                $objTSolEnvioNego['creacion'] = false;
                                $objTSolEnvioNego['validacionAuditoria'] = false;
                                $respCorreo = self::enviaCorreo($correo, $objTSolEnvioNego);
                            }

                            //Envia correo a Daisy Ospina (Auditoria) cuando se presentan errorres en las fechas
                            if ($data['sol_peri_ejeini'] > $data['sol_fecha']) {
                                $correo = TDirNacional::where('dir_txt_cedula', '1143949655')->pluck('dir_txt_email')->first();
                                $objTSolEnvioNego['validacionAuditoria'] = true;
                                $respCorreo = self::enviaCorreo($correo, $objTSolEnvioNego);
                            }

                        }else{
                            array_push($errorRuta, 'No se encontro ruta de aprobacion para el canal seleccionado');
                        }
                    }else{
                        array_push($errorRuta, 'Favor validar el nivel siguiente al usuario actual en los niveles de autorizacion');
                    }
                }
            }
        }

        $pernivel = TPernivele::with('canales')->where('pen_cedula', $data['sol_ven_id'])->first();
        $validacion = TSolEnvioNego::where([['sen_idTercero_envia', $pernivel['pen_cedula']], ['sen_idTercero_recibe', null], ['sen_sol_id', $data['sol_id']]])->get();
        if (count($validacion) == 0) {
            $negociacion->update(['sol_ser_id' => 2]);
            $objTSolEnvioNego = new TSolEnvioNego;
            $objTSolEnvioNego['sen_sol_id'] = $data['sol_id'];
            $objTSolEnvioNego['sen_ser_id'] = 0;
            $objTSolEnvioNego['sen_idTercero_envia'] = $pernivel['pen_cedula'];
            $objTSolEnvioNego['sen_idTercero_recibe'] = null;
            $objTSolEnvioNego['sen_observacion'] = $data['sol_observaciones']; 
            $objTSolEnvioNego['sen_fechaenvio'] = Carbon::now()->toDateTimeString();  
            $objTSolEnvioNego['sen_estadoenvio'] = 0;
            $objTSolEnvioNego['sen_run_id'] = null;
            $objTSolEnvioNego->save();
        }
    
        $url = route('solicitudNegociaciones.edit', ['id' => $id, 'redirecTo' => $data['redirecTo']]);

        $response = compact('data', 'id', 'url', 'negociacion', 'pernivel', 'errorRuta', 'pernivCanal', 'padre', 'objTSolEnvioNego', 'validacion');
        return response()->json($response);
    }

    public function enviaCorreo($correo, $objTSolEnvioNego){
        Mail::to($correo)->send(new notificacionEstadoSolicitudNego($objTSolEnvioNego));
        if(Mail::failures()){
            return response()->json(Mail::failures());
        }else{
            return true;
        }
    }

    public function crearSoliCostosLinea($arreglo, $obj, $costoId){
        foreach ($arreglo as $key => $value) {
            $array = [];
            $array['scl_soc_id'] = $costoId; 
            $array['scl_cat_id'] = $value['cat_id']; 
            $array['scl_lin_id'] = $value['lin_id']; 
            $array['scl_ppart'] = $value['porcentParti']; 
            $array['scl_costo'] = $value['CostoNegoLinea'];     
            if (isset($value['CostoAdiLinea'])) {
                $array['scl_costoadi'] = $value['CostoAdiLinea'];  
            }else{
                $array['scl_costoadi'] = 0;                  
            }        
            $array['scl_estado'] = 1; 
            if (!isset($value['scl_valorventa'])) {
                $value['scl_valorventa'] = 0;
            }
            if (!isset($value['scl_pvalorventa'])) {
                $value['scl_pvalorventa'] = 0;
            }
            $array['scl_valorventa'] = $value['scl_valorventa'];   // **
            $array['scl_pvalorventa'] = $value['scl_pvalorventa'];   // ** 
            $obj->lineas()->create($array);
        }        
        return $obj;
    }

    public function crearSoliCostos($obj, $negociacion){
        $obj['soc_formapago'] = $obj['soc_formapago']['id'];
        if (isset($obj['soc_denominacionbono'])) {
            $obj['soc_denominacionbono'] = $obj['soc_denominacionbono']['bonos_terc']['tbt_id'];
        }       
        $negociacion->costo()->create($obj);
        return $negociacion;
    }

    public function crearSoliZonas($arregloZonas, $negociacion){
        foreach ($arregloZonas as $key => $value) {
            $value['szn_coc_id'] = $value['szn_coc_id']['cen_id']; // Id zona             
            $value['szn_estado'] = 1; // estado
            $negociacion->soliZona()->create($value);
        }        
        return $negociacion;
    }

    public function crearSoliSucursales($arregloSucursales, $negociacion){
        foreach ($arregloSucursales as $key => $value) {
                $objSucur = [];
                $objSucur['ssu_suc_id'] = $value['suc_id']; // Id de la sucursal                    
                $objSucur['ssu_estado'] = 1; // Estado
                $objSucur['ssu_ppart'] = $value['porcentParti']; // porcentaje participacion                    
                $negociacion->soliSucu()->create($objSucur);
        }
        return $negociacion;
    }

    public function crearSoliCausales($arregloCausales, $negociacion){
        foreach ($arregloCausales as $key => $value) {
                $value['scn_can_id'] = $value['scn_can_id']['can_id'];
                $value['scn_estado'] = 1;
                $negociacion->causal()->create($value);
            }
        return $negociacion;
    }

    public function crearSoliTipoNego($arregloTipoNego, $negociacion, $clienteId){
        
        $contacto = TCliente::with('tercero', 'tercero.contacto')->where('cli_id', $clienteId)->first();

        $ciudad = $contacto['tercero']['contacto']['idCiudadContacto'];
        $depto = $contacto['tercero']['contacto']['idDepartamentoContacto'];
        $pais = $contacto['tercero']['contacto']['idPaisContacto'];
        $resiva = $contacto['cli_num_resiva'];
        $decrenta = $contacto['cli_num_decrenta'];
        $grancont = $contacto['cli_num_grancont'];
        $autiva = $contacto['cli_num_autiva'];
        $autica = $contacto['cli_num_autica'];
        $autrenta = $contacto['cli_num_autrenta'];

        foreach ($arregloTipoNego as $key => $value) {
            $impuestos = TBaseImpuesto::where('bai_ser_id', $value['stn_ser_id']['ser_id'])->get();
            $impuestos = $impuestos->groupBy('bai_tipoimpuesto');

            $objTipoNego = [];
            $objTipoNego['stn_tin_id'] = $value['stn_tin_id']['tin_id'];
            $objTipoNego['stn_ser_id'] = $value['stn_ser_id']['ser_id'];
            $objTipoNego['stn_costo'] = $value['stn_costo'];
            $objTipoNego['stn_estado'] = 1;
            
            // 1 -> rete fuente
            if (isset($impuestos[1])) {

                $retefuente = collect($impuestos[1])->where('bai_declararenta', $decrenta)->all();
                if (count($retefuente)  == 0) {
                    $retefuente = collect($impuestos[1])->where('bai_declararenta', 0)->all();
                }
                $retefuente = array_values($retefuente);
                $retefuente = $retefuente[0];
                $objTipoNego['stn_rtfuente'] = $retefuente['bai_tasa'];// stn_rtfuente
                if ($objTipoNego['stn_costo'] >= $retefuente['bai_base']) {
                     $objTipoNego['stn_valor_rtfuente'] = ($objTipoNego['stn_costo'] * $retefuente['bai_tasa']) / 100;// stn_valor_rtfuente
                }else{
                     $objTipoNego['stn_valor_rtfuente'] = 0;// stn_valor_rtfuente
                }                    
                $objTipoNego['stn_retfuente_base'] = $retefuente['bai_base']; // bai_base
            }else{
                 $objTipoNego['stn_rtfuente'] = 0;// stn_rtfuente
                 $objTipoNego['stn_retfuente_base'] = 0; // bai_base
                 $objTipoNego['stn_valor_rtfuente'] = 0;// stn_valor_rtfuente
            }
          
            if (isset($impuestos[2])) {
                // 2 -> rete ica                
                $reteica = collect($impuestos[2])->last();
                $objTipoNego['stn_rtica'] = $reteica['bai_tasa'];// stn_rtfuente

                if (((($grancont==1) || ($autiva==1)) && ($pais==169) && ($depto=11) && ($ciudad=1)) || ($autica==1)){
                    $objTipoNego['stn_rtica'] = 0;
                    $objTipoNego['stn_valor_rtica'] = 0;// stn_valor_rtfuente
                    $objTipoNego['stn_rtica_base'] = 0; // bai_base
                }else{
                    if ($reteica['bai_dep_id'] > 0 && $objTipoNego['stn_costo'] >= $reteica['bai_base']){
                        $objTipoNego['stn_valor_rtica'] = ($objTipoNego['stn_costo'] * $reteica['bai_tasa']) / 100;
                        $objTipoNego['stn_rtica_base'] = $reteica['bai_base'];
                        $objTipoNego['stn_rtica'] = $reteica['bai_tasa'];
                    }else{
                        $$objTipoNego['stn_rtica'] = 0;
                        $objTipoNego['stn_valor_rtica'] = 0;// stn_valor_rtfuente
                        $objTipoNego['stn_rtica_base'] = 0; // bai_base
                    }                
                }
            }else{
                $objTipoNego['stn_rtica'] = 0;
                $objTipoNego['stn_valor_rtica'] = 0;// stn_valor_rtfuente
                $objTipoNego['stn_rtica_base'] = 0; // bai_base
            }
          

            if (isset($impuestos[3])) {
                // 3 -> rete iva
                $reteiva = collect($impuestos[3])->last();
                $objTipoNego['stn_rtiva'] = $reteica['bai_tasa'];// stn_rtfuente

                if ($objTipoNego['stn_costo'] >= $reteiva['bai_base']) {
                    $objTipoNego['stn_valor_rtiva'] = ($objTipoNego['stn_costo'] * $reteica['bai_tasa']) / 100;// stn_valor_rtfuente
                }else{
                    $objTipoNego['stn_valor_rtiva'] = 0;// stn_valor_rtfuente
                }                
                $objTipoNego['stn_rtiva_base'] = $reteica['bai_base']; // bai_base
            }else{
                $objTipoNego['stn_rtiva'] = 0;// stn_rtfuente
                $objTipoNego['stn_valor_rtiva'] = 0;// stn_valor_rtfuente
                $objTipoNego['stn_rtiva_base'] = 0; // bai_base
            }
           

            // 4 -> IVA
            if (isset($impuestos[4])) {
                $iva = collect($impuestos[4])->last();
                $objTipoNego['stn_iva'] = $iva['bai_tasa'];// stn_rtfuente

                if ($objTipoNego['stn_costo'] >= $iva['bai_base']) {
                    $objTipoNego['stn_valor_iva'] = ($objTipoNego['stn_costo'] * $iva['bai_tasa']) / 100;// stn_valor_rtfuente
                }else{
                    $objTipoNego['stn_valor_iva'] = 0;// stn_valor_rtfuente
                }                
                $objTipoNego['stn_iva_base'] = $iva['bai_base']; // bai_base
            }else{
                $objTipoNego['stn_iva'] = 0;// stn_rtfuente
                $objTipoNego['stn_valor_iva'] = 0;// stn_valor_rtfuente
                $objTipoNego['stn_iva_base'] = 0; // bai_base
            }

            $negociacion->soliTipoNego()->create($objTipoNego);
        }
        return $negociacion;
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


    public function calcularObjetivos(Request $request)
    {
        $data = $request->all();

        $lineas = collect($data['costo']['lineas'])->pluck('scl_lin_id')->all();   
        $fechaInicio = Carbon::parse($data['objObjetivos']['soo_pecomini'])->format('d/m/Y');        
        $fechaFin = Carbon::parse($data['objObjetivos']['soo_pecomfin'])->format('d/m/Y');

        if (count($data['arraySucursales']) > 0) {
           $sucursales = collect($data['arraySucursales'])->pluck('ssu_suc_id')->all(); 
           $sucurConsulta = TSucursal::whereIn('suc_id', $sucursales)->get();           
           $codigosSucur = collect($sucurConsulta)->pluck('suc_num_codigo')->all();
        }else{
            $codigosSucur = [];
        }
        $canal =  $data['sol_can_id']['can_id'];


        // Consulta la venta promedio mes lineas periodo de comparacion
        $soo_venpromeslin = NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
        ->where('codcanal', $data['sol_can_id']['can_id'])
        ->where('nitcliente', $data['sol_cli_id']['ter_id'])
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->where('concepto', '501')
        ->where('co', '99')
        ->whereIn('codlinea', $lineas)
        ->whereIn('codsucursal', $codigosSucur)
        ->groupBy('codlinea')
        ->get();

        $fechaEjecucion = Carbon::parse($data['sol_peri_ejefin'])->format('d/m/Y');
        $ultimosSeisMeses1 = Carbon::parse($data['sol_peri_ejefin'])->subMonth(5)->format('d/m/Y');
        $explode = explode("/", $ultimosSeisMeses1);
        $explode[0] = '01';

        $ultimosSeisMeses1 = implode("/", $explode);

        if (count($codigosSucur) > 0) {
        // Consulta la venta promedio de los ultimos 6 meses de la lineas
            $soo_venprolin6m =  NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
            ->where('concepto', '501')
            ->where('co', '99')
            ->whereIn('codlinea', $lineas)
            ->whereIn('codsucursal', $codigosSucur)
            ->groupBy('codlinea')
            ->get();
        }else{
            // Consulta la venta promedio de los ultimos 6 meses de la lineas
            $soo_venprolin6m =  NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
            ->where('concepto', '501')
            ->where('co', '99')
            ->whereIn('codlinea', $lineas)
            ->groupBy('codlinea')
            ->get();
        }
     
        

        // Consulta la venta promedio total del cliente en el periodo de comparacion
        $soo_ventapromtotal = NegociacionesVentas::select(DB::raw('SUM(neto) as total'))
        ->where('codcanal', $data['sol_can_id']['can_id'])
        ->where('nitcliente', $data['sol_cli_id']['ter_id'])
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->where('concepto', '501')
        ->where('co', '99')
        ->whereIn('codsucursal', $codigosSucur)
        ->get();


        if (count($codigosSucur) > 0) {
            // Consulta la venta promedio total de los ultimos 6 meses
            $soo_ventapromseisme =  NegociacionesVentas::select(DB::raw('SUM(neto) as total'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
            ->where('concepto', '501')
            ->where('co', '99')
            ->whereIn('codsucursal', $codigosSucur)
            ->get();
        }else{
            // Consulta la venta promedio total de los ultimos 6 meses
            $soo_ventapromseisme =  NegociacionesVentas::select(DB::raw('SUM(neto) as total'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
            ->where('concepto', '501')
            ->where('co', '99')
            ->get();
        }
     

        // Consulta venta 1 mes antes periodo de comparacion
        $fechCompaSinUnMes = Carbon::parse($data['objObjetivos']['soo_pecomini'])->subMonth(1)->format('d/m/Y');

        if (count($codigosSucur) > 0) {
              $soo_vemesantes =  NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->where('fecha', '>=', $fechCompaSinUnMes)
            ->where('fecha', '<', $fechaInicio)
            ->where('concepto', '501')
            ->where('co', '99')
            ->whereNotIn('codlinea', $lineas)
            ->whereIn('codsucursal', $codigosSucur)
            ->groupBy('codlinea')
            ->get();
        }else{
            $soo_vemesantes =  NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
            ->where('codcanal', $data['sol_can_id']['can_id'])
            ->where('nitcliente', $data['sol_cli_id']['ter_id'])
            ->where('fecha', '>=', $fechCompaSinUnMes)
            ->where('fecha', '<', $fechaInicio)
            ->where('concepto', '501')
            ->where('co', '99')
            ->whereNotIn('codlinea', $lineas)
            ->groupBy('codlinea')
            ->get();
        }
        

        //  Consulta Venta 1 mes despues del periodo de comparacion
        $fechCompaMasUnMes = Carbon::parse($data['objObjetivos']['soo_pecomfin'])->addMonth(1)->format('d/m/Y');

        $soo_vemesdespues =  NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
        ->where('codcanal', $data['sol_can_id']['can_id'])
        ->where('nitcliente', $data['sol_cli_id']['ter_id'])
        ->where('fecha', '>', $fechaFin)
        ->where('fecha', '<=', $fechCompaMasUnMes)
        ->where('concepto', '501')
        ->where('co', '99')
        ->whereNotIn('codlinea', $lineas)
        ->whereIn('codsucursal', $codigosSucur)
        ->groupBy('codlinea')
        ->get();

        // Consulta los valores de las lineas

        if($data['sol_huella_capitalizar']['id'] == 2){

            if (count($codigosSucur) > 0) {
                $arreglo =  NegociacionesVentas::select(DB::raw('SUM(neto) / 6  as total, codlinea'))
                ->where('codcanal', $data['sol_can_id']['can_id'])
                ->where('nitcliente', $data['sol_cli_id']['ter_id'])
                ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
                ->where('concepto', '501')
                ->where('co', '99')
                ->whereIn('codlinea', $lineas)
                ->whereIn('codsucursal', $codigosSucur)
                ->groupBy('codlinea')
                ->get();
            }else{
                $arreglo =  NegociacionesVentas::select(DB::raw('SUM(neto) / 6  as total, codlinea'))
                ->where('codcanal', $data['sol_can_id']['can_id'])
                ->where('nitcliente', $data['sol_cli_id']['ter_id'])
                ->whereBetween('fecha', [$ultimosSeisMeses1, $fechaEjecucion])
                ->where('concepto', '501')
                ->where('co', '99')
                ->whereIn('codlinea', $lineas)
                ->groupBy('codlinea')
                ->get();
            }
          
        }//fin if valida si es capitalizar oportunidad
        else{

            if (count($codigosSucur) > 0) {
                $arreglo = NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
                    ->where('codcanal', $data['sol_can_id']['can_id'])
                    ->where('nitcliente', $data['sol_cli_id']['ter_id'])
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                    ->where('concepto', '501')
                    ->where('co', '99')
                    ->whereIn('codlinea', $lineas)
                    ->whereIn('codsucursal', $codigosSucur)
                    ->groupBy('codlinea')
                    ->get();
            }else{
                 $arreglo = NegociacionesVentas::select(DB::raw('SUM(neto) as total, codlinea'))
                ->where('codcanal', $data['sol_can_id']['can_id'])
                ->where('nitcliente', $data['sol_cli_id']['ter_id'])
                ->whereBetween('fecha', [$fechaInicio, $fechaFin])
                ->where('concepto', '501')
                ->where('co', '99')
                ->whereIn('codlinea', $lineas)
                ->groupBy('codlinea')
                ->get();
            }
           
        }


        
        $response = compact('data', 'soo_venpromeslin', 'soo_venprolin6m', 'soo_ventapromtotal', 'soo_ventapromseisme', 'soo_vemesantes', 'soo_vemesdespues', 'arreglo',  'ultimosSeisMeses1', 'fechaFin', 'fechaInicio', 'explode1', 'fechaEjecucion', 'fechCompaSinUnMes', 'lineas', 'codigosSucur');
        return response()->json($response);
    }
}
