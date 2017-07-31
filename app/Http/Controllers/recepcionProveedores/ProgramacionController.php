<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use \Cache;

class ProgramacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = 'PROGRAMACIÓN DE ORDENES';
        $ruta = 'Programacion // Crear Programación';
        return view('layouts.recepcionProveedores.programacion.ProgramacionIndex', compact('titulo', 'ruta'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function programacionGetInfo()
    {
        ini_set('memory_limit', '-1');
        $item_txt_nitproveedor = Cache::remember('proveedores', 60, function(){
            return Tercero::all();
        });        
        $response = compact('item_txt_nitproveedor');
        return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referenciasPorOc(Request $request)
    {
        $request = $request->nombre; 
        $response = compact('request');
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
