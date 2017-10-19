<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JsValidator;
use Validator;
use Input;
use DB;
use Response;
use \Cache;
use Auth;
use Session;
use Redirect;
use App\Models\Importacionesv2\TPuertoEmbarque;
use App\Models\Importacionesv2\TIconterm;
use App\Models\Importacionesv2\TImportacion;
use App\Models\Importacionesv2\TEstado;
use App\Models\Importacionesv2\TProducto;
use App\Models\Importacionesv2\TProductoImportacion;
use App\Models\Importacionesv2\TOrigenMercancia;
use App\Models\Importacionesv2\TOrigenMercanciaImportacion;
use App\Models\Importacionesv2\TProforma;
use App\Models\Importacionesv2\TEmbarqueImportacion;
use App\Models\Importacionesv2\TPagoImportacion;
use App\Models\Importacionesv2\TNacionalizacionImportacion;
use Carbon\Carbon;
use App\Models\Importacionesv2\TPermisosImp;


/**
 * @resource TImportacionController
 *
 * Controlador creado para el proceso de importacion
 *
 * Creado por Carlos Belalcazar
 *
 * Analista desarrollador de software Belleza Express
 *
 * 21/04/2017
 */
class TImportacionController extends Controller
{

   //REGLAS DE VALIDACION DEL FORMULARIO SON USADAS POR JSVALIDATOR PARA MOSTRAR LOS MENSAJES POR AJAX
  public $rules = array(
    'imp_consecutivo'       => 'required',
    'imp_proveedor'       => 'required',
    'imp_puerto_embarque'      => 'required',
    'imp_iconterm'      => 'required',
    'imp_moneda_negociacion'     => 'required',
    'origenMercancia'  => 'required|array|min:1',
    );

