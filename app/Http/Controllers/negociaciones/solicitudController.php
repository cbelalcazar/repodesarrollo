<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
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
use App\Models\Genericas\TVendedor;
use App\Models\Genericas\TCanal;
use App\Models\Genericas\TCliente;
use App\Models\Genericas\TLineas;
use App\Models\Genericas\TListaPrecios;
use App\Models\Genericas\TCentroOperaciones;


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
        $ruta = "NEGOCIACIONES V2 // CREAR SOLCITUD";
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
            $objeto = TSolicitudNego::with('soliZona', 'soliSucu', 'soliTipoNego', 'causal')->where('sol_id', $id)->first();
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
        // Obtengo el vendedor con sus sucursales
        $VendedorSucursales = TVendedor::with('TSucursal')
        ->where('ter_id', $usuario['idTerceroUsuario'])
        ->first();
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
        $urlMisSolicitudes = route('misSolicitudes.index');
        // Forma de pago
        $formaPago = TFormaPago::all();
        // Lineas
        $lineas = TLineas::where('lin_txt_estado', 'No')->get();


        $response = compact('usuario', 'claseNegociacion', 'negoAnoAnterior', 'tipNegociacion', 'VendedorSucursales', 'canales', 'clientes', 'idClientes', 'negociacionPara', 'agruZonasSucursal', 'zonas', 'listaPrecios', 'eventoTemp', 'tipoDeNegociacion', 'tipoDeServicio', 'causalesNego', 'objeto', 'clientesTodos', 'urlMisSolicitudes', 'formaPago', 'lineas');
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

            $url = route('solicitud.edit', ['id' => $objSoliNego['sol_id'], 'redirecTo' => $data['redirecTo']]);

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
        $ruta = "NEGOCIACIONES V2 // EDITAR SOLCITUD";
        $titulo = "EDITAR SOLICITUD";
        $adelante = $request->all()['redirecTo'];
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
        $deleteZonas = TSoliZona::where('szn_sol_id', $id)->delete();
        $negociacion = $this->crearSoliZonas($data['arrayZona'], $negociacion);

        // Sucursales update
        $delteSucursales = TSoliSucursal::where('ssu_sol_id', $id)->delete();
        $negociacion = $this->crearSoliSucursales($data['arraySucursales'], $negociacion);

        // tipo negociacion update
        $delteSoliTipoNego = TSoliTipoNego::where('stn_sol_id', $id)->delete();
        $negociacion = $this->crearSoliTipoNego($data['arrayTipoNegociacion'], $negociacion, $data['sol_cli_id']);

        $deleteSoliCausalNego = TSoliCausalNego::where('scn_sol_id', $id)->delete();
        $negociacion = $this->crearSoliCausales($data['arrayCausalNegociacion'], $negociacion);

        $response = compact('data', 'id');
        return response()->json($response);
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
        $departamento = $contacto['tercero']['contacto']['idDepartamentoContacto'];
        $pais = $contacto['tercero']['contacto']['idPaisContacto'];

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
                $retefuente = collect($impuestos[1])->last();
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

                if ($reteica['bai_dep_id'] > 0 && $objTipoNego['stn_costo'] >= $reteica['bai_base']) {
                    $objTipoNego['stn_valor_rtica'] = ($objTipoNego['stn_costo'] * $reteica['bai_tasa']) / 100;// stn_valor_rtfuente
                }else{
                    $objTipoNego['stn_valor_rtica'] = 0;// stn_valor_rtfuente
                }                
                $objTipoNego['stn_rtica_base'] = $reteica['bai_base']; // bai_base
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
                $objTipoNego['stn_valor_rtiva'] = 0;// stn_valor_rtfuente
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
}
