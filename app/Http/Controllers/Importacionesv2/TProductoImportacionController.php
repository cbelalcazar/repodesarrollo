<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use App\Models\Importacionesv2\TProductoImportacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Redirect;

class TProductoImportacionController extends Controller
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
        //
        $producto = TProductoImportacion::find($id);
        $declaracion = false;
        $registroImportacion = false;

        if($producto->pdim_fech_req_declaracion_anticipado != null){
            $declaracion = true;
        }
        if($producto->pdim_fech_requ_registro_importacion != null){
            $registroImportacion = true;
        }
        #Contiene el titulo de formulario
        $titulo = "INGRESAR INFORMACION CIERRE DE ALERTA";
        #String que hace referencia al URI del route que se le pasa al formulario y genere la url de post
        $url = "importacionesv2/ProductoImportacion";

        $route = 'ProductoImportacion.update';
        return view('importacionesv2.importacionTemplate.cierreAlertas', 
            compact('titulo',
                'url',
                'declaracion',
                'registroImportacion',
                'route',
                'producto'));

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
        $producto = TProductoImportacion::find($id);
        $declaracion = false;
        $registroImportacion = false;        
        $fecha = Carbon::now();

        if($producto->pdim_fech_req_declaracion_anticipado != null){
            $declaracion = true;
        }
        if($producto->pdim_fech_requ_registro_importacion != null){
            $registroImportacion = true;
        }

        if($request->pdim_fecha_anticipado != "" && $declaracion){
            $producto->pdim_fecha_anticipado =  Carbon::parse($request->pdim_fecha_anticipado)->format('Y-m-d');
            $producto->pdim_fech_cierre_declaracion_anticipado =  Carbon::now()->format('Y-m-d');
        }
        if($request->pdim_numero_licencia_importacion != "" && $registroImportacion){
            $producto->pdim_numero_licencia_importacion = $request->pdim_numero_licencia_importacion;
            $producto->pdim_fech_cierre_registro_importacion =  Carbon::now()->format('Y-m-d');
        }   
        $producto->pdim_alerta = 0;
        $producto->save();

        $url = route('consultaAlertas');
        Session::flash('message', 'La alerta fue cerrada exitosamente!');
        return Redirect::to($url);

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
