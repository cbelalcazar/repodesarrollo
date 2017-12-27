<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Genericas\TCliente;
use App\Models\Genericas\TCanal;


class solicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "NEGOCIACIONES V2 // MIS SOLICITUDES";
        $titulo = "Mis solicitudes";
        $response = compact('ruta', 'titulo');
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
    public function solicitudGetInfo()  
    {
        $usuario = Auth::user();
        $claseNegociacion = ClaseNegociacion::all();
        $negoAnoAnterior = NegociacionAnoAnterior::all();
        $tipNegociacion = TipNegociacion::all();

        // Obtengo los clientes con sus sucursales
        $clientesSucursales = TCliente::with('TSucursal')->where('ter_id', $usuario['idTerceroUsuario'])->get();
        // dd($clientesSucursales['TSucursal']);
        // $canales = TCanal::whereIn('can_id', )->get();

        $response = compact('usuario', 'claseNegociacion', 'negoAnoAnterior', 'tipNegociacion', 'clientesSucursales', 'canales');
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
