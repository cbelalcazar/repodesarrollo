<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TProgramacion;

class confirmarProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = "SOLICITAR CITAS Y CONFIRMAR PROGRAMACIONES";
        $ruta = "Proveedores // Solicitar cita y confirmar programaciones";
        return view("layouts.recepcionProveedores.confirmarProveedor.confirmarIndex", compact('titulo', 'ruta'));
    }


    /**
     * Retorna a la vista las consultas de cargue inicial
     * 
     * Return JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmarProveedorGetInfo()
    {
        // Falta filtrar las programaciones de acuerdo con el proveedor logueado
        $programaciones = TProgramacion::where([['prg_estado', 3], ['prg_nit_proveedor', '860026759']])->orderBy('prg_fecha_programada')->get();
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
