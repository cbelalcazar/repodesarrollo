<?php

namespace App\Http\Controllers\negociaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\negociaciones\NegociacionAnoAnterior;

class negociacionAnteriorController extends Controller
{
    /**
     * Display a listing of the resource.
     *1
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "NEGOCIACIONES V2 // CATALOGO - NEGOCIO AÑO ANTERIOR";
        $titulo = "Catalogo - Negocio año anterior";
        $response = compact('ruta', 'titulo');
        return view('layouts.negociaciones.Catalogos.negociacionAnoAnteriorIndex', $response);
    }
        
    public function getInfo()
    {
        $negoanos = NegociacionAnoAnterior::all();
        $response = compact('negoanos');
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
        $creacion = NegociacionAnoAnterior::create($data);
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
        $negoano = NegociacionAnoAnterior::find($id);
        $data = $request->all();
        $negoano->nant_descripcion = $data['nant_descripcion'];
        $negoano->save();
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
        $negoano = NegociacionAnoAnterior::find($id);
        $negoano->delete();
        return response()->json($negoano); 
    }

}