<?php

namespace App\Http\Controllers\recepcionproveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\bd_wmsmaterialempaque\TEntradawm;

class docEntradaAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "Sistema de Administracion de Almacenamiento (WMS) // Validacion Documentos en Ciego";
        $titulo =  "Validacion documento ciego";
        return view('layouts/recepcionproveedores/wmsmaterialempaque/indexValidacionCiego', compact('ruta' , 'titulo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function docEntradaAlmacenGetInfo()
    {
        // Falta un join con bd_wmsservi.t_tiposubicacion
        $entradas = TEntradawm::where([['entm_txt_estadocreacion', 'Cerrado'], ['entm_txt_estadodocumento', 'En Proceso']])->orderBy('entm_int_id')->get();
        $response = compact('entradas');
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
        $ruta = "Sistema de Administracion de Almacenamiento (WMS) // Validacion de Documentos en Ciego";
        $titulo =  "Validacion documento en ciego";
        $info = $id;
        return view('layouts/recepcionproveedores/wmsmaterialempaque/formValidDocCiego', compact('ruta', 'titulo', 'info'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function formValidacionCiegoGetInfo(Request $request)
    {
        $data = $request->all();
        $entrada = TEntradawm::with('TRefentrada')->where('entm_int_id', $data[0])->first();
        $response = compact('data', 'entrada');
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarEntrada(Request $request)
    {
        $data = $request->all();
        $response = compact('data');
        return response()->json($response);
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
