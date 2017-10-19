<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;

use App\Models\Importacionesv2\TTipoImportacion;
use App\Models\Importacionesv2\TTipoNacionalizacion;
use App\Models\Importacionesv2\TNacionalizacionImportacion;
use App\Models\Importacionesv2\TImportacion;
use App\Models\Importacionesv2\TTipoLevante;
use App\Models\Importacionesv2\TDeclaracion;
use App\Models\Importacionesv2\TAdministracionDian;
use App\Models\Importacionesv2\TProductoImportacion;
use \Cache;
use Validator;
use Carbon\Carbon;
use Session;
use Redirect;
use DB;
use Illuminate\Http\Request;
use Auth;
use App\Models\Importacionesv2\TPermisosImp;


/**
 * @resource TNacionalizacionImportacionController
 *
 * Controlador creado para el proceso de nacionalizacion y costeo
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TNacionalizacionImportacionController extends Controller
{
  //REGLAS DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $rules = array('naco_importacion'=>'required',
    'naco_tipo_importacion'=>'required', 
    'naco_tipo_nacionalizacion'=>'required',
    'naco_fecha_entrega_docu_transp'=>'required',
    'naco_fecha_retiro_puert'=>'required');

  //MENSAJES DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $messages = array('naco_importacion.required'=>'El proceso de nacionalizacion y costeo debe estar asociado a una importacion',
    'naco_tipo_importacion.required'=>'Favor ingresar el tipo de importacion', 
    'naco_tipo_nacionalizacion.required'=>'Favor ingresar el tipo de nacionalizacion',
    'naco_fecha_entrega_docu_transp.required'=>'Favor ingresar la fecha de entrega documentos al transportador',
    'naco_fecha_retiro_puert.required'=>'Favor ingresar la fecha de retiro del puerto');


  

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
     * retorna una vista con el formulario de creacion de la nacionalizacion y costeo
     * 
     * debe validar que no existan alertas en la tabla t_producto_importacion
     * 
     * debe consultar el id de la importacion y enviarlo al formulario de creacion
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
      $idImportacion=$id;
      $importacion = TImportacion::find($idImportacion);

      $productos = TProductoImportacion::where(array(array('pdim_importacion','=', "$idImportacion"), array('pdim_alerta','=','1')))->get();

      if(count($productos) > 0){
        $urlAlertasImportacion = route('consultaAlertas');
        return Redirect::to($urlAlertasImportacion)
        ->withErrors('El proceso de importacion tiene alertas sin cerrar');            
      }

        #Contiene el titulo de formulario
      $titulo = "CREAR NACIONALIZACION Y COSTEO DE IMPORTACION - ". $importacion->imp_consecutivo;
        #String que hace referencia al URI del route que se le pasa al formulario y genere la url de post
      $url = "importacionesv2/NacionalizacionCosteo";
        #crea los array de las consultas para mostrar en los combobox en el formulario
      $consulta = array(1,2,3,4);
      $combos = $this->consultas($consulta);
      extract($combos);
        #Envia la informacion a la vista
      return view('importacionesv2.NacionalizacionCosteoTemplate.createNacionalizacionCosteo', 
        compact('titulo',
          'url',
          'idImportacion',
          'naco_tipo_importacion',
          'naco_tipo_nacionalizacion',
          'decl_tipo_levante',
          'decl_admin_dian'));

    }

    /**
     * store
     * 
     * Esta vista recibe el request proveniente del formulario de creacion de la tabla t_nacionalizacion y costeo
     * 
     * debe validar todas las reglas definidas como variable global
     * 
     * debe comprobar que no exista una nacionalizacion asociada a la misma importacion
     * 
     * debe validar que venga al menos una declaracion de importacion asociada
     * 
     * debe crear un registro en la tabla de nacionalizacion y costeo
     * 
     * debe cambiar el estado de la orden de importacion
     * 
     * debe crear declaraciones de importacion asociadas a la nacionalizacion y costeo
     * 
     * debe retornar mensaje existoso y redireccionar a la vista de consulta importacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
      $urlConsulta = route('consultaFiltros'); 
      $url = url("importacionesv2/NacionalizacionCosteo/create");

      $validator = Validator::make($request->all(), $this->rules, $this->messages);
      if ($validator->fails()) {
        return redirect()->action(
          'Importacionesv2\TNacionalizacionImportacionController@create', ['id' => $request->naco_importacion]
          )->withErrors($validator)->withInput();
      }

        //Valida la existencia del registro que se intenta crear en la tabla de la bd 
      $validarExistencia = TNacionalizacionImportacion::where('naco_importacion', '=', "$request->naco_importacion")->get();
      if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
        return redirect()->action(
          'Importacionesv2\TNacionalizacionImportacionController@create', ['id' => $request->naco_importacion]
          )->withErrors('El proceso de nacionalizacion y costeo que intenta crear ya existe en la base de datos')->withInput();            
      }
      if($request->tabladeclaracionguardar == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
        return redirect()->action(
          'Importacionesv2\TNacionalizacionImportacionController@create', ['id' => $request->naco_importacion]
          )->withErrors('Debe ingresar al menos una declaración de importación')->withInput();  
      }
      DB::beginTransaction();
         //Crea el registro en la tabla importacion
      $ObjectCrear = new TNacionalizacionImportacion;
      $ObjectCrear->naco_importacion = $request->naco_importacion;
      $ObjectCrear->naco_tipo_importacion = $request->naco_tipo_importacion;
      $ObjectCrear->naco_numero_comex = intval($request->naco_numero_comex);

      if($request->naco_anticipo_aduana != ""){
       $ObjectCrear->naco_anticipo_aduana = round($request->naco_anticipo_aduana,2);
     }

     if ($request->naco_fecha_anticipo_aduana == "") {
      $ObjectCrear->naco_fecha_anticipo_aduana = null;
    } else {
      $ObjectCrear->naco_fecha_anticipo_aduana =  Carbon::parse($request->naco_fecha_anticipo_aduana)->format('Y-m-d');
    }



    if ($request->naco_preinscripcion) {
      $ObjectCrear->naco_preinscripcion = $request->naco_preinscripcion;
    } else {
      $ObjectCrear->naco_preinscripcion = 0;
    }
    if ($request->naco_control_posterior) {
     $ObjectCrear->naco_control_posterior = $request->naco_control_posterior;
   } else {
    $ObjectCrear->naco_control_posterior = 0;
  }      
  $ObjectCrear->naco_tipo_nacionalizacion = $request->naco_tipo_nacionalizacion;
  $ObjectCrear->naco_fecha_entrega_docu_transp = Carbon::parse($request->naco_fecha_entrega_docu_transp)->format('Y-m-d');
  $ObjectCrear->naco_fecha_retiro_puert = Carbon::parse($request->naco_fecha_retiro_puert)->format('Y-m-d');
  if ($request->naco_fecha_envio_comex != "") {
    $ObjectCrear->naco_fecha_envio_comex = Carbon::parse($request->naco_fecha_envio_comex)->format('Y-m-d');
  }elseif($request->naco_fecha_envio_comex == ""){
    $ObjectCrear->naco_fecha_envio_comex = null;
  }

  if ($request->naco_fecha_llegada_be != "") {
   $ObjectCrear->naco_fecha_llegada_be = Carbon::parse($request->naco_fecha_llegada_be)->format('Y-m-d');
 }elseif($request->naco_fecha_llegada_be == ""){
  $ObjectCrear->naco_fecha_llegada_be = null;
}


if ($request->naco_fecha_recep_list_empaq != "") {
  $ObjectCrear->naco_fecha_recep_list_empaq = Carbon::parse($request->naco_fecha_recep_list_empaq)->format('Y-m-d');
}elseif($request->naco_fecha_recep_list_empaq == ""){
  $ObjectCrear->naco_fecha_recep_list_empaq = null;
}

if ($request->naco_fecha_envi_liqu_costeo != "") {
  $ObjectCrear->naco_fecha_envi_liqu_costeo = Carbon::parse($request->naco_fecha_envi_liqu_costeo)->format('Y-m-d');
}elseif($request->naco_fecha_envi_liqu_costeo == ""){
  $ObjectCrear->naco_fecha_envi_liqu_costeo = null;
}

if ($request->naco_fecha_entrada_sistema != "") {
  $ObjectCrear->naco_fecha_entrada_sistema = Carbon::parse($request->naco_fecha_entrada_sistema)->format('Y-m-d');
}elseif($request->naco_fecha_entrada_sistema == ""){
  $ObjectCrear->naco_fecha_entrada_sistema = null;
}

if ($request->naco_ajuste && $request->naco_opcion && $request->naco_valorseleccion){
  if ($request->naco_opcion == "sobrante") {
    $ObjectCrear->naco_sobrante = $request->naco_valorseleccion;
  } elseif($request->naco_opcion == "faltante") {
    $ObjectCrear->naco_faltante = $request->naco_valorseleccion;
  }

}

if ($request->naco_ajuste && $request->naco_opcion && $request->naco_valorseleccion_euro){
  if ($request->naco_opcion == "sobrante") {
    $ObjectCrear->naco_sobrante_euro = $request->naco_valorseleccion_euro;
  } elseif($request->naco_opcion == "faltante") {
    $ObjectCrear->naco_faltante_euro = $request->naco_valorseleccion_euro;
  }

}
if ($request->naco_factor_dolar_tasa != "") {
 $ObjectCrear->naco_factor_dolar_tasa =  round($request->naco_factor_dolar_tasa,2);
}elseif($request->naco_factor_dolar_tasa == ""){
  $ObjectCrear->naco_factor_dolar_tasa = null;
}


if ($request->naco_factor_dolar_porc != "") {
  $ObjectCrear->naco_factor_dolar_porc = round($request->naco_factor_dolar_porc,2);
}elseif($request->naco_factor_dolar_porc == ""){
  $ObjectCrear->naco_factor_dolar_porc = null;
}

if ($request->naco_factor_logist_tasa != "") {
  $ObjectCrear->naco_factor_logist_tasa =  round($request->naco_factor_logist_tasa,2);
}elseif($request->naco_factor_logist_tasa == ""){
  $ObjectCrear->naco_factor_logist_tasa = null;
}

if ($request->naco_factor_logist_porc != "") {
  $ObjectCrear->naco_factor_logist_porc =  round($request->naco_factor_logist_porc,2);
}elseif($request->naco_factor_logist_porc == ""){
  $ObjectCrear->naco_factor_logist_porc = null;
}

if ($request->naco_factor_arancel_porc != "") {
  $ObjectCrear->naco_factor_arancel_porc =  round($request->naco_factor_arancel_porc,2);
}elseif($request->naco_factor_arancel_porc == ""){
  $ObjectCrear->naco_factor_arancel_porc = null;
}    


$ObjectCrear->save();

        //Manejo de estados
if ($ObjectCrear->id) {
  $objImportacion = TImportacion::find($request->naco_importacion);

  if ($request->naco_fecha_retiro_puert && $objImportacion->imp_estado_proceso != 4 && $objImportacion->imp_estado_proceso != 5 && $objImportacion->imp_estado_proceso != 6) {
    $objImportacion->imp_estado_proceso = 3;
  }

  if ($request->naco_fecha_llegada_be && $request->naco_fecha_retiro_puert && $objImportacion->imp_estado_proceso != 6 && $objImportacion->imp_estado_proceso != 5 ) {
    $objImportacion->imp_estado_proceso = 4;
  }
  if ($request->naco_fecha_envio_comex && $request->naco_fecha_retiro_puert && $request->naco_fecha_llegada_be && $request->naco_fecha_recep_list_empaq && $request->naco_fecha_envi_liqu_costeo && $request->naco_fecha_entrada_sistema && $request->naco_factor_dolar_tasa && $request->naco_factor_dolar_porc && $request->naco_factor_logist_tasa && $request->naco_factor_logist_porc && $request->naco_factor_arancel_porc && $objImportacion->imp_estado_proceso != 6 ) {
    $objImportacion->imp_estado_proceso = 5;
  }

  $objImportacion->save();

  $cantidad = intval($request->tabladeclaracionguardar);
  for ($i=1; $i < $cantidad+1 ; $i++) { 

    $decl_numero = $i."-decl_numero";        
    $decl_sticker = $i."-decl_sticker";
    $decl_arancel = $i."-decl_arancel";
    $decl_iva = $i."-decl_iva";
    $decl_valor_otros = $i."-decl_valor_otros";
    $decl_trm = $i."-decl_trm";
    $decl_tipo_levante = $i."-decl_tipo_levante";        
    $decl_admin_dian = $i."-decl_admin_dian";
    $decl_fecha_aceptacion = $i."-decl_fecha_aceptacion";
    $decl_fecha_levante = $i."-decl_fecha_levante";
    $decl_fecha_legaliza_giro = $i."-decl_fecha_legaliza_giro";
    if($request->$decl_numero != "")
    {
      $objDeclaracion = new TDeclaracion;
      $objDeclaracion->decl_nacionalizacion = $ObjectCrear->id;
      $objDeclaracion->decl_numero = $request->$decl_numero;
      $objDeclaracion->decl_sticker = $request->$decl_sticker;
      $objDeclaracion->decl_arancel = round($request->$decl_arancel,2);
      $objDeclaracion->decl_iva = intval($request->$decl_iva);
      $objDeclaracion->decl_valor_otros = round($request->$decl_valor_otros,2);
      $objDeclaracion->decl_trm =round($request->$decl_trm,2);
      $objDeclaracion->decl_tipo_levante =intval($request->$decl_tipo_levante);
      $objDeclaracion->decl_admin_dian = intval($request->$decl_admin_dian);
      $objDeclaracion->decl_fecha_aceptacion = Carbon::parse($request->$decl_fecha_aceptacion)->format('Y-m-d');
      $objDeclaracion->decl_fecha_levante =  Carbon::parse($request->$decl_fecha_levante)->format('Y-m-d');

      if($request->$decl_fecha_legaliza_giro !== ""){        
        $objDeclaracion->decl_fecha_legaliza_giro = Carbon::parse($request->$decl_fecha_legaliza_giro)->format('Y-m-d');
      }elseif($request->$decl_fecha_legaliza_giro === ""){
        $objDeclaracion->decl_fecha_legaliza_giro = null;
      }
      
      $objDeclaracion->save();
      if(!$objDeclaracion->id){                    
        DB::rollBack();
        App::abort(500, 'La declaracion de importacion no fue creada[error 280]');
      }else{                
        DB::commit();
      }

    }   
  }
}else{
  DB::rollBack();
  App::abort(500, "La creacion de la nacionalizacion y costeo genero algun problema, favor validar con el administrador del sistema");
}

Session::flash('message', 'El proceso de nacionalizacion y costeo fue creado exitosamente!');
return Redirect::to($urlConsulta);

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
     * Esta funcion recibe el id de la nacionalizacion y costeo que desea editar
     * 
     * Debe retornar una vista con todas que permita editar un registro de la tabla nacionalizacion y costeo y multiples registros de la tabla tdeclaracion 
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         //Id del registro que deseamos editar
      $id = $id;
        //Consulto el registro que deseo editar
      $objeto = TNacionalizacionImportacion::with('importacion')->find($id);
        //Titulo de la pagina
      $titulo = "EDITAR PROCESO DE NACIONALIZACIÓN Y COSTEO - ". $objeto->importacion->imp_consecutivo;
        //url de redireccion para consultar
      $url = route('Importacion.store');
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
      $route = 'NacionalizacionCosteo.update';
        #Obtiene los productos asociados a la orden de importacion
      $objeto2 = TDeclaracion::with('levanteDeclaracion')->with('admindianDeclaracion')->where('decl_nacionalizacion','=',"$id")->get();
        #Crea un array con la informacion necesaria para mostrar en una tabla los productos asociados a la orden de importacion
      $cantidadDeclaraciones = count($objeto2);
         #Crea los array de las consultas para mostrar en los Combobox
      $consulta = array(1,2,3,4);
      $combos = $this->consultas($consulta);
      extract($combos);
      $ajuste = false;
      $sobrante = false;
      $faltante = false;
      $naco_valorseleccion = "";
      $naco_valorseleccion_euro ="";
      if ($objeto->naco_sobrante || $objeto->naco_faltante){
        $ajuste = true;
      }
      if($objeto->naco_sobrante){
        $sobrante = true;
        $naco_valorseleccion = $objeto->naco_sobrante;
      }
      if ($objeto->naco_faltante) {
        $faltante = true;
        $naco_valorseleccion = $objeto->naco_sobrante;
      }

      if($objeto->naco_sobrante_euro){
        $sobrante = true;
        $naco_valorseleccion_euro = $objeto->naco_sobrante_euro;
      }
      if ($objeto->naco_faltante_euro) {
        $faltante = true;
        $naco_valorseleccion_euro = $objeto->naco_sobrante_euro;
      }
      $hasPerm = $this->permisos();  

      $ordenimportacion = TImportacion::where('id', '=', "$objeto->naco_importacion")->first();
      // if($ordenimportacion->imp_estado_proceso == 6 || $ordenimportacion->imp_estado_proceso == 5 ||$ordenimportacion->imp_estado_proceso == 7){
      //   $hasPerm = 0;
      // }
        #Retorna la informacion a la vista editar       
      return view('importacionesv2.NacionalizacionCosteoTemplate.editNacionalizacionCosteo', 
        compact('url',
         'titulo', 
         'route', 
         'id',
         'objeto',
         'objeto2',
         'cantidadDeclaraciones',
         'naco_tipo_importacion',
         'naco_tipo_nacionalizacion',
         'decl_tipo_levante',
         'ajuste',
         'sobrante',
         'faltante',
         'naco_valorseleccion',
         'naco_valorseleccion_euro',
         'decl_admin_dian',
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
     * update
     * 
     * Esta funcion recibe el id de la nacionalizacion y costeo que desea editar y el request donde viene toda la informacion de la nacionalizacion y las declaraciones de importacion
     * 
     * Debe actualizar el registro de la tabla nacionalizacion y costeo
     * 
     * Debe validar que exista almentos una declaracion asociada a la orden de importacion
     * 
     * Debe actualizar las declaraciones de importacion
     * 
     * Debe redireccionar a la vista de consulta 
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

      $validator = Validator::make($request->all(), $this->rules, $this->messages);
      if ($validator->fails()) {
        return redirect()->action(
          'Importacionesv2\TNacionalizacionImportacionController@create', ['id' => $request->naco_importacion]
          )->withErrors($validator)->withInput();
      }

      if($request->tabladeclaracionguardar == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
        return redirect()->action(
          'Importacionesv2\TNacionalizacionImportacionController@create', ['id' => $request->naco_importacion]
          )->withErrors('Debe ingresar al menos una declaración de importación')->withInput();  
      }

      $ObjectEditar = TNacionalizacionImportacion::find($id);
      $ObjectEditar->naco_importacion = $request->naco_importacion;
      $ObjectEditar->naco_tipo_importacion = $request->naco_tipo_importacion;

      if($request->naco_anticipo_aduana != ""){
       $ObjectEditar->naco_anticipo_aduana = round($request->naco_anticipo_aduana,2);
        }else{
          $ObjectEditar->naco_anticipo_aduana = null;
        }

     if ($request->naco_fecha_anticipo_aduana == "") {
      $ObjectEditar->naco_fecha_anticipo_aduana = null;
    } else {
      $ObjectEditar->naco_fecha_anticipo_aduana =  Carbon::parse($request->naco_fecha_anticipo_aduana)->format('Y-m-d');
    }
    if ($request->naco_preinscripcion) {
      $ObjectEditar->naco_preinscripcion = $request->naco_preinscripcion;
    } else {
      $ObjectEditar->naco_preinscripcion = 0;
    }
    if ($request->naco_control_posterior) {
     $ObjectEditar->naco_control_posterior = $request->naco_control_posterior;
   } else {
    $ObjectEditar->naco_control_posterior = 0;
  }      
  $ObjectEditar->naco_tipo_nacionalizacion = $request->naco_tipo_nacionalizacion;
  $ObjectEditar->naco_numero_comex = intval($request->naco_numero_comex);
  $ObjectEditar->naco_fecha_entrega_docu_transp = Carbon::parse($request->naco_fecha_entrega_docu_transp)->format('Y-m-d');
  $ObjectEditar->naco_fecha_retiro_puert = Carbon::parse($request->naco_fecha_retiro_puert)->format('Y-m-d');
  if ($request->naco_fecha_envio_comex != "") {
    $ObjectEditar->naco_fecha_envio_comex = Carbon::parse($request->naco_fecha_envio_comex)->format('Y-m-d');
  }elseif($request->naco_fecha_envio_comex == ""){
    $ObjectEditar->naco_fecha_envio_comex = null;
  }
  if ($request->naco_fecha_llegada_be != "") {
   $ObjectEditar->naco_fecha_llegada_be = Carbon::parse($request->naco_fecha_llegada_be)->format('Y-m-d');
 }elseif($request->naco_fecha_llegada_be == ""){
  $ObjectEditar->naco_fecha_llegada_be = null;
}


if ($request->naco_fecha_recep_list_empaq != "") {
  $ObjectEditar->naco_fecha_recep_list_empaq = Carbon::parse($request->naco_fecha_recep_list_empaq)->format('Y-m-d');
}elseif($request->naco_fecha_recep_list_empaq == ""){
  $ObjectEditar->naco_fecha_recep_list_empaq = null;
}

if ($request->naco_fecha_envi_liqu_costeo != "") {
  $ObjectEditar->naco_fecha_envi_liqu_costeo = Carbon::parse($request->naco_fecha_envi_liqu_costeo)->format('Y-m-d');
}elseif($request->naco_fecha_envi_liqu_costeo == ""){
  $ObjectEditar->naco_fecha_envi_liqu_costeo = null;
}

if ($request->naco_fecha_entrada_sistema != "") {
  $ObjectEditar->naco_fecha_entrada_sistema = Carbon::parse($request->naco_fecha_entrada_sistema)->format('Y-m-d');
}elseif($request->naco_fecha_entrada_sistema == ""){
  $ObjectEditar->naco_fecha_entrada_sistema = null;
}
$ObjectEditar->naco_sobrante = null;
$ObjectEditar->naco_faltante = null;
$ObjectEditar->naco_sobrante_euro = null;
$ObjectEditar->naco_faltante_euro = null;
if ($request->naco_ajuste && $request->naco_opcion && $request->naco_valorseleccion){
  if ($request->naco_opcion == "sobrante") {
    $ObjectEditar->naco_sobrante = $request->naco_valorseleccion;
  } elseif($request->naco_opcion == "faltante") {
    $ObjectEditar->naco_faltante = $request->naco_valorseleccion;
  }

}
if ($request->naco_ajuste && $request->naco_opcion && $request->naco_valorseleccion_euro){
  if ($request->naco_opcion == "sobrante") {
    $ObjectEditar->naco_sobrante_euro = $request->naco_valorseleccion_euro;
  } elseif($request->naco_opcion == "faltante") {
    $ObjectEditar->naco_faltante_euro = $request->naco_valorseleccion_euro;
  }

}
if ($request->naco_factor_dolar_tasa != "") {
 $ObjectEditar->naco_factor_dolar_tasa =  round($request->naco_factor_dolar_tasa,2);
}elseif($request->naco_factor_dolar_tasa == ""){
  $ObjectCrear->naco_factor_dolar_tasa = null;
}

if ($request->naco_factor_dolar_porc != "") {
  $ObjectEditar->naco_factor_dolar_porc = round($request->naco_factor_dolar_porc,2);
}elseif($request->naco_factor_dolar_porc == ""){
  $ObjectCrear->naco_factor_dolar_porc = null;
}


if ($request->naco_factor_logist_tasa != "") {
  $ObjectEditar->naco_factor_logist_tasa =  round($request->naco_factor_logist_tasa,2);
}elseif($request->naco_factor_logist_tasa == ""){
  $ObjectCrear->naco_factor_logist_tasa = null;
}

if ($request->naco_factor_logist_porc != "") {
  $ObjectEditar->naco_factor_logist_porc =  round($request->naco_factor_logist_porc,2);
}elseif($request->naco_factor_logist_porc == ""){
  $ObjectCrear->naco_factor_logist_porc = null;
}

if ($request->naco_factor_arancel_porc != "") {
  $ObjectEditar->naco_factor_arancel_porc =  round($request->naco_factor_arancel_porc,2);
}elseif($request->naco_factor_arancel_porc == ""){
  $ObjectEditar->naco_factor_arancel_porc = null;
} 

$ObjectEditar->save();



$contenedoresBorrar = TDeclaracion::where('decl_nacionalizacion','=', "$ObjectEditar->id")->delete();


$objImportacion = TImportacion::find($request->naco_importacion);

if ($request->naco_fecha_retiro_puert && $objImportacion->imp_estado_proceso != 4 && $objImportacion->imp_estado_proceso != 5 && $objImportacion->imp_estado_proceso != 6) {
  $objImportacion->imp_estado_proceso = 3;
}

if ($request->naco_fecha_llegada_be && $request->naco_fecha_retiro_puert && $objImportacion->imp_estado_proceso != 6 && $objImportacion->imp_estado_proceso != 5 ) {
  $objImportacion->imp_estado_proceso = 4;
}
if ($request->naco_fecha_envio_comex && $request->naco_fecha_retiro_puert && $request->naco_fecha_llegada_be && $request->naco_fecha_recep_list_empaq && $request->naco_fecha_envi_liqu_costeo && $request->naco_fecha_entrada_sistema && $request->naco_factor_dolar_tasa && $request->naco_factor_dolar_porc && $request->naco_factor_logist_tasa && $request->naco_factor_logist_porc && $request->naco_factor_arancel_porc && $objImportacion->imp_estado_proceso != 6 ) {
  $objImportacion->imp_estado_proceso = 5;
}

$objImportacion->save();

$cantidad = intval($request->tabladeclaracionguardar);
for ($i=1; $i < $cantidad+1 ; $i++) { 

  $decl_numero = $i."-decl_numero";        
  $decl_sticker = $i."-decl_sticker";
  $decl_arancel = $i."-decl_arancel";
  $decl_iva = $i."-decl_iva";
  $decl_valor_otros = $i."-decl_valor_otros";
  $decl_trm = $i."-decl_trm";
  $decl_tipo_levante = $i."-decl_tipo_levante";        
  $decl_admin_dian = $i."-decl_admin_dian";
  $decl_fecha_aceptacion = $i."-decl_fecha_aceptacion";
  $decl_fecha_levante = $i."-decl_fecha_levante";
  $decl_fecha_legaliza_giro = $i."-decl_fecha_legaliza_giro";
  if($request->$decl_numero != "")
  {
    $objDeclaracion = new TDeclaracion;
    $objDeclaracion->decl_nacionalizacion = $ObjectEditar->id;
    $objDeclaracion->decl_numero = $request->$decl_numero;
    $objDeclaracion->decl_sticker = $request->$decl_sticker;
    $objDeclaracion->decl_arancel = round($request->$decl_arancel,2);
    $objDeclaracion->decl_iva = intval($request->$decl_iva);
    $objDeclaracion->decl_valor_otros = round($request->$decl_valor_otros,2);
    $objDeclaracion->decl_trm =round($request->$decl_trm,2);
    $objDeclaracion->decl_tipo_levante =intval($request->$decl_tipo_levante);
    $objDeclaracion->decl_admin_dian = intval($request->$decl_admin_dian);
    $objDeclaracion->decl_fecha_aceptacion = Carbon::parse($request->$decl_fecha_aceptacion)->format('Y-m-d');
    $objDeclaracion->decl_fecha_levante =  Carbon::parse($request->$decl_fecha_levante)->format('Y-m-d');

    if($request->$decl_fecha_legaliza_giro !== ""){
      $objDeclaracion->decl_fecha_legaliza_giro = Carbon::parse($request->$decl_fecha_legaliza_giro)->format('Y-m-d');
    }elseif($request->$decl_fecha_legaliza_giro === ""){        
      $objDeclaracion->decl_fecha_legaliza_giro = null;
    }
    $objDeclaracion->save();
    if(!$objDeclaracion->id){                    
      DB::rollBack();
      App::abort(500, 'La declaracion de importacion no fue creada[error 280]');
    }else{                
      DB::commit();
    }

  }   
}
         //Redirecciona a la pagina de consulta y muestra mensaje
Session::flash('message', 'El proceso de nacionalizacion y costeo fue editado exitosamente!');
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



 /**
  * 
  * consultas
  * 
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
  if(in_array(2, $consulta)){
    $array = TTipoNacionalizacion::all();
    $naco_tipo_nacionalizacion = array();
    foreach ($array as $key => $value) {$naco_tipo_nacionalizacion["$value->id"] = $value->tnac_descripcion;}
    $combos['naco_tipo_nacionalizacion'] = $naco_tipo_nacionalizacion;
  }

    // Combobox TIPO NACIONALIZACION
  if(in_array(3, $consulta)){
    $array = TTipoLevante::all();
    $decl_tipo_levante = array();
    foreach ($array as $key => $value) {$decl_tipo_levante["$value->id"] = $value->tlev_nombre;}
    $combos['decl_tipo_levante'] = $decl_tipo_levante;
  }

    // Combobox TIPO NACIONALIZACION
  if(in_array(4, $consulta)){
    $array = TAdministracionDian::all();
    $decl_admin_dian = array();
    foreach ($array as $key => $value) {$decl_admin_dian["$value->id"] = $value->descripcion;}
    $combos['decl_admin_dian'] = $decl_admin_dian;
  }


  return $combos;
}

}