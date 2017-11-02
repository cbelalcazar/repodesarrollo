<?php

namespace App\Http\Controllers\controlinversion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\controlinversion\TNiveles;
use App\Models\controlinversion\TPerniveles;
use App\Models\BESA\VendedorZona;

class nivelesAutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruta = "Control inversiones // Catalogos // Niveles de autorizacion";
        $titulo = "NIVELES DE AUTORIZACION";
        return view('layouts.controlinversion.nivelesautorizacion.indexnivautorizacion', compact('ruta', 'titulo'));
    }

    public function nivelesAutorizacionGetInfo()
    {
        $terceros = Tercero::with('usuario')->where('indxEstadoTercero', 1)->get();
        $niveles = TNiveles::all();
        $VendedorZona = VendedorZona::with('usuario')->select('NitVendedor as idTercero', 'NomVendedor as razonSocialTercero')->where('estado', 1)->get();
        $tercerosSinUsuario = [];
        foreach ($terceros as $key => $value) {
            if($value['usuario'] != null){
                array_push($tercerosSinUsuario, $value);
            }
        }
        $terceros = $tercerosSinUsuario;
        $response = compact('terceros', 'niveles', 'VendedorZona');
        // ['terceros' => [{},{},...n{}], 'niveles' => [{},{},...n{}], 'VendedorZona' => [{},{},...n{}]]
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
        $persona = new TPerniveles;
        $persona->pern_usuario = $data['selectedItem']['usuario']['login'];
        $persona->pern_nombre = $data['selectedItem']['razonSocialTercero'];
        $persona->pern_cedula = $data['selectedItem']['idTercero'];
        $persona->pern_nomnivel = $data['nivel']['id'];

        $persona->save();

        return $persona;
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
