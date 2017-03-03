<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;

use App\Models\Importacionesv2\TTipoImportacion;
use App\Models\Importacionesv2\TTipoNacionalizacion;
use \Cache;
use Illuminate\Http\Request;

class TNacionalizacionImportacionController extends Controller
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
    public function create(Request $request, $id)
    {
        $idImportacion=$id;
        #Contiene el titulo de formulario
        $titulo = "CREAR NACIONALIZACION Y COSTEO DE IMPORTACION";
        #String que hace referencia al URI del route que se le pasa al formulario y genere la url de post
        $url = "importacionesv2/NacionalizacionCosteo";
        #crea los array de las consultas para mostrar en los combobox en el formulario
        $consulta = array(1);
        $combos = $this->consultas($consulta);
        extract($combos);
        #Envia la informacion a la vista
        return view('importacionesv2.NacionalizacionCosteoTemplate.createNacionalizacionCosteo', 
            compact('titulo',
                'url',
                'idImportacion',
                'naco_tipo_importacion',
                'naco_tipo_nacionalizacion'));

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



 /**
    * Funcion creada para generar las consultas de los combobox en las funciones create y edit
    *
    */
 public function consultas($consulta)
 {
    $combos = array();
        // Combobox TIPO IMPORTACION
    if(in_array(1, $consulta)){
        $array = Cache::remember('tipoimportacion', 60, function() {return TTipoImportacion::all();});
        $naco_tipo_importacion = array();
        foreach ($array as $key => $value) {$naco_tipo_importacion["$value->id"] = $value->timp_nombre;}
        $combos['naco_tipo_importacion'] = $naco_tipo_importacion;
    }

        // Combobox TIPO NACIONALIZACION
    if(in_array(1, $consulta)){
        $array = TTipoNacionalizacion::all();
        $naco_tipo_nacionalizacion = array();
        foreach ($array as $key => $value) {$naco_tipo_nacionalizacion["$value->id"] = $value->tnac_descripcion;}
        $combos['naco_tipo_nacionalizacion'] = $naco_tipo_nacionalizacion;
    }

    return $combos;
}

}
