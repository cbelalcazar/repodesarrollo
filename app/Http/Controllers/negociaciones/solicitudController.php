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
