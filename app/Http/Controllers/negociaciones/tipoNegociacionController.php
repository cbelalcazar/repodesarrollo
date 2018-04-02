<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\negociaciones\TipNegociacion;

class tipoNegociacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "NEGOCIACIONES V2 // CATALOGO - TIPOS DE NEGOCIO";
        $titulo = "Catalogo - Tipos de Negocio";
        $response = compact('ruta', 'titulo');
        return view('layouts.negociaciones.Catalogos.tipoNegociacionIndex', $response);
    }
        
    public function getInfo()
    {
        $tipos = TipNegociacion::all();
        $response = compact('tipos');
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
        $creacion = TipNegociacion::create($data);
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
        $tipo = TipNegociacion::find($id);
        $data = $request->all();
        $tipo->tneg_descripcion = $data['tneg_descripcion'];
        $tipo->save();
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
        $tipo = TipNegociacion::find($id);
        $tipo->delete();
        return response()->json($tipo); 
    }

}