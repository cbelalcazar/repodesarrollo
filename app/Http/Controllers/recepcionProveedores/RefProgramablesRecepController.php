<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TInfoReferencia;
use App\Models\Genericas\TItemcriteriosTodo;

class RefProgramablesRecepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = "Catalogo Referencias Programables";
        $ruta = "Recepcion Proveedores // Referencias Programables";
        $response = compact('titulo', 'ruta');
        return view('layouts.recepcionProveedores.catalogos.indexRefProgramables', $response);
    }

    public function getInfo(){
        $infoReferencias = TInfoReferencia::with('referencia')->get();
        $idReferenciasExcluir = collect($infoReferencias)->pluck('iref_referencia');
        $referenciasTodas = TItemcriteriosTodo::select('ite_referencia', 'ite_descripcion')->whereIn('ite_cod_tipoinv', [1052, 1053, 1055])->whereNotIn('ite_referencia', $idReferenciasExcluir)->where('ite_f121_ind_estado', 'Activo')->get();
        $response = compact('infoReferencias', 'referenciasTodas');
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
        $data = $request->all();
        $data['iref_referencia'] = $data['iref_referencia']['ite_referencia'];
        if (isset($data['id'])) {
            $resultado = TInfoReferencia::find($data['id'])->update($data);
        }else{
            $data['iref_programable'] = 'Programable';
            $resultado = TInfoReferencia::create($data); 
        }
        
        return response()->json($resultado);
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
        $delete = TInfoReferencia::find($id)->delete();
        return response()->json($delete);
    }
}
