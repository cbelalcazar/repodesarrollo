<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\negociaciones\TSolicitudNego;
use App\Models\negociaciones\TSoliZona;
use App\Models\negociaciones\TSoliSucursal;
use App\Models\negociaciones\TSoliTipoNego;
use App\Models\negociaciones\TSoliCausalNego;
use App\Models\negociaciones\TSoliCostos;
use App\Models\negociaciones\TSoliCostosLineas;
use App\Models\negociaciones\TSoliCostosMotAdic;
use App\Models\negociaciones\TSoliCostosDetAdic;
use App\Models\negociaciones\TSoliObjetivos;
use App\Models\negociaciones\TSoliTesoreriaHis;
use App\Models\negociaciones\TSoliActaEntrega;
use App\Models\negociaciones\TSoliReviExhibicion;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Alert;

class misSolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();         
        $ruta = "NEGOCIACIONES V2 // MIS SOLICITUDES";
        $titulo = "Mis solicitudes";
        if (isset($data['id'])) {
            $recarguemos = $data['id'];
        }else{
            $recarguemos = "";
        }
        $response = compact('ruta', 'titulo', 'recarguemos');
        return view('layouts.negociaciones.misSolicitudes', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * return json with information
     *
     * @return \Illuminate\Http\Response
     */
    public function getInfo()  
    {
        $usuario = Auth::user();
        // $solicitudes = TSolicitudNego::with('costo', 'costo.lineas', 'costo.lineas.lineasDetalle', 'costo.lineas.lineasDetalle.categorias', 'costo.motivo', 'costo.motivo.motAdicion', 'costo.detalle', 'estado', 'cliente', 'canal', 'listaPrecios', 'vendedor', 'zona', 'clasificacion', 'hisProceso', 'hisProceso.estadoHisProceso', 'hisProceso.terceroEnvia', 'hisProceso.terceroRecibe', 'costo.tipoBono.bono', 'soliZona', 'soliZona.hisZona', 'soliZona.hisZona.cOperacion', 'soliSucu', 'soliSucu.hisSucu', 'soliTipoNego', 'soliTipoNego.tipoNego', 'causal', 'causal.causalDetalle', 'evento', 'objetivo', 'cumplimiento', 'verificacionCobro', 'verificacionCobro.documento', 'verificacionCobro.proveedor', 'reviExhibicion', 'reviExhibicion.usuario', 'actaEntrega', 'actaEntrega.usuario', 'tesoHistorial', 'tesoAuditoria', 'tesoAuditoria.usuario')->where('sol_ven_id', $usuario['idTerceroUsuario'])->get();

        $solicitudes = TSolicitudNego::with('costo', 'costo.lineas', 'costo.lineas.lineasDetalle', 'costo.lineas.lineasDetalle.categorias', 'costo.motivo', 'costo.motivo.motAdicion', 'costo.detalle', 'estado', 'cliente', 'canal', 'listaPrecios', 'vendedor', 'zona', 'clasificacion', 'hisProceso', 'hisProceso.estadoHisProceso', 'hisProceso.terceroEnvia', 'hisProceso.terceroRecibe', 'costo.tipoBono.bono', 'soliZona', 'soliZona.hisZona', 'soliZona.hisZona.cOperacion', 'soliSucu', 'soliSucu.hisSucu', 'soliTipoNego', 'soliTipoNego.tipoNego', 'causal', 'causal.causalDetalle', 'evento', 'objetivo', 'cumplimiento', 'verificacionCobro', 'verificacionCobro.documento', 'verificacionCobro.proveedor', 'reviExhibicion', 'reviExhibicion.usuario', 'actaEntrega', 'actaEntrega.usuario', 'tesoHistorial', 'tesoAuditoria', 'tesoAuditoria.usuario')->where('sol_ven_id', '1144069330')->get();

        $solicitudes = collect($solicitudes)->map(function($object){           
            $object['revi_exhibicion'] = collect($object['reviExhibicion'])->map(function($ob){
                $arreglo = explode('/', asset('/storage/app/public/negociaciones/'.$ob['sre_foto']));
                unset($arreglo[4]);
                $arreglo = array_values($arreglo);
                $string = implode('/', $arreglo);
                $ob['urlImagen'] = $string;
                return $ob;
            });
            return $object;
        });

        $solicitudes = collect($solicitudes)->map(function($object){           
            $object['acta_entrega'] = collect($object['actaEntrega'])->map(function($ob){
                $arreglo = explode('/', asset('/storage/app/public/negociaciones/'.$ob['sae_acta']));
                unset($arreglo[4]);
                $arreglo = array_values($arreglo);
                $string = implode('/', $arreglo);
                $ob['urlImagen'] = $string;
                return $ob;
            });
            return $object;
        });

        $urlImprimirActa = route('imprimirActa');

        // Agrego la ruta edit a todas las solicitudes
        $solicitudes = $solicitudes->map(function($item, $key){
             $item['url'] = route('solicitud.edit', ['id' => $item['sol_id'], 'redirecTo' => 'grabar.1']);
             return $item;
        })->all();

        $response = compact('usuario', 'solicitudes', 'urlImprimirActa', 'arrUrls');
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

        //Duplicado en SolicitudNego
        $duplicarSolicitudNego =  new TSolicitudNego;
        $duplicarSolicitudNego->sol_evt_id = $data['sol_evt_id'];
        $duplicarSolicitudNego->sol_soc_id = $data['sol_soc_id'];
        $duplicarSolicitudNego->sol_ser_id = 0;
        $duplicarSolicitudNego->sol_ven_id = $data['sol_ven_id'];
        $duplicarSolicitudNego->sol_sef_id = 1;
        $duplicarSolicitudNego->sol_set_id = 0;
        $duplicarSolicitudNego->sol_zona = $data['sol_zona'];
        $duplicarSolicitudNego->sol_can_id = $data['sol_can_id'];
        $duplicarSolicitudNego->sol_cli_id = $data['sol_cli_id'];
        $duplicarSolicitudNego->sol_lis_id = $data['sol_lis_id'];
        $duplicarSolicitudNego->sol_fecha = Carbon::parse($data['sol_fecha'])->subHour(5)->format('Y-m-d H:i:s');
        $duplicarSolicitudNego->sol_clase = $data['sol_clase'];
        $duplicarSolicitudNego->sol_tipocliente = $data['sol_tipocliente'];
        $duplicarSolicitudNego->sol_descomercial = $data['sol_descomercial'];
        $duplicarSolicitudNego->sol_peri_facturaini = $data['sol_peri_facturaini'];
        $duplicarSolicitudNego->sol_peri_facturafin = $data['sol_peri_facturafin'];
        $duplicarSolicitudNego->sol_mesesfactu = $data['sol_mesesfactu'];
        $duplicarSolicitudNego->sol_peri_ejeini = Carbon::parse($data['sol_peri_ejeini'])->format('Y-m-d');
        $duplicarSolicitudNego->sol_peri_ejefin = Carbon::parse($data['sol_peri_ejefin'])->format('Y-m-d');
        $duplicarSolicitudNego->sol_meseseje = $data['sol_meseseje'];
        $duplicarSolicitudNego->sol_observaciones = $data['sol_observaciones'];
        $duplicarSolicitudNego->sol_clasificacion = $data['sol_clasificacion'];
        $duplicarSolicitudNego->sol_ppresupuestozona = $data['sol_ppresupuestozona'];
        $duplicarSolicitudNego->sol_valorpresupuestozona = $data['sol_valorpresupuestozona'];
        $duplicarSolicitudNego->sol_ppresupuestocanal = $data['sol_ppresupuestocanal'];
        $duplicarSolicitudNego->sol_valorpresupuestocanal = $data['sol_valorpresupuestocanal'];
        $duplicarSolicitudNego->sol_valorpresupuestomerca = $data['sol_valorpresupuestomerca'];
        $duplicarSolicitudNego->sol_ppresupuestomerca = $data['sol_ppresupuestomerca'];
        $duplicarSolicitudNego->sol_tipoacta = $data['sol_tipoacta'];
        $duplicarSolicitudNego->sol_llegoacta = $data['sol_llegoacta'];
        $duplicarSolicitudNego->sol_obstesoreriabono = $data['sol_obstesoreriabono'];
        $duplicarSolicitudNego->sol_fechatesorbono = $data['sol_fechatesorbono'];
        $duplicarSolicitudNego->sol_fechacomparacionini = $data['sol_fechacomparacionini'];
        $duplicarSolicitudNego->sol_fechacomparacionfin = $data['sol_fechacomparacionfin'];
        $duplicarSolicitudNego->sol_mesescomp = $data['sol_mesescomp'];
        $duplicarSolicitudNego->sol_observacion_objetivos = $data['sol_observacion_objetivos'];
        $duplicarSolicitudNego->sol_ventaestimada = $data['sol_ventaestimada'];
        $duplicarSolicitudNego->sol_correofechaejecucion = $data['sol_correofechaejecucion'];
        $duplicarSolicitudNego->sol_observacionanulacion = $data['sol_observacionanulacion'];
        $duplicarSolicitudNego->sol_observacioncameje = $data['sol_observacioncameje'];
        $duplicarSolicitudNego->sol_tipo = $data['sol_tipo'];
        $duplicarSolicitudNego->sol_obsconfirbono = $data['sol_obsconfirbono'];
        $duplicarSolicitudNego->sol_fechaconfirbono = $data['sol_fechaconfirbono'];
        $duplicarSolicitudNego->sol_obsdesconfirbono = $data['sol_obsdesconfirbono'];
        $duplicarSolicitudNego->sol_fechadesconfirbono = $data['sol_fechadesconfirbono'];
        $duplicarSolicitudNego->sol_estadocobro = $data['sol_estadocobro'];
        $duplicarSolicitudNego->sol_fechalimiteeval = $data['sol_fechalimiteeval'];
        $duplicarSolicitudNego->sol_huella_capitalizar = $data['sol_huella_capitalizar'];
        $duplicarSolicitudNego->sol_fechaaprobaciontotal = $data['sol_fechaaprobaciontotal'];
        $duplicarSolicitudNego->save();

        $validarZona = collect($data['soli_zona'])->isNotEmpty();
        if ($validarZona == true) {
            foreach ($data['soli_zona'] as $key => $value) {
                $duplicarSoliZona = new TSoliZona;
                $duplicarSoliZona->szn_sol_id = $duplicarSolicitudNego['sol_id'];
                $duplicarSoliZona->szn_coc_id = $value['szn_coc_id'];
                $duplicarSoliZona->szn_ppart = $value['szn_ppart'];
                $duplicarSoliZona->szn_estado = $value['szn_estado'];
                $duplicarSoliZona->save();
            }   
        }else{
            foreach ($data['soli_sucu'] as $key => $value) {
                $duplicarSoliSucursal = new TSoliSucursal;
                $duplicarSoliSucursal->ssu_sol_id = $duplicarSolicitudNego['sol_id'];
                $duplicarSoliSucursal->ssu_suc_id = $value['ssu_suc_id'];
                $duplicarSoliSucursal->ssu_ppart = $value['ssu_ppart'];
                $duplicarSoliSucursal->ssu_estado = $value['ssu_estado'];
                $duplicarSoliSucursal->save();
            }
        }
        
        foreach ($data['soli_tipo_nego'] as $key => $value) {
            $duplicarSoliTipoNego = new TSoliTipoNego;
            $duplicarSoliTipoNego->stn_sol_id = $duplicarSolicitudNego['sol_id'];  
            $duplicarSoliTipoNego->stn_tin_id = $value['stn_tin_id'];  
            $duplicarSoliTipoNego->stn_ser_id = $value['stn_ser_id'];
            $duplicarSoliTipoNego->stn_costo = $value['stn_costo'];
            $duplicarSoliTipoNego->stn_rtfuente = $value['stn_rtfuente'];
            $duplicarSoliTipoNego->stn_valor_rtfuente = $value['stn_valor_rtfuente'];  
            $duplicarSoliTipoNego->stn_retfuente_base = $value['stn_retfuente_base'];  
            $duplicarSoliTipoNego->stn_rtica = $value['stn_rtica'];
            $duplicarSoliTipoNego->stn_valor_rtica = $value['stn_valor_rtica'];  
            $duplicarSoliTipoNego->stn_rtica_base = $value['stn_rtica_base'];
            $duplicarSoliTipoNego->stn_rtiva = $value['stn_rtiva'];
            $duplicarSoliTipoNego->stn_valor_rtiva = $value['stn_valor_rtiva'];  
            $duplicarSoliTipoNego->stn_rtiva_base = $value['stn_rtiva_base'];
            $duplicarSoliTipoNego->stn_iva = $value['stn_iva'];
            $duplicarSoliTipoNego->stn_valor_iva = $value['stn_valor_iva'];  
            $duplicarSoliTipoNego->stn_iva_base = $value['stn_iva_base'];
            $duplicarSoliTipoNego->stn_estado = $value['stn_estado'];
            $duplicarSoliTipoNego->save();
        }
        
        foreach ($data['causal'] as $key => $value) {
            $duplicarSoliCausalNego = new TSoliCausalNego;
            $duplicarSoliCausalNego->scn_sol_id = $duplicarSolicitudNego['sol_id'];
            $duplicarSoliCausalNego->scn_can_id = $value['scn_can_id'];
            $duplicarSoliCausalNego->scn_estado = $value['scn_estado'];
            $duplicarSoliCausalNego->save();
        }

        //Duplicado en SoliCostos
        $duplicarSoliCostos = new TSoliCostos;
        $duplicarSoliCostos->soc_sol_id = $duplicarSolicitudNego['sol_id'];
        $duplicarSoliCostos->soc_tbt_id = $data['costo']['soc_tbt_id'];
        $duplicarSoliCostos->soc_valornego = $data['costo']['soc_valornego'];
        $duplicarSoliCostos->soc_granvalor = $data['costo']['soc_granvalor'];
        $duplicarSoliCostos->soc_iva = $data['costo']['soc_iva'];
        $duplicarSoliCostos->soc_subtotalcliente = $data['costo']['soc_subtotalcliente'];
        $duplicarSoliCostos->soc_retefte = $data['costo']['soc_retefte'];
        $duplicarSoliCostos->soc_reteica = $data['costo']['soc_reteica'];
        $duplicarSoliCostos->soc_reteiva = $data['costo']['soc_reteiva'];
        $duplicarSoliCostos->soc_total = $data['costo']['soc_total'];
        $duplicarSoliCostos->soc_formapago = $data['costo']['soc_formapago'];
        $duplicarSoliCostos->soc_denominacionbono = $data['costo']['soc_denominacionbono'];
        $duplicarSoliCostos->save();

        foreach ($data['costo']['lineas'] as $key => $value) {
            $duplicarSoliCostosLineas = new TSoliCostosLineas;
            
            $duplicarSoliCostosLineas->scl_soc_id = $duplicarSoliCostos['soc_id'];
            $duplicarSoliCostosLineas->scl_cat_id = $value['scl_cat_id'];
            $duplicarSoliCostosLineas->scl_lin_id = $value['scl_lin_id'];
            $duplicarSoliCostosLineas->scl_ppart = $value['scl_ppart'];
            $duplicarSoliCostosLineas->scl_costo = $value['scl_costo'];
            $duplicarSoliCostosLineas->scl_costoadi = $value['scl_costoadi'];
            $duplicarSoliCostosLineas->scl_valorventa = $value['scl_valorventa'];
            $duplicarSoliCostosLineas->scl_pvalorventa = $value['scl_pvalorventa'];
            $duplicarSoliCostosLineas->scl_estado = $value['scl_estado'];
            $duplicarSoliCostosLineas->save();
        }
        
        $validarMotivo = collect($data['costo']['motivo'])->isNotEmpty();
        if ($validarMotivo == true) {
            foreach ($data['costo']['motivo'] as $key => $value) {
                $duplicarSoliCostosMotAdic = new TSoliCostosMotAdic;
                $duplicarSoliCostosMotAdic->sca_soc_id = $duplicarSoliCostos['soc_id'];
                $duplicarSoliCostosMotAdic->sca_mta_id = $value['sca_mta_id'];
                $duplicarSoliCostosMotAdic->sca_valor = $value['sca_valor'];
                $duplicarSoliCostosMotAdic->sca_mostrar = $value['sca_mostrar'];
                $duplicarSoliCostosMotAdic->sca_estado = $value['sca_estado'];
                $duplicarSoliCostosMotAdic->save();
            }
        }
            
        $validarDetalle = collect($data['costo']['detalle'])->isNotEmpty();
        if ($validarDetalle == true) {
            $duplicarSoliCostosDetAdic = new TSoliCostosDetAdic;
            $duplicarSoliCostosDetAdic->scd_soc_id = $duplicarSoliCostos['soc_id'];
            $duplicarSoliCostosDetAdic->scd_detalle = $value['costo']['detalle']['scd_detalle'];
            $duplicarSoliCostosDetAdic->scd_valor = $value['costo']['detalle']['scd_valor'];
            $duplicarSoliCostosDetAdic->scd_estado = $value['costo']['detalle']['scd_estado'];
            $duplicarSoliCostosDetAdic->save();
        }

        //Duplicado SoliObjetivos
        $duplicarSoliObjetivos = new TSoliObjetivos;
        $duplicarSoliObjetivos->soo_sol_id = $duplicarSolicitudNego['sol_id'];
        $duplicarSoliObjetivos->soo_pecomini = $data['objetivo']['soo_pecomini'];
        $duplicarSoliObjetivos->soo_pecomfin = $data['objetivo']['soo_pecomfin'];
        $duplicarSoliObjetivos->soo_mese = $data['objetivo']['soo_mese'];
        $duplicarSoliObjetivos->soo_costonego = $data['objetivo']['soo_costonego'];
        $duplicarSoliObjetivos->soo_pinventaestiline = $data['objetivo']['soo_pinventaestiline'];
        $duplicarSoliObjetivos->soo_venpromeslin = $data['objetivo']['soo_venpromeslin'];
        $duplicarSoliObjetivos->soo_venprolin6m = $data['objetivo']['soo_venprolin6m'];
        $duplicarSoliObjetivos->soo_venestlin = $data['objetivo']['soo_venestlin'];
        $duplicarSoliObjetivos->soo_pcrelin = $data['objetivo']['soo_pcrelin'];
        $duplicarSoliObjetivos->soo_ventmargilin = $data['objetivo']['soo_ventmargilin'];
        $duplicarSoliObjetivos->soo_pvenmarlin = $data['objetivo']['soo_pvenmarlin'];
        $duplicarSoliObjetivos->soo_ventapromtotal = $data['objetivo']['soo_ventapromtotal'];
        $duplicarSoliObjetivos->soo_ventapromseisme = $data['objetivo']['soo_ventapromseisme'];
        $duplicarSoliObjetivos->soo_ventaestitotal = $data['objetivo']['soo_ventaestitotal'];
        $duplicarSoliObjetivos->soo_pcreciestima = $data['objetivo']['soo_pcreciestima'];
        $duplicarSoliObjetivos->soo_ventamargi = $data['objetivo']['soo_ventamargi'];
        $duplicarSoliObjetivos->soo_pinverestima = $data['objetivo']['soo_pinverestima'];
        $duplicarSoliObjetivos->soo_pinvermargi = $data['objetivo']['soo_pinvermargi'];
        $duplicarSoliObjetivos->soo_vemesantes = $data['objetivo']['soo_vemesantes'];
        $duplicarSoliObjetivos->soo_veprome = $data['objetivo']['soo_veprome'];
        $duplicarSoliObjetivos->soo_vemesdespues = $data['objetivo']['soo_vemesdespues'];
        $duplicarSoliObjetivos->soo_observacion = $data['objetivo']['soo_observacion'];
        $duplicarSoliObjetivos->soo_venprolin6m_2 = $data['objetivo']['soo_venprolin6m_2'];
        $duplicarSoliObjetivos->t_soliobjetivoscol = $data['objetivo']['t_soliobjetivoscol'];
        $duplicarSoliObjetivos->soo_ventaverificacion = $data['objetivo']['soo_ventaverificacion'];
        $duplicarSoliObjetivos->soo_cumpliovenreallineas = $data['objetivo']['soo_cumpliovenreallineas'];
        $duplicarSoliObjetivos->soo_pinventaestilineReal = $data['objetivo']['soo_pinventaestilineReal'];
        $duplicarSoliObjetivos->soo_pcrelinReal = $data['objetivo']['soo_pcrelinReal'];
        $duplicarSoliObjetivos->soo_pvenmarlinReal = $data['objetivo']['soo_pvenmarlinReal'];
        $duplicarSoliObjetivos->soo_ventmargilinReal = $data['objetivo']['soo_ventmargilinReal'];
        $duplicarSoliObjetivos->soo_ventatotalcliente = $data['objetivo']['soo_ventatotalcliente'];
        $duplicarSoliObjetivos->soo_ventamargiReal = $data['objetivo']['soo_ventamargiReal'];
        $duplicarSoliObjetivos->soo_pinverestimaReal = $data['objetivo']['soo_pinverestimaReal'];
        $duplicarSoliObjetivos->soo_pinvermargiReal = $data['objetivo']['soo_pinvermargiReal'];
        $duplicarSoliObjetivos->save();

        $response = compact('duplicarSolicitudNego', 'duplicarSoliZona', 'duplicarSoliSucursal', 'duplicarSoliTipoNego', 'duplicarSoliCausalNego', 'duplicarSoliCostos', 'duplicarSoliCostosLineas', 'duplicarSoliCostosMotAdic', 'duplicarSoliCostosDetAdic', 'duplicarSoliObjetivos');
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
    public function update(Request $request, $sol_id)
    {
        $anular = TSolicitudNego::find($sol_id);
        $data = $request->all();

        $anular->sol_ser_id = 9;
        $anular->sol_sef_id = 4;
        $anular->sol_set_id = 0;
        $anular->sol_observacionanulacion = $data['sol_observacionanulacion'];
        $anular->save();

        return response()->json($anular);
    }

    public function updatePeriEje(Request $request)
    {
        $data = $request->all();
        $cambioFechaEje = TSolicitudNego::find($data['sol_id']);

        $cambioFechaEje->sol_peri_ejeini = Carbon::parse($data['sol_peri_ejeini'])->format('Y-m-d');
        $cambioFechaEje->sol_peri_ejefin = Carbon::parse($data['sol_peri_ejefin'])->format('Y-m-d');
        $cambioFechaEje->sol_meseseje = $data['sol_meseseje'];
        $cambioFechaEje->sol_observacioncameje = $data['sol_observacioncameje'];
        $cambioFechaEje->save();

        return response()->json($cambioFechaEje);
    }

    public function confirmarBono(Request $request)
    {
        $data = $request->all();

        $confirBonoSolicitudNego = TSolicitudNego::find($data['sol_id']);
        $confirBonoSolicitudNego->sol_set_id = 4;
        $confirBonoSolicitudNego->sol_obsconfirbono = $data['sol_obsconfirbono'];
        $confirBonoSolicitudNego->sol_fechaconfirbono = Carbon::parse('now')->format('Y-m-d H:i:s');
        $confirBonoSolicitudNego->save();

        $crearHistorialTesoreria = new TSoliTesoreriaHis;       
        $crearHistorialTesoreria->sth_sol_id = $data['sol_id'];
        $crearHistorialTesoreria->sth_fecha = Carbon::parse('now')->format('Y-m-d H:i:s');
        $crearHistorialTesoreria->sth_usuario = $data['usuarioLog']['login'];
        $crearHistorialTesoreria->sth_tipo = 'Confirmación de Bono';
        $crearHistorialTesoreria->stn_observaciones = $data['sol_obsconfirbono'];
        $crearHistorialTesoreria->save();

        $response = compact('confirBonoSolicitudNego', 'crearHistorialTesoreria');
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

    public function imprimirActa()
    {   
        $fecha = Carbon::now();
        $fechaDia = Carbon::parse($fecha)->day;
        $fechaMes = Carbon::parse($fecha)->month;
        $fechaAno = Carbon::parse($fecha)->year;

        $response = compact('fechaDia', 'fechaMes', 'fechaAno');

        // return view('layouts.negociaciones.ActaAuditoria.actaAuditoria', $response);
        $pdf = PDF::loadView('layouts.negociaciones.ActaAuditoria.actaAuditoria', $response);
        return $pdf->download('Formato_bono_negociacion.pdf');
    }

    public function saveActas(Request $request)
    {   
        $data = $request->all();
        $file = $request->file('fileActa');
        $nombre = $file->getClientOriginalName();

        \Storage::disk('public')->put($nombre, \File::get($file));

        $newActa = new TSoliActaEntrega;
        $newActa->sae_sol_id = $data['sol_id'];
        $newActa->sae_acta = $nombre;
        $newActa->sae_cedula = $data['cedula'];
        $newActa->sae_nombre = $data['nombre'];
        $newActa->sae_direccion = $data['direccion'];
        $newActa->sae_ciudad = $data['ciudad'];
        $newActa->sae_observaciones = $data['observaciones'];
        $newActa->sae_usuario = $data['idUsuario'];
        $newActa->sae_fecha = Carbon::now();
        $newActa->sae_estado = 1;
        $newActa->save();

        $response = compact('ruta', 'titulo', 'recarguemos');
        return redirect()->route('misSolicitudes.index', ['id' => $data['sol_id']]);
    }

    public function saveFotos(Request $request)
    {
        $data = $request->all();
        $file = $request->file('fileFoto');
        $nombre = $file->getClientOriginalName();

        \Storage::disk('public')->put($nombre, \File::get($file));

        $newFoto = new TSoliReviExhibicion;
        $newFoto->sre_sol_id = $data['sol_id'];
        $newFoto->sre_foto = $nombre;
        $newFoto->sre_cumplio = $data['cumplio'];
        $newFoto->sre_puntovento = $data['puntoVenta'];
        $newFoto->sre_observacion = $data['observaciones'];
        $newFoto->sre_usuario = $data['idUsuario'];
        $newFoto->sre_fecha = Carbon::now();
        $newFoto->sre_estado = 1;
        $newFoto->save();

        $response = compact('ruta', 'titulo', 'recarguemos');
        return redirect()->route('misSolicitudes.index', ['id' => $data['sol_id']]);
    }

}
