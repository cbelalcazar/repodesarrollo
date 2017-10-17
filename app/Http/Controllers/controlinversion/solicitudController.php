<?php

namespace App\Http\Controllers\controlinversion;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BESA\lineasProducto;
use App\Models\controlinversion\TFacturara;
use App\Models\controlinversion\TTiposalida;
use App\Models\controlinversion\TTipopersona;
use App\Models\controlinversion\TCargagasto;
use App\Models\controlinversion\TLineascc;
use App\Models\Genericas\Tercero;
use App\Models\Genericas\TItemCriteriosTodo;

class solicitudController extends Controller
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
    public function create()
    {
        $ruta = 'Control de Inversion // Crear Solicitud';
        $titulo = 'CREAR SOLICITUD';
        return view('layouts.controlinversion.solicitud.formsolicitud', compact('ruta','titulo'));
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
     * Consulta y retorna a la vista en formato JSON, Cargue Inicial
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    public function solicitudGetInfo()
    {
        $personas = TFacturara::with('tercero')->get();
        $tiposalida = TTiposalida::where('tsd_estado', '1')->get();
        $tipopersona = TTipopersona::where('tpe_estado', '1')->get();
        $cargagasto = TCargagasto::where('cga_estado', '1')->get();
        $lineasproducto = TLineascc::with('LineasProducto')->where('lcc_centrocosto','!=','0')->get();
        $colaboradores = Tercero::with('Cliente.Sucursales')->where([['indxEstadoTercero', '1'], ['indxEmpleadoTercero', '1']])->orderBy('razonSocialTercero')->get();
        $colaboradores = $colaboradores->filter(function($value, $key){    
            return ($value['Cliente'] != null && $value['Cliente']['Sucursales'] != null && count($value['Cliente']['Sucursales']) > 0 && strlen($value['idTercero']) > 5);   
        })->values();
        
        $item = TItemCriteriosTodo::where('ite_cod_tipoinv', '1051')->get();
        

        $response = compact('personas','tiposalida', 'tipopersona', 'cargagasto', 'lineasproducto', 'colaboradores', 'users', 'item');
        return response()->json($response);
    }    
}
