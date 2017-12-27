<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\negociaciones\ClaseNegociacion;

class claseNegociacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "NEGOCIACIONES V2 // CATALOGO - CLASE DE NEGOCIO";
        $titulo = "Catalogo - Clase de Negocio";
        $response = compact('ruta', 'titulo');
        return view('layouts.negociaciones.Catalogos.claseNegociacionIndex', $response);
    }
        
    public function getInfo()
    {
        $clases = ClaseNegociacion::all();

        $response = compact('clases');
        return response()->json($response);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $creacion = ClaseNegociacion::create($data);
        return response()->json($creacion);
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
        $clase = ClaseNegociacion::find($id);
        $data = $request->all();
        $clase->cneg_descripcion = $data['cneg_descripcion'];
        $clase->save();

        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clase = ClaseNegociacion::find($id);
        $clase->delete();
        return response()->json($clase); 
    }

}