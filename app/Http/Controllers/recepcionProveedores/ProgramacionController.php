<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\recepcionProveedores\TProgramacion;
use \Cache;
use DB;
use Validator;
use Carbon\Carbon;

class ProgramacionController extends Controller
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'prg_num_orden_compra' => 'required',
        'prg_tipo_doc_oc' => 'required',
        'prg_referencia' => 'required',
        'prg_nit_proveedor' => 'required',
        'prg_fecha_programada' => 'required',
        'prg_cant_programada' => 'required',
        'prg_cant_solicitada_oc' => 'required',
        'prg_cant_entregada_oc' => 'required',
        'prg_cant_pendiente_oc' => 'required',
        'prg_fecha_ordenCompra' => 'required',
        'prg_consecutivoRefOc' => 'required',
        'prg_unidad_empaque' => 'required',
        'prg_cant_embalaje' => 'required',
        'prg_estado' => 'required',
        ];

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
        'prg_num_orden_compra.required' => 'Ingresar consecutivo de orden de compra',
        'prg_tipo_doc_oc.required' => 'Ingresar tipo documento orden de compra',
        'prg_referencia.required' => 'Ingresar referencia orden de compra',
        'prg_nit_proveedor.required' => 'Ingresar nit proveedor orden de compra',
        'prg_fecha_programada.required' => 'Ingresar fecha programada',
        'prg_cant_programada.required' => 'Ingresar cantidad programada',
        'prg_cant_solicitada_oc.required' => 'Ingresar cantidad solicitada orden de compra',
        'prg_cant_entregada_oc.required' => 'Ingresar cantidad entregada orden de compra',
        'prg_cant_pendiente_oc.required' => 'Intresar cantidad pendiente orden de compra',
        'prg_fecha_ordenCompra.required' => 'Ingresar fecha entrega orden de compra',
        'prg_consecutivoRefOc.required' => 'Ingresar consecutivo por referencia orden de compra',
        'prg_unidad_empaque.required' => 'Ingresar unidad de empaque orden de compra',
        'prg_cant_embalaje.required' => 'Ingresar embalaje orden de compra',
        'prg_estado.required' => 'Ingresar estado orden de compra',
        ];
    }


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
        $item_txt_nitproveedor = Tercero::where('indxProveedorTercero', '1')->get();
        $progPendEnvio = TProgramacion::where('prg_estado','1')->get();
        $response = compact('item_txt_nitproveedor', 'progPendEnvio');
        return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referenciasPorOc(Request $request)
    {
        $proveedor = $request->proveedor; 
        // $refExcluir = TProgramacion::select('prg_consecutivoRefOc', 'prg_cant_programada', 'prg_cant_pendiente_oc')->all();
        // $refExcluir = DB::connection('bd_recepcionProveedores')->selectRaw('select prg_consecutivoRefOc, prg_cant_programada, prg_cant_pendiente_oc, sum(prg_cant_programada) from t_programacion group by prg_consecutivoRefOc having (sum(prg_cant_programada) >= prg_cant_pendiente_oc)');
        $refExcluir = [];
        $refExcluir = DB::connection('bd_recepcionProveedores')->table('t_programacion')
                ->select('prg_consecutivoRefOc', DB::raw('SUM(prg_cant_programada) as total_prog, prg_cant_pendiente_oc'))
                ->groupBy('prg_consecutivoRefOc')
                ->havingRaw('SUM(prg_cant_programada) >= prg_cant_pendiente_oc')
                ->get();
        $refExcluir = array_pluck($refExcluir, 'prg_consecutivoRefOc');
        $referencias = $this->referenciasOrOc($proveedor['nitTercero'], 2, $refExcluir);
        $ordenes = $this->referenciasOrOc($proveedor['nitTercero'], 1, $refExcluir);
        $response = compact('proveedor', 'referencias', 'ordenes', 'refExcluir');
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
        $objProg = $request->all();
        $objProg['prg_fecha_programada'] = Carbon::parse($objProg['prg_fecha_programada'])->format('Y-m-d');
        $objProg['prg_fecha_ordenCompra'] = Carbon::parse($objProg['prg_fecha_ordenCompra'])->format('Y-m-d');
        $objProg['prg_cant_entregada_oc'] = round(intval($objProg['prg_cant_entregada_oc']));
        $objProg['prg_cant_pendiente_oc'] = round(intval($objProg['prg_cant_pendiente_oc']));
        $objProg['prg_cant_solicitada_oc'] = round(intval($objProg['prg_cant_solicitada_oc']));
        $objProg['prg_referencia'] = trim($objProg['prg_referencia']);

        $validator = Validator::make($objProg, $this->rules(), $this->messages());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }else{
            $objProg = TProgramacion::create($objProg);
            return response()->json($objProg);
        }
        
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
     * consProveePorMesUnoeMatEmpaq($fechaInicial, FechaFinal)
     * 
     * Esta funcion consulta y retorna los proveedores que debo evaluar para un mes en especifico solo de material de empaque
     * 
     * Filtra por:
     * Tipo de documento
     * Estado de documento
     * Tipo de inventario
     * Fecha de entrega
     *
     * @return ConsultaUNOEE
     */
      public function referenciasOrOc($nitProveedor, $seleccionConsulta, $refYaProgramadas){
        if ($seleccionConsulta == 2) {
            return DB::connection('besa')->table('102_OrdenCompra')
            ->select('Referencia', 'DescripcionReferencia')
            ->whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB'])
            ->whereIn('EstadoMovto', ['1', '2'])
            ->whereIn('TipoInventario', ['INMP'])
            ->whereNotIn('f421_rowid', $refYaProgramadas)
            ->where('NitTercero', 'like', "%".$nitProveedor."%")
            ->groupBy('Referencia', 'DescripcionReferencia')
            ->orderBy('Referencia', 'desc')
            ->get();
        } elseif($seleccionConsulta == 1) {
            return DB::connection('besa')->table('102_OrdenCompra')
            ->whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB'])
            ->whereIn('EstadoMovto', ['1', '2'])
            ->whereIn('TipoInventario', ['INMP'])
            ->whereNotIn('f421_rowid', $refYaProgramadas)
            ->where('NitTercero', 'like', "%".$nitProveedor."%")
            ->get();
        }
        
        
    }

}
