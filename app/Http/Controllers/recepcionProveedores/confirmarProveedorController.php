<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TProgramacion;
use App\Models\recepcionProveedores\TCita;

class confirmarProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = "CITAS";
        $ruta = "Proveedores // Citas";
        return view("layouts.recepcionProveedores.confirmarProveedor.confirmarIndex", compact('titulo', 'ruta'));
    }


    /**
     * Retorna a la vista las consultas de cargue inicial
     * 
     * Return JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmarProveedorGetInfo()
    {
        // Falta filtrar las programaciones de acuerdo con el proveedor logueado
        $nit = '890319254';
        $programaciones = TProgramacion::where([['prg_estado', 3], ['prg_nit_proveedor', $nit]])->orderBy('prg_fecha_programada')->get();
        // Consulto las citas sin confirmar con todas su programaciones asignadas para el mismo proveedor
        $citas = TCita::with('programaciones')->where('cit_nitproveedor', $nit)->whereIn('cit_estado', ['CONFIRMADA', 'PENDCONFIRPROVEE'])->get();
        $response = compact('programaciones', 'citas');
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

        $update = TCita::find($data['id']);
        $update->cit_estado = "CONFIRMADA";
        $objetoCalendario = $update['cit_objcalendarcita'];
        $json = json_decode($objetoCalendario);
        $json->estado = "CONFIRMADA";
        $update['cit_objcalendarcita'] = json_encode($json);
        $update->save();

        $programaciones = TProgramacion::where('prg_idcita', $data['id'])->update(['prg_estado' => 6]);

        $response = compact('data');
        return response()->json($response);
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
        $data = $request->all(); 
        $fechaEntrega = $data[0]['fechaEntrega'];
        $observacionNueva = $data[0]['observacionNueva'];
        foreach ($data as $key => $value) {
            $prg_cantidadempaques = $value['confirCantidad'] / $value['cantEmpaque']; 
            $prg_tipoempaque = $value['tipoEmpaque'] . ' de ' . $value['cantEmpaque'];
            $objProg = TProgramacion::where('id', $value['id'])
            ->update(['prg_fecha_programada' => $fechaEntrega, 
                      'prg_cant_programada' => $value['confirCantidad'], 
                      'prg_estado' => 2, 'prg_observacion' => $observacionNueva, 'prg_cantidadempaques' => $prg_cantidadempaques, 'prg_tipoempaque' =>$prg_tipoempaque]);
        }
        $response = compact('data', 'request1');
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rechazo(Request $request)
    {
        $citaSeleccionada = $request->all();
        $updateCita = TCita::where('id', $citaSeleccionada['id'])->update(['cit_estado' => 'RECHAZOPROV']);
        $programaciones = TProgramacion::where('prg_idcita', $citaSeleccionada['id'])
                                               ->update(['prg_estado' => 4]);
        return response()->json($updateCita);

    }
}