  //MENSAJES DE LAS REGLAS DE VALIDACION DEL FORMULARIO JSVALIDATOR PARA MOSTRAR LOS MENSAJES POR AJAX
  public $messages = array(
    'imp_consecutivo.required'       => 'Favor ingresar el consecutivo de importación',
    'imp_proveedor.required'       => 'Favor ingresar el proveedor',
    'imp_puerto_embarque.required'      => 'Favor seleccionar el puerto de embarque',
    'imp_iconterm.required'      => 'Favor seleccionar el inconterm',
    'imp_moneda_negociacion.required'     => 'Favor seleccionar una moneda de negociación',
    'origenMercancia.required'  => 'Favor ingresar el origen de la mercancia',
    );
  //Name de la url de consulta la uso para no redundar este string en mis funciones
  public $strUrlConsulta = 'importacionesv2/Importacion';


/**
* __construct
 *
 * @return \Illuminate\Http\Response
 */
  public function __construct()
  {
    $this->middleware('ImpMid')->only(['cerrarOrden']);
  }
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
    * Muestra el formulario para la creaacion de un nuevo proceso de importacion
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request)
    {
        #Contiene el titulo de formulario
        $titulo = "CREAR IMPORTACIÓN";
        #Libreria de validaciones con ajax genera el codigo javascript sobre el formulario que muestra las validaciones sobre los campos
        $validator = JsValidator::make($this->rules, $this->messages);
        #Genera url de consulta usando el name de la url
        $url = url($this->strUrlConsulta);
        #crea los array de las consultas para mostrar en los combobox en el formulario

        $consulta = array(1,2,5,3);
        $combos = $this->consultas($consulta);
        extract($combos);
        #Consigue el usuario de session y fecha actual
        $usuario = Auth::user();
        $date = Carbon::now();
        $year = $date->format('Y');
        #consigue el ultimo id de la tabla y genera un consecutivo de creacion para sugerencia al usuario en el formulario de creacion

        $id2 = TImportacion::max('id');
        if($id2 == null){
            $consecutivo = 1;
        }elseif($id2 != null){
            $importacion1 = TImportacion::find($id2);
            $numero = explode("/",$importacion1->imp_consecutivo);
            $consecutivo = intval($numero[0])+1;

        }
        $imp_consecutivo = "$consecutivo/" .$year;
        //retorna la informacion a la vista create
        return view('importacionesv2.importacionTemplate.createImportacion',
            compact('titulo',
                'url',
                'validator',
                'puertos',
                'inconterm',
                'imp_consecutivo',
                'origenMercancia'));
    }

    /**
    * store
    *
    * Esta funcion debe crear un nuevo proceso de importacion en la tabla t_importacion y a ella asocia productos y origenes de la mercancia
    *
    * Debe validar que no exista alguna importacion con el mismo consecutivo de importacion.
    *
    * debe validar la obligatoriedad de los campos
    *
    * Debe validar que no venga almenos un producto
    *
    * Debe validar que venga almenos una proforma asociada
    *
    * Debe redireccionar a la pagina de consulta
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        #Genera url de consulta usando el name de la url
        $url = url("importacionesv2/Importacion/create");
        $urlConsulta = route('consultaFiltros');
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TImportacion::where('imp_consecutivo', '=', "$request->imp_consecutivo")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('La importacion que intenta crear tiene el mismo consecutivo que un registro ya existente')->withInput();
        }

        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return redirect($url)
            ->withErrors($validator)
            ->withInput();
        }

        if($request->tablaGuardar == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('Debe ingresar almenos un producto')->withInput();
        }
        if($request->tablaproformaguardar == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('Debe ingresar almenos una proforma')->withInput();
        }

         #Crea todas las proformas asociadas en la tabla
        $cantidadProformas = intval($request->tablaproformaguardar);
        for ($i=1; $i < $cantidadProformas+1 ; $i++) {
            $valorprof = $i."-valorprof";
            if(strlen(round($request->$valorprof,0)) > 10){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
                return Redirect::to("importacionesv2/Importacion/create")
                ->withErrors('El valor de la proforma no puede tener mas de 10 numeros')->withInput();
            }

        }
        DB::beginTransaction();
        //Crea el registro en la tabla importacion
        $objeto = new TImportacion;
        $ObjectCrear = $this->objectoImportacion($objeto, $request);
        $ObjectCrear->imp_estado_proceso = 1;
        $ObjectCrear->save();
       #Si la creacion de la importacion genera error lo retorna
       if(!$ObjectCrear->id){
        DB::rollBack();
        App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema [error 201]');
    }else{
        #En caso de no existir error
        #crea todos los productos realcionados en la tabla
        $cantidad = intval($request->tablaGuardar);
        $banderaProducto = true;
        for ($i=1; $i < $cantidad+1; $i++) {

            if($request->$i != ""){
                $alerta = 0;
                $strvariable = $i."variable";
                $strvariable = new TProductoImportacion;

                $date = Carbon::now();
                $date = $date->format('Y-m-d');
                $ref = $request->$i;
                $producto = TProducto::where('prod_referencia','LIKE', "%$ref%")
                ->first();
                $strvariable->pdim_producto = $producto->id;
                $strvariable->pdim_importacion = $ObjectCrear->id;
                if($producto->prod_req_declaracion_anticipado == 1){
                    $strvariable->pdim_fech_req_declaracion_anticipado = $date;
                    $alerta = 1;
                }
                if($producto->prod_req_registro_importacion == 1){
                    $strvariable->pdim_fech_requ_registro_importacion = $date;
                    $alerta = 1;
                }
                $strvariable->pdim_alerta =$alerta;
                $strvariable->save();

                if(!$strvariable->id){
                    DB::rollBack();
                    App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema [error 202]');
                }


            }

        }
        #Crea todos los origenes de la mercancia asociados en la tabla
        $cantidadOrigenes = count($request->origenMercancia);
        for ($i=0; $i < $cantidadOrigenes ; $i++) {
         $strorimerc = $i."variable";
         $strorimerc = new TOrigenMercanciaImportacion;
         $strorimerc->omeim_origen_mercancia = $request->origenMercancia[$i];
         $strorimerc->omeim_importacion = $ObjectCrear->id;
         $strorimerc->save();
         if(!$strorimerc->id){
            DB::rollBack();
            App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema [error 203]');
        }
    }


    for ($i=1; $i < $cantidadProformas+1 ; $i++) {

        $strproforma = $i."objproforma";
        $noprof = $i."-noprof";
        $creaprof = $i."-creaprof";
        $entregaprof = $i."-entregaprof";
        $valorprof = $i."-valorprof";
        $princprof = $i."-princprof";
        if($request->$noprof != "")
        {
            $strproforma = new TProforma;
            $strproforma->prof_importacion = $ObjectCrear->id;
            $strproforma->prof_numero = $request->$noprof;
            $date1 = Carbon::parse($request->$creaprof)->format('Y-m-d');
            $strproforma->prof_fecha_creacion = $date1;
            $date2 = Carbon::parse($request->$entregaprof)->format('Y-m-d');
            $strproforma->prof_fecha_entrega = $date2;
            $strproforma->prof_valor_proforma = round($request->$valorprof,2);
            $strproforma->prof_principal = intval($request->$princprof);
            $strproforma->save();
            if(!$strproforma->id){
                DB::rollBack();
                App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema [error 204]');
            }

        }
    }
}


DB::commit();

     #Borra la cache de consulta
Cache::forget('importacion');
        //Redirecciona a la pagina de creacion y muestra mensaje
Session::flash('message', 'El proceso de importación fue creado exitosamente!');
return Redirect::to($urlConsulta);


}

    /**
    * show
    *
    * Esta funcion debe mostrar la informacion de una importacion relacionada con proveedores, puertos de embarque, origenes de la mercancia, embaqeu de importacion, pagos de importacion, productos, proformas, embarque, pagos, nacionalizacion y costeo
    * Debere retornar una vista que tenga la opcion de cambiar el estado de la orden a cerrada
    *
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
        $titulo = "CERRAR ORDEN DE IMPORTACION";
        $object = TImportacion::with('estado','proveedor','puerto_embarque','origenMercancia','embarqueimportacion','pagosimportacion','nacionalizacionimportacion', 'inconterm')->where('t_importacion.id', "=", $id)->first();

        $objeto2 =TOrigenMercanciaImportacion::with('origenes')->where('omeim_importacion','=', "$id" )->get();

        $objeto3 = TProductoImportacion::select('pdim_producto', 'id')->where('pdim_importacion','=',"$id")->get();
        $objeto4 = TProforma::where('prof_importacion','=', intval($id))->get();

        $objeto5 = TEmbarqueImportacion::with('embarcador', 'lineamaritima', 'tipoCarga','aduana','transportador', 'contenedor.tipo')->where('emim_importacion','=', intval($id))->get();
        $objeto6 = TPagoImportacion::where('pag_importacion', '=', "$id")->get();
        $objeto7 = TNacionalizacionImportacion::with('tiponacionalizacion', 'declaracion.levanteDeclaracion', 'declaracion.admindianDeclaracion')->where('naco_importacion', '=', "$id")->get();
        #Crea un array con la informacion necesaria para mostrar en una tabla los productos asociados a la orden de importacion

        $tablaProductos = array();
        foreach ($objeto3 as $key => $value) {
            $unProducto = array();
            $prodLocal = TProducto::find(intval($value->pdim_producto));

            $referenciaProd = $prodLocal->prod_referencia;
            $queries = $this->consultaProductosUnoee($referenciaProd);
            $descripcion = $queries[0]->f120_referencia." -- ".$queries[0]->f120_descripcion;
            array_push($unProducto, $descripcion);
            array_push($tablaProductos, $unProducto);

        }
         #Retorna la informacion a la vista editar

        $hasPerm = $this->permisos();
        return view('importacionesv2.importacionTemplate.showImportacion',
            compact('object',
                'titulo',
                'tablaProductos',
                'objeto2',
                'objeto4',
                'objeto5',
                'objeto6',
                'objeto7',
                'hasPerm'));
    }

    /**
    * consultaProductosUnoee
    *
    * Esta funcion retorna la informacion del uno ee para una referencia en especifico
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function consultaProductosUnoee($referenciaProd){
     return DB::connection('unoeereal')->table('t124_mc_items_referencias as a')
     ->join('t120_mc_items as b', 'a.f124_rowid_item','=','b.f120_rowid')
     ->select('a.f124_referencia', 'b.f120_referencia', 'b.f120_descripcion')
     ->where('a.f124_referencia', 'LIKE', "%$referenciaProd%")
     ->get();
 }


   /**
    *
    * edit
    *
    * Muestra el formulario para editar un proceso de importacion en especifico
    *
    * Permite editar la tabla t_importacion
    *
    * Permite editar la tabla t_producto_importacion
    *
    * Permite editar la tabla t_proforma_importacion
    *
    * Debe validar que no exista una importacion con el mismo
    *
    * debe validar que vengan al menos un producto asociado a la orden de imporacion
    *
    * debe validar que venga al menos una proforma asociada a la orden de importacion
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //Id del registro que deseamos editar
        $id = $id;

        //Consulto el registro que deseo editar
        $objeto = TImportacion::with('proveedor')->find($id);
        //Titulo de la pagina
        $titulo = "EDITAR PROCESO DE IMPORTACION -". $objeto->imp_consecutivo;
        //url de redireccion para consultar
        $url = route('Importacion.store');
        // Validaciones ajax
        $validator = JsValidator::make($this->rules, $this->messages);
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'Importacion.update';
        #Consulta los origenes de la mercancia importacion asociados a esta en especifico
        $objeto2 = TOrigenMercanciaImportacion::with('origenes')->where('omeim_importacion','=', "$id" )->get();
        $seleccionados = [];
        #En un array mete los origenes que deben estar seleccionados en el multiselect
        foreach ($objeto2 as $key => $value) {
            array_push ($seleccionados, $value->origenes[0]->id);
        }
        #Obtiene los productos asociados a la orden de importacion
        $objeto3 = TProductoImportacion::select('pdim_producto', 'id')->where('pdim_importacion','=',"$id")->get();

        #Crea un array con la informacion necesaria para mostrar en una tabla los productos asociados a la orden de importacion
        $tablaProductos = array();

        foreach ($objeto3 as $key => $value) {
            $unProducto = array();
            $prodLocal = TProducto::find($value->pdim_producto);
            $referenciaProd = $prodLocal->prod_referencia;

            $queries = $this->consultaProductosUnoee($referenciaProd);
            if ($queries->all() != []) {
               $descripcion = $queries[0]->f120_referencia." -- ".$queries[0]->f120_descripcion;
               array_push($unProducto, $descripcion);

               if($prodLocal->prod_req_declaracion_anticipado == 1){
                array_push($unProducto, "SI");
            }else{
                array_push($unProducto, "NO");
            }
            if($prodLocal->prod_req_registro_importacion == 1){
                array_push($unProducto, "SI");
            }else{
                array_push($unProducto, "NO");
            }


            array_push($unProducto, $value->id);
            array_push($tablaProductos, $unProducto);
        }

    }

    $cantidadProductos = count($tablaProductos);

        #Consulta las proformas asociadas a la importacion
    $objeto4 = TProforma::where('prof_importacion','=', intval($id))->get();
        #Crea un array con las proformas asociadas a la importacion para mostrarlas en una tabla
    $tablaProformas = array();
    foreach ($objeto4 as $key => $value) {
        $unaProforma = array();
        array_push($unaProforma, $value->prof_numero);
        array_push($unaProforma, $value->prof_fecha_creacion);
        array_push($unaProforma, $value->prof_fecha_entrega);
        array_push($unaProforma, $value->prof_valor_proforma);

        if($value->prof_principal == 1){
            array_push($unaProforma, "SI");
        }else{
            array_push($unaProforma, "NO");
        }
        array_push($unaProforma, $value->id);
        array_push($tablaProformas, $unaProforma);

    }
    $cantidadProformas = count($tablaProductos);

         #Crea los array de las consultas para mostrar en los Combobox
    $consulta = array(1,2,5,3);
    $combos = $this->consultas($consulta);
    extract($combos);
        #Crea las urls de borrar producto y borrar proforma por ajax basado en el name de la ruta
    $urlBorrar = route('borrarProductoImportacion');
    $urlBorrarProforma = route('borrarProformaImportacion');
        #Retorna la informacion a la vista editar
    $hasPerm = $this->permisos();
    return view('importacionesv2.importacionTemplate.editImportacion',
        compact('campos',
           'url',
           'titulo',
           'validator',
           'route',
           'id',
           'objeto',
           'seleccionados',
           'puertos',
           'inconterm',
           'origenMercancia',
           'tablaProductos',
           'cantidadProductos',
           'tablaProformas',
           'cantidadProformas',
           'urlBorrar',
           'urlBorrarProforma',
           'moneda',
           'hasPerm'));
}


 /**
    *
    * permisos
    *
    * Valida los permisos de usuario retorna 1 si tiene permisos si no retorna 0
    *
    * @return int
    */
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
    * objectoImportacion
    *
    * Funcion que recibe un objeto del modelo importacion y le agrega la informacion que viene en el request
    * debe retornar el objeto nuevamente.
    *
    * la uso para no escribir este codigo dos veces en las funciones store y update
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
public function objectoImportacion($objeto, $request){

            //Edita el registro en la tabla importacion
    $objeto->imp_consecutivo = $request->imp_consecutivo;
    $objeto->imp_proveedor = $request->imp_proveedor;
    $objeto->imp_puerto_embarque = $request->imp_puerto_embarque;
    $objeto->imp_iconterm = $request->imp_iconterm;
    $objeto->imp_moneda_negociacion = $request->imp_moneda_negociacion;

    if($request->imp_observaciones == ""){
        $objeto->imp_observaciones = null;
    }else{
        $objeto->imp_observaciones = strtoupper($request->imp_observaciones);
    }

    if($request->imp_fecha_entrega_total == ""){
        $objeto->imp_fecha_entrega_total = null;
    }else{
       $date = Carbon::parse($request->imp_fecha_entrega_total)->format('Y-m-d');
       $objeto->imp_fecha_entrega_total = $date ;
    }
   return $objeto;
}


    /**
    * update
    *
    * Debe actualizar el registro de la tabla t_importacion segun el id,
    *
    * Debe actualizar los registros de la tabla producto importacion
    *
    * Debe actualizar los registros de la tabla proforma importacion
    *
    * Debe actualizar los registros de la tabla origenes de la mercancia
    *
    * Debe validar que el consecutivo de importacion no exista para otra importacion
    *
    * Debe redireccionar al formulario de consulta
    *
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        #Valida que no exista una importacion con el mismo consecutivo modificado de esta
        $validarExistencia = TImportacion::where(array(array('imp_consecutivo', '=', "$request->imp_consecutivo"),array('id', '!=', $id)))->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/$id/edit")
            ->withErrors('El consecutivo ingresado ya existe para otra orden de importacion')->withInput();
        }
         #Crea todas las proformas asociadas en la tabla
        $cantidad1 = intval($request->tablaproformaguardar);
        for ($i=1; $i < $cantidad1+1 ; $i++) {
            $valorprof = $i."-valorprof";
            if(count("$request->$valorprof") > 10){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
                return Redirect::to("importacionesv2/Importacion/create")
                ->withErrors('Debe el valor de la proforma no puede tener mas de 10 numeros')->withInput();
            }

        }
        //Genera la url de consulta
        $url = route('consultaFiltros');
        //Consulto el registro a editar
        $objeto = TImportacion::find($id);
        $ObjectUpdate = $this->objectoImportacion($objeto, $request);
        $ObjectUpdate->save();

        #Obtiene los productos que debe guardar de la tabla productos
        $cantidad = intval($request->tablaGuardar);

        if($cantidad != ""){
            for ($i=1; $i < $cantidad+1; $i++) {
                $str4 = $i.'-idproducto';
                if($request->$i != "" && $request->$str4 == ""){
                    $alerta = 0;
                    $strvariable = $i."variable";
                    $strvariable = new TProductoImportacion;

                    $date = Carbon::now();
                    $date = $date->format('Y-m-d');
                    $ref = $request->$i;
                    $producto = TProducto::where('prod_referencia','LIKE', "%$ref%")
                    ->first();
                    $strvariable->pdim_producto = $producto->id;
                    $strvariable->pdim_importacion = $id;
                    if($producto->prod_req_declaracion_anticipado == 1){
                        $strvariable->pdim_fech_req_declaracion_anticipado = $date;
                        $alerta = 1;
                    }
                    if($producto->prod_req_registro_importacion == 1){
                        $strvariable->pdim_fech_requ_registro_importacion = $date;
                        $alerta = 1;
                    }
                    $strvariable->pdim_alerta =$alerta;
                    $strvariable->save();
                }
            }
        }
        #Obtiene las proformas que va a guardar de la tabla proformas

        if($cantidad1 != ""){
            for ($i=1; $i < $cantidad1+1 ; $i++) {
                $str5 = $i.'-idproforma';
                $noprof = $i."-noprof";
                if($request->$str5 == "" && $request->$noprof != "")
                {
                   $strproforma = $i."objproforma";
                   $strproforma = new TProforma;
                   $strproforma->prof_importacion = $id;
                   $creaprof = $i."-creaprof";
                   $entregaprof = $i."-entregaprof";
                   $valorprof = $i."-valorprof";
                   $princprof = $i."-princprof";
                   $strproforma->prof_numero = $request->$noprof;
                   $date1 = Carbon::parse($request->$creaprof)->format('Y-m-d');
                   $strproforma->prof_fecha_creacion = $date1;
                   $date2 = Carbon::parse($request->$entregaprof)->format('Y-m-d');
                   $strproforma->prof_fecha_entrega = $date2;
                   $strproforma->prof_valor_proforma = $request->$valorprof;
                   $strproforma->prof_principal = intval($request->$princprof);
                   $strproforma->save();
               }

           }

       }
       #Obtiene los origenes de la mercancia asociados a la importacion
       $origenesExistentes = TOrigenMercanciaImportacion::where('omeim_importacion','=',intval($id))->get();
       #Valida cuales de los origenes de la mercancia de la bd fueron quitados del multiselect y los borra
       foreach ($origenesExistentes as $key => $value) {
           $buscar = in_array($value->omeim_origen_mercancia, $request->origenMercancia);
           if(!$buscar){
            $value->id;
            $ObjectDestroy = TOrigenMercanciaImportacion::find($value->id);
            $ObjectDestroy->delete();
        }
    }
    #Valida cuales de los origenes de la mercacia del multiselect no se encuentran en la bd y los crea
    foreach ($request->origenMercancia as $key => $value) {
        $flight = TOrigenMercanciaImportacion::firstOrCreate(['omeim_importacion' => $id,
            'omeim_origen_mercancia' => $value]);
    }
        //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'El proceso de importacion fue editado exitosamente!');
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
        $importacion = TImportacion::find($id);
        $importacion->imp_estado_proceso = 7;
        $importacion->save();
        $url = route('consultaFiltros');
        Session::flash('message', 'La orden fue anulada exitosamente');
        return redirect($url);

    }


    /**
    * borrar
    *
    * Esta funcion se llama a traves de ajax usando la libreria jquery en el archivo importacionesV2.js
    * Su objetivo es validar si existen mas de un producto asociados a la importacion, y si si existen borrar el que
    * le indican por medio del request.
    *
    * 1 -  Consulta la cantidad de productos asociados a la orden de importacion ya existente
    * 2 -  si la cantidad es mayor que 1 permite borrar el producto importacion cuyo id corresponda a lo que viene en request->obj
    * 3 -  si la cantidad es <= 1 entonces retorna mensaje que indica que no se puede borrar el producto.
    *
    * @param  int  request->obj -> objeto a borrar * String _token -> token de seguridad
    * @return \Illuminate\Http\Response
    */
    public function borrar(Request $request)
    {

       $contador = TProductoImportacion::where('pdim_importacion', '=', intval($request->identificador))->get()->count();
       if($contador > 1){
            //Consulto objeto a borrar
        $ObjectDestroy = TProductoImportacion::where('id', $request->obj)->first();

        //Borro el objeto
        $ObjectDestroy->delete();
        return "Producto borrado exitosamente";
    }else{
        return "Debe existir almenos un producto asociado a la orden de importacion";
    }
}


    /**
     * borrarProforma
     *
    * Funcion creada para el borrado de la proforma asociada a la importacion por ajax
    *
    * debe retornar mensaje de exito si el borrado se ejecuto correctamente
    *
    * si solo queda una proforma debe retornar mensaje de error informando la sitacion
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function borrarProforma(Request $request)
    {
       $contador = TProforma::where('prof_importacion', '=', intval($request->identificador))->get()->count();
       if($contador > 1){
            //Consulto objeto a borrar
        $ObjectDestroy = TProforma::find($request->obj);
        //Borro el objeto
        $ObjectDestroy->delete();

        return "Proforma borrada exitosamente";
    }else{
        return "Debe existir almenos un producto asociado a la orden de importacion";
    }
}



 /**
     * autocomplete
     *
     * debe consultar el unoee  traer los terceros
     *
     * debe poner los terceros dentro de un array
     *
     * debe reponder con un json
     *
    * @return \Illuminate\Http\Response
    */
