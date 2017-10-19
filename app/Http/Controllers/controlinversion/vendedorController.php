<?php

namespace App\Http\Controllers\controlinversion;

use App\Models\BESA\VendedorZona;
use App\Models\BESA\Vendedores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class vendedorController extends Controller
{

   public function getInfo(){

     $vendedoresZona = VendedorZona::get();
     $zonas = VendedorZona::select('CodZona','NomZona')->distinct()->get();
     $subzonas = VendedorZona::select('CodZona','CodSubZona','NomSubZona')->distinct()->get();

     $codigosVendedores = [];
     foreach ($vendedoresZona as $key => $value) {
       $codigosVendedores[$key] = $value->CodVendedor;
     }

     $vendedoresBesa = Vendedores::whereNotIn('CodVendedor', $codigosVendedores)->get();

     $response = compact('vendedoresZona','zonas','subzonas','vendedoresBesa');

     return response()->json($response);

   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function show(VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function edit(VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendedorZona $vendedorZona)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BESA\VendedorZona  $vendedorZona
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendedorZona $vendedorZona)
    {
        //
    }
}
