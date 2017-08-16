<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TProgramacion;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = 'ASIGACION DE CITA';
        $ruta = 'Cita // Asignacion de cita';
        return view('layouts.recepcionProveedores.cita.citaIndex2', compact('titulo', 'ruta'));
    }

     /**
     * Respuesta JSON a la peticion ajax que solicita los proveedores las programaciones creadas cuando se carga por primera ves la vista
     *
     * @return \Illuminate\Http\Response
     */
    public function citaGetInfo()
    {
        $programaciones = TProgramacion::where('prg_estado', '2')->get();
        $programaciones = $programaciones->groupBy('prg_fecha_programada');
        $response = compact('programaciones');
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