public function autocomplete(){
    //Funcion para autocompletado de proveedores
    $term = Input::get('term');
    $results = array();
    $queries = DB::connection('genericas')
    ->table('tercero')
    ->where('nitTercero', 'LIKE', '%'.$term.'%')
    ->orWhere('razonSocialTercero', 'LIKE', '%'.$term.'%')
    ->take(10)->get();

    foreach ($queries as $query)
    {
        $results[] = [ 'id' => $query->nitTercero, 'value' => $query->nitTercero.' -> '.$query->razonSocialTercero];
    }
    return Response::json($results);
}


 /**
     * autocomplete
     *
     * debe consultar el unoee  traer los terceros
     *
     * debe poner los terceros dentro de un array
     *
     * debe reponder con un json
     *
     * @param $request
    * @return \Illuminate\Http\Response
    */
public function autocompleteProducto(Request $request){
    #Funcion de consulta de productos para el formulario de importaciones
  $referencia = strtoupper($request->obj);
  $referencia = str_replace("¬¬¬°°°", "+", $referencia);
  $queries = $this->consultaProductosUnoee($referencia);
  if($queries->all() != []){
    $string = $queries[0]->f120_referencia . " -- " . $queries[0]->f120_descripcion;
    $producto = TProducto::where('prod_referencia','=', $queries[0]->f120_referencia)
    ->get();
    if($producto->all() == []){
        return array($string, array(), '1');
    }else{
        return array($string, array($producto[0]->prod_req_declaracion_anticipado, $producto[0]->prod_req_registro_importacion), '0');
    }
}
return "error";
}


 /**
  * consultas
  *
    * Funcion creada para generar las consultas de los combobox en las funciones create y edit
    *
    * @param recibe un array con numeros segun la consulta solicitada
    * @return debe retornar un array de arrays indexado por palabras que hacen referencia a la informacion que se necesita en el formulario para pintar los combobox
    *
    */
 public function consultas($consulta){

    $combos = array();
        // Combobox puertos
    if(in_array(1, $consulta)){
        $array = Cache::remember('puertoembarque', 60, function() {return TPuertoEmbarque::all();});
        $puertos = array();
        foreach ($array as $key => $value) {$puertos["$value->id"] = $value->puem_nombre;}
        $combos['puertos'] = $puertos;
    }
        //end Combobox puertos
        // Combobox inconterm
    if(in_array(2, $consulta)){
        $array = Cache::remember('inconterm', 60, function(){return TIconterm::all();});
        $inconterm = array();
        foreach ($array as $key => $value) {$inconterm["$value->id"] = $value->inco_descripcion;}
        $combos['inconterm'] = $inconterm;
    }
        //end Combobox puertos
    //     // Combobox monedas
    if(in_array(3, $consulta)){
        $array = Cache::remember('moneda', 60, function(){return DB::connection('besa')->table('9000-appweb_monedas_ERP')->get();});
        $moneda = array();
        foreach ($array as $key => $value) {$moneda["$value->id_moneda"] = $value->desc_moneda;}
        $combos['moneda'] = $moneda;
    }
        //end Combobox puertos
         //Combobox estado
    if(in_array(4, $consulta)){
        $array = Cache::remember('estado', 60, function(){return TEstado::all();});
        $inconterm = array();
        foreach ($array as $key => $value) {$inconterm["$value->id"] = $value->est_nombre;}
        $combos['estados'] = $inconterm;
    }

     //select multiple origen mercancia
    if(in_array(5, $consulta)){
        $array =  TOrigenMercancia::pluck('ormer_nombre', 'id');
        $combos['origenMercancia'] = $array;
    }


    return $combos;
}


 /**
     * consultaFiltrada
     *
     * La funcion principal es mostrar un formulario con filtros para consultar todas las ordenes de importacion ya sea por puerto de embarque, por consecutivo de importacion, por estado o por proveedor.
     *
     * esta consulta tiene links que redireccionan a la creacion de la orden de importacion,
     *
     * redirecciona tambien al embarque si ya existe la orden de importacion
     *
     * redirecciona a los pagos
     *
     * redirecciona a la nacionalizacion y costeo si ya esta creado el embarque
     *
     * redirecciona a la pestaña de cierre de alertas si ya se creo la importacion, el embarque, los pagos y la nacionalizacion y costeo.
     *
     *
     *
    * @return \Illuminate\Http\Response
    */
 public function consultaFiltrada(Request $request){
    #Genero los where para la consulta dependiendo de los filtros enviados por la vista
    $where = array();
    if($request->imp_puerto_embarque != ""){
        $wherePuerto = array('imp_puerto_embarque', '=', $request->imp_puerto_embarque);
        array_push($where, $wherePuerto);
    }
    if($request->imp_estado_proceso != ""){
        $whereEstado = array('imp_estado_proceso', '=', $request->imp_estado_proceso);
        array_push($where, $whereEstado);
    }
    if($request->imp_consecutivo != ""){
        $whereConsecutivo = array('imp_consecutivo', '=', $request->imp_consecutivo);
        array_push($where, $whereConsecutivo);
    }
    if($request->imp_proveedor != ""){
        $whereNit = array('imp_proveedor', 'like', "%$request->imp_proveedor%");
        array_push($where, $whereNit);
    }

        //Seteo el titulo en la funcion para mostrar en la vista index
    $titulo = "CONSULTA ORDENES DE IMPORTACION";

        /**
        *Variable datos debe contener la informacion que se quiere mostrar en el formulario
        */
        if($where == [] && $request->consulto == 1){
            $datos = TImportacion::with('estado','puerto_embarque','embarqueimportacion','proveedor','pagosimportacion')->orderBy('t_importacion.id', 'desc')->get();
        }elseif($where != [] && $request->consulto == 1){
            $datos = TImportacion::with('estado')->with('puerto_embarque')->orWhere($where)->orderBy('t_importacion.id', 'asc')->get();
        }else{
            $datos = array();
        }
        /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
        $titulosTabla =  array('Consecutivo', 'Proveedor',  'Estado', 'Puerto de embarque', 'Importacion', 'Embarque', 'Pagos', 'Nacionalizacion y costeo', 'Cerrar orden');

        //crea los array de las consultas para mostrar en los Combobox
        $consulta = array(1, 4);
        $combos = $this->consultas($consulta);
        extract($combos);
        //Genera url completa de consulta
        $url = route("consultaFiltros");
        $url2 = route("Importacion.store");
        $url3 = route("Embarque.store");
        $url4 = route("Pagos.store");
        $url5 = route("NacionalizacionCosteo.store");
        $hasPerm = $this->permisos();
        #Retorna la informacion a la vista
        return view('importacionesv2.importacionTemplate.consultaImportacion', compact('titulo',
            'datos',
            'titulosTabla',
            'campos',
            'url',
            'url2',
            'url3',
            'url4',
            'url5',
            'puertos',
            'estados',
            'hasPerm'));

    }


    public function alertasImportacion(Request $request){
    //Seteo el titulo en la funcion para mostrar en la vista index
        $titulo = "CERRAR ALERTAS DE PRODUCTO IMPORTACION";

     /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
     $titulosTabla =  array('Referencia', 'Consecutivo importacion', 'Fecha declaracion anticipada', 'Fecha registro importacion', 'Dias', 'Cerrar alertas');

        //Genera url completa de consulta
     $url = route("consultaAlertas");
        #Retorna la informacion a la vista

     $datos = TProductoImportacion::with('importacion.embarqueimportacion')->with('producto')->where('pdim_alerta','=','1')->get();
     if(count($datos) > 0){
        $embarque = TEmbarqueImportacion::where('emim_importacion', $datos[0]->pdim_importacion)->first();
    }else{
        $embarque = [];
    }

    return view('importacionesv2.importacionTemplate.consultaAlertas', compact('titulo',
        'datos',
        'titulosTabla',
        'url',
        'embarque'));
}




