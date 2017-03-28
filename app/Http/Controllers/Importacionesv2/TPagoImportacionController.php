<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Validator;
use Session;
use Redirect;
use Carbon\Carbon;
use App\Models\Importacionesv2\TPagoImportacion;
use App\Models\Importacionesv2\TImportacion;
use Illuminate\Http\Request;
use Auth;
use App\Models\Importacionesv2\TPermisosImp;

class TPagoImportacionController extends Controller
{

     //REGLAS DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $rules = array('pag_importacion'=>'required',
    'pag_valor_total'=>'required',
    'pag_valor_fob'=>'required',
    'trm_liquidacion_factura'=>'required',
    'pag_fecha_factura'=>'required',
    'pag_fecha_envio_contabilidad'=>'required');

  //MENSAJES DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $messages = array('pag_importacion.required' => 'El proceso de pagos debe estar asociado a una importacion',
    'pag_valor_total.required' => 'Favor ingresar el valor total',
    'pag_valor_fob.required' => 'Favor ingresar el valor FOB',
    'trm_liquidacion_factura.required' => 'Favor ingresar el valor trm liquidacion factura',
    'pag_fecha_factura.required' => 'Favor ingresar la fecha de la factura',
    'pag_fecha_envio_contabilidad.required' => 'Favor ingresar la fecha de envio a contabilidad');

  public function __construct()
  {
    $this->middleware('ImpMid')->only([ 'update']);
}

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

      $importacion = TImportacion::find($idImportacion);
        #Contiene el titulo de formulario
      $titulo = "CREAR PAGO DE IMPORTACION - ". $importacion->imp_consecutivo;
        #String que hace referencia al URI del route que se le pasa al formulario y genere la url de post
      $url = "importacionesv2/Pagos";
        #Envia la informacion a la vista
      return view('importacionesv2.PagoTemplate.createPago', 
        compact('titulo',
            'url',
            'idImportacion'));
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
        $urlConsulta = route('consultaFiltros'); 


        $url = url("importacionesv2/Pagos/create");
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return redirect()->action(
                'Importacionesv2\TPagoImportacionController@create', ['id' => $request->pag_importacion]
                )->withErrors($validator)->withInput();
        }

        //Valida la existencia del registro que se intenta crear en la tabla de la bd 
        $validarExistencia = TPagoImportacion::where('pag_importacion', '=', "$request->pag_importacion")->get();

        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return redirect()->action(
                'Importacionesv2\TPagoImportacionController@create', ['id' => $request->pag_importacion]
                )->withErrors("Ya existe un proceso de pagos asociado a esta importacion")->withInput();   
        }
        //Crea el registro en la tabla importación
        $ObjectCrear = new TPagoImportacion;
        $ObjectCrear->pag_importacion = $request->pag_importacion;
        $ObjectCrear->pag_valor_anticipo = round($request->pag_valor_anticipo,2);
        $ObjectCrear->pag_valor_saldo = round($request->pag_valor_saldo,2);
        $ObjectCrear->pag_valor_comision = round($request->pag_valor_comision,2);
        $ObjectCrear->pag_valor_total = round($request->pag_valor_total,2);
        $ObjectCrear->pag_valor_fob = round($request->pag_valor_fob,2);
        $ObjectCrear->trm_liquidacion_factura = round($request->trm_liquidacion_factura,2);
        $ObjectCrear->pag_fecha_factura = Carbon::parse($request->pag_fecha_factura)->format('Y-m-d');
        $ObjectCrear->pag_fecha_envio_contabilidad = Carbon::parse($request->pag_fecha_envio_contabilidad)->format('Y-m-d');      
        
        if($request->pag_fecha_anticipo != ""){
         $ObjectCrear->pag_fecha_anticipo = Carbon::parse($request->pag_fecha_anticipo)->format('Y-m-d');
     }elseif ($request->pag_fecha_anticipo == "") {
        $ObjectCrear->pag_fecha_anticipo = null;
    }


    if($request->pag_fecha_saldo != ""){
      $ObjectCrear->pag_fecha_saldo = Carbon::parse($request->pag_fecha_saldo)->format('Y-m-d');       
  }elseif ($request->pag_fecha_saldo == "") {
      $ObjectCrear->pag_fecha_saldo = null;
  }

  $ObjectCrear->pag_numero_factura = strtoupper($request->pag_numero_factura);

  $ObjectCrear->save();

  Session::flash('message', 'El proceso de pago fue creado exitosamente!');
  return Redirect::to($urlConsulta);
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
         //Id del registro que deseamos editar
        $id = $id;
        //Consulto el registro que deseo editar
        $objeto = TPagoImportacion::with('importacion')->find($id);
        //Titulo de la pagina
        $titulo = "EDITAR PROCESO DE PAGO - ".$objeto->importacion->imp_consecutivo;

        
        //url de redireccion para consultar
        $url = route('Pagos.store');
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'Pagos.update';
        $urlBorrar = "";
        $hasPerm = $this->permisos();

        return view('importacionesv2.PagoTemplate.editPago', 
            compact('url',
               'titulo', 
               'route', 
               'id',
               'objeto',
               'urlBorrar',
               'hasPerm'));
    }

    public function permisos(){
        $usuario = Auth::user();
        $permisos = TPermisosImp::where('perm_cedula', '=',"$usuario->idTerceroUsuario")->first();
        if($permisos == null || $permisos->perm_cargo == 2){
            return 0;
        }elseif($permisos->perm_cargo == 1){
           return 1;
       }
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
        //Genera la url de consulta
        $url = route('consultaFiltros');
        //Consulto el registro a editar
        //Crea el registro en la tabla importacion
        
        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            return redirect()->action(
                'Importacionesv2\TPagoImportacionController@create', ['id' => $request->pag_importacion]
                )->withErrors($validator)->withInput();
        }

        $ObjectUpdate = TPagoImportacion::find($id);
        $ObjectUpdate->pag_valor_anticipo = round($request->pag_valor_anticipo,2);
        $ObjectUpdate->pag_valor_saldo = round($request->pag_valor_saldo,2);
        $ObjectUpdate->pag_valor_comision = round($request->pag_valor_comision,2);
        $ObjectUpdate->pag_valor_total = round($request->pag_valor_total,2);
        $ObjectUpdate->pag_valor_fob = round($request->pag_valor_fob,2);
        $ObjectUpdate->trm_liquidacion_factura = round($request->trm_liquidacion_factura,2);
        $ObjectUpdate->pag_fecha_factura = Carbon::parse($request->pag_fecha_factura)->format('Y-m-d');
        $ObjectUpdate->pag_fecha_envio_contabilidad = Carbon::parse($request->pag_fecha_envio_contabilidad)->format('Y-m-d');
        $ObjectUpdate->pag_numero_factura = strtoupper($request->pag_numero_factura);
        $ObjectUpdate->pag_fecha_anticipo = Carbon::parse($request->pag_fecha_anticipo)->format('Y-m-d');
        $ObjectUpdate->pag_fecha_saldo = Carbon::parse($request->pag_fecha_saldo)->format('Y-m-d');
        $ObjectUpdate->save();

         //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El proceso de pago fue editado exitosamente!');
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
