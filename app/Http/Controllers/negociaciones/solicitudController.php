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
use App\Models\negociaciones\TBaseImpuesto;
use App\Models\negociaciones\TSoliTipoNego;
use App\Models\Genericas\TVendedor;
use App\Models\Genericas\TCanal;
use App\Models\Genericas\TCliente;
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
        $response = compact('ruta', 'titulo');
        return view('layouts.negociaciones.solicitud', $response);
    }

    /**
     * return json with information
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudGetInfo()  
    {
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

        $zonas = TCentroOperaciones::whereIn('cen_id', $agruZonasSucursal)->get();

        $response = compact('usuario', 'claseNegociacion', 'negoAnoAnterior', 'tipNegociacion', 'VendedorSucursales', 'canales', 'clientes', 'idClientes', 'negociacionPara', 'agruZonasSucursal', 'zonas', 'listaPrecios', 'eventoTemp', 'tipoDeNegociacion', 'tipoDeServicio', 'causalesNego');
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

            $objSoliNego= TSolicitudNego::create($data);
          
            foreach ($data['arrayZona'] as $key => $value) {
                $value['szn_coc_id'] = $value['szn_coc_id']['cen_id']; // Id zona             
                $value['szn_estado'] = 1; // estado
                $objSoliNego->soliZona()->create($value);
            }

            foreach ($data['arraySucursales'] as $key => $value) {
                $objSucur = [];
                $objSucur['ssu_suc_id'] = $value['suc_id']; // Id de la sucursal                    
                $objSucur['ssu_estado'] = 1; // Estado
                $objSucur['ssu_ppart'] = $value['porcentParti']; // porcentaje participacion                    
                $objSoliNego->soliSucu()->create($objSucur);
            }

            $contacto = TCliente::with('tercero', 'tercero.contacto')->where('cli_id', $data['sol_cli_id'])->first();

            $ciudad = $contacto['tercero']['contacto']['idCiudadContacto'];
            $departamento = $contacto['tercero']['contacto']['idDepartamentoContacto'];
            $pais = $contacto['tercero']['contacto']['idPaisContacto'];

            $baseImpuestos = [];
            foreach ($data['arrayTipoNegociacion'] as $key => $value) {
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

                $objSoliNego->soliTipoNego()->create($objTipoNego);
                array_push($baseImpuestos, $objTipoNego);
                array_push($baseImpuestos, $impuestos);
            }

            foreach ($data['arrayCausalNegociacion'] as $key => $value) {
            	$value['scn_can_id'] = $value['scn_can_id']['can_id'];
            	$value['scn_estado'] = 1;
            	$objSoliNego->causal()->create($value);
            }

            $url = route('solicitud.edit', ['id' => $objSoliNego['sol_id'], 'redirecTo' => "adelante"]);

        } catch (Exception $e) {
            return response()->json(['Error' => 'Error']);
        }

        $response = compact('data', 'baseImpuestos', 'contacto', 'url');
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
        dd($id);
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