/**
     * cerrarOrden
     *
     * funcion que toma la importacion y le cambia el estado
     * retorna error si alguno de los campos de todo el proceso de negocio no esta diligenciado
     * redirecciona a la consulta con filtros
     *
     *
    * @return \Illuminate\Http\Response
    */
public function cerrarOrden(Request $request){

    $objectImportacion = TImportacion::find($request->OrdenId);
    $objectPagos = TPagoImportacion::where('pag_importacion', $request->OrdenId)->first();
    $objectNacionalizacion = TNacionalizacionImportacion::where('naco_importacion', $request->OrdenId)->first();
    $objectEmbarque = TEmbarqueImportacion::where('emim_importacion', $request->OrdenId)->first();

    $mensaje = [];
    if($objectImportacion->imp_fecha_entrega_total == null){
        array_push($mensaje , "Favor ingresar la fecha entrega total - Modulo importacion");
    }

    if($objectPagos->pag_fecha_anticipo == null){
        array_push($mensaje ,  "Favor ingresar la fecha del anticipo - Modulo pagos");
    }

    if($objectPagos->pag_fecha_saldo == null){
     array_push($mensaje ,  "Favor ingresar la fecha del saldo - Modulo pagos");
    }

     if($objectPagos->pag_valor_anticipo === null){
         array_push($mensaje ,  "Favor ingresar el valor del anticipo - Modulo pagos");
     }
     if($objectPagos->pag_valor_saldo === null){
         array_push($mensaje ,  "Favor ingresar el valor del saldo - Modulo pagos");
     }

     if($objectPagos->pag_valor_comision === null){
         array_push($mensaje ,  "Favor ingresar el valor de la comision - Modulo pagos");
     }

     if($objectNacionalizacion->naco_fecha_envio_comex == null){
         array_push($mensaje ,  "Favor ingresar fecha envio comex - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_fecha_llegada_be == null){
         array_push($mensaje ,  "Favor ingresar fecha de llegada a Belleza Express - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_fecha_recep_list_empaq == null){
         array_push($mensaje ,  "Favor ingresar fecha de recepcion lista de empaque - Modulo nacionalizacion y costeo ");
     }
     if($objectNacionalizacion->naco_fecha_envi_liqu_costeo == null){
         array_push($mensaje ,  "Favor ingresar fecha envio liquidacion y costeo - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_fecha_entrada_sistema == null){
         array_push($mensaje ,  "Favor ingresar fecha entrada al sistema - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_factor_dolar_porc == null){
         array_push($mensaje ,  "Favor ingresar el factor total - Modulo nacionalizacion y costeo ");
     }
     if($objectNacionalizacion->naco_factor_dolar_tasa == null){
         array_push($mensaje ,  "Favor ingresar el factor importacion porcentual - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_factor_logist_porc == null){
         array_push($mensaje ,  "Favor ingresar el factor logistico - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_factor_logist_tasa == null){
         array_push($mensaje ,  "Favor ingresar el factor logistico en pesos - Modulo nacionalizacion y costeo");
     }
     if($objectNacionalizacion->naco_factor_arancel_porc == null){
         array_push($mensaje ,  "Favor ingresar el factor arancel - Modulo nacionalizacion y costeo ");
     }


     if($objectEmbarque->emim_valor_flete == null){
         array_push($mensaje ,  "Favor ingresar el valor del flete - Modulo Embarque importacion");
     }


     if($objectEmbarque->emim_fecha_recibido_documentos_ori == null){
         array_push($mensaje ,  "Favor ingresar la fecha recibo documentos originales - Modulo Embarque importacion");
     }

     if($objectEmbarque->emim_fecha_envio_aduana == null){
         array_push($mensaje ,  "Favor ingresar la fecha envio agencia de aduanas - Modulo Embarque importacion");
     }

     if($objectEmbarque->emim_fecha_envio_ficha_tecnica == null){
         array_push($mensaje ,  "Favor ingresar la fecha de envio ficha tecnica - Modulo Embarque importacion");
     }


     if($objectEmbarque->emim_fecha_envio_lista_empaque == null){
         array_push($mensaje ,  "Favor ingresar la fecha envio lista de empaque - Modulo Embarque importacion");
     }




        if($mensaje == []){
        $objectImportacion->imp_estado_proceso = 6;
        $objectImportacion->save();
        $urlConsulta = route('consultaFiltros');
        return Redirect::to($urlConsulta);
        }else{
            $url = route('cerrarImportacion');
            return redirect()->action(
                'Importacionesv2\TImportacionController@show', ['id' => $request->OrdenId]
                )->withErrors($mensaje);
        }

    }



}
