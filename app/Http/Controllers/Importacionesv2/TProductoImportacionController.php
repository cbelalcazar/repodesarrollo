<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use App\Models\Importacionesv2\TProductoImportacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Redirect;


/**
 * @resource TProductoImportacionController
 *
 * Controlador creado para el proceso alertas de producto importacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TProductoImportacionController extends Controller
{
    /**
     * index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * show
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * edit
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
     * update
     * 
     * Esta funcion recibe el request con la informacion del producto importacion y el id del producto importacion
     * 
     * Debe actualizar el producto importacion con la informacion que se ingresa en el sistema
     * 
     * Debe redireccionar a la pagina de consulta de alertas
     * 
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $urlErrorReturn = route('ProductoImportacion.edit', ['ProductoImportacion' => $id]);
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
        }elseif($request->pdim_fecha_anticipado == "" && $declaracion){
            return redirect($urlErrorReturn)->withErrors('Debe ingresar la fecha de declaracion anticipada')->withInput(); 
        }

        if($request->pdim_numero_licencia_importacion != "" && $registroImportacion){
            $producto->pdim_numero_licencia_importacion = $request->pdim_numero_licencia_importacion;
            $producto->pdim_fech_cierre_registro_importacion =  Carbon::now()->format('Y-m-d');
        }elseif($request->pdim_numero_licencia_importacion == "" && $registroImportacion){
             return redirect($urlErrorReturn)->withErrors('Debe ingresar el numero de registro de importacion')->withInput(); 
        }

        $producto->pdim_alerta = 0;
        $producto->save();

        $url = route('consultaAlertas');
        Session::flash('message', 'La alerta fue cerrada exitosamente!');
        return Redirect::to($url);

    }

    /**
     * destroy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
