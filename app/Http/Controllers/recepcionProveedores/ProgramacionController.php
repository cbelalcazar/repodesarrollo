<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Genericas\Tercero;
use App\Models\recepcionProveedores\TProgramacion;
use App\Models\recepcionProveedores\TInfoReferencia;
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
        'prg_estado.required' => 'Ingresar estado orden de compra',
        ];
    }


    /**
     * Muestra el formulario por primera ves
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
     * Respuesta JSON a la peticion ajax que solicita los proveedores las programaciones creadas cuando se carga por primera ves la vista
     *
     * @return \Illuminate\Http\Response
     */
    public function programacionGetInfo()
    {
        $item_txt_nitproveedor = Tercero::where('indxProveedorTercero', '1')->get();
        $progPendEnvio = TProgramacion::whereIn('prg_estado', [1,2])->get();
        $infoReferencia = TInfoReferencia::all();
        $response = compact('item_txt_nitproveedor', 'progPendEnvio', 'infoReferencia');
        return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function referenciasPorOc(Request $request)
    {
        // Obtengo el proveedor
        $proveedor = $request->proveedor; 
        $refExcluir = [];
        // Consulto las referencias de este proveedor que actualmente tienen alguna programacion sin terminar (*OJOOOOO SIN FILTRO DE ESTADO TODAVIAAA*)
        $refExcluir = TProgramacion::refExcluir($proveedor);
        $refExcluir = array_pluck($refExcluir, 'prg_consecutivoRefOc');
        // Consulto las referencias y ordenes de compra para este proveedor en estado 1 aprobado, 2 parcial, excluyendo las que ya con las programaciones que estan montadas sin cerrar, completan su capacidad maxima de pedido.
        $referencias = TProgramacion::referenciasOrOc($proveedor['nitTercero'], 2, $refExcluir);
        $ordenes = TProgramacion::referenciasOrOc($proveedor['nitTercero'], 1, $refExcluir);
        // Retorno la informacion a la vista.
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
     * Crea un nuevo registro en la tabla t_programacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objProg = $request->all();
        // Da formato a las fechas y cantidades antes de guardar en la tabla t_programacion.
        $objProg['prg_fecha_programada'] = Carbon::parse($objProg['prg_fecha_programada'])->format('Y-m-d');
        $objProg['prg_fecha_ordenCompra'] = Carbon::parse($objProg['prg_fecha_ordenCompra'])->format('Y-m-d');
        $objProg['prg_cant_entregada_oc'] = round(intval($objProg['prg_cant_entregada_oc']));
        $objProg['prg_cant_pendiente_oc'] = round(intval($objProg['prg_cant_pendiente_oc']));
        $objProg['prg_cant_solicitada_oc'] = round(intval($objProg['prg_cant_solicitada_oc']));
        $objProg['prg_referencia'] = trim($objProg['prg_referencia']);

        // Pasa el registro a crear por las reglas de validacion, en caso de encontrar uno o mas errores los retorna a la vista, si no crea el registro
        $validator = Validator::make($objProg, $this->rules(), $this->messages());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }else{

            if ($objProg['id'] != "") {
                $update = TProgramacion::find($objProg['id']);
                $update->prg_fecha_programada = $objProg['prg_fecha_programada'];
                $update->prg_cant_programada = $objProg['prg_cant_programada'];
                $update->prg_observacion = $objProg['prg_observacion'];
                $update->save();
            } else {
                $objProg = TProgramacion::Create($objProg);
            }            
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
        $lista = $refExcluir = array_pluck($request->all(), 'id');
        $datosModificar = TProgramacion::whereIn('id', $lista)->update(['prg_estado' => 2]);
        return response()->json($datosModificar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objProg = TProgramacion::find($id);
        $objProg->delete();
        return response()->json('success');
    }



}
