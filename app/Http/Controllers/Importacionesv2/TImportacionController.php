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
 * Controlador TImportacionController
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
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

    public function __construct()
    {
        $this->middleware('ImpMid')->only(['store', 'update', 'cerrarOrden']);
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
    * Muestra el formulario para la creadcion de un nuevo proceso de importacion
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
    * Store a newly created resource in storage.
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
        $ObjectCrear = new TImportacion;
        $ObjectCrear->imp_consecutivo = strtoupper(Input::get('imp_consecutivo'));
        $ObjectCrear->imp_proveedor = Input::get('imp_proveedor');
        $ObjectCrear->imp_puerto_embarque = Input::get('imp_puerto_embarque');
        $ObjectCrear->imp_iconterm = Input::get('imp_iconterm');
        $ObjectCrear->imp_moneda_negociacion = Input::get('imp_moneda_negociacion');
        if($request->imp_observaciones == ""){
            $ObjectCrear->imp_observaciones = null;
        }else{
            $ObjectCrear->imp_observaciones = strtoupper(Input::get('imp_observaciones'));
        }
        if($request->imp_fecha_entrega_total == ""){
            $ObjectCrear->imp_fecha_entrega_total = null;
        }else{
         $date = Carbon::parse(Input::get('imp_fecha_entrega_total'))->format('Y-m-d');
         $ObjectCrear->imp_fecha_entrega_total = $date ;
     }
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
    * Display the specified resource.
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

        $objeto5 = TEmbarqueImportacion::with('embarcador', 'lineamaritima', 'tipoCarga','aduana','transportador')->where('emim_importacion','=', intval($id))->get();
        $objeto6 = TPagoImportacion::where('pag_importacion', '=', "$id")->get();
        $objeto7 = TNacionalizacionImportacion::with('tiponacionalizacion')->where('naco_importacion', '=', "$id")->get();
        #Crea un array con la informacion necesaria para mostrar en una tabla los productos asociados a la orden de importacion
        $tablaProductos = array();
        foreach ($objeto3 as $key => $value) {
            $unProducto = array();
            $prodLocal = TProducto::find($value->pdim_producto);
            $referenciaProd = $prodLocal->prod_referencia;
            $queries = DB::connection('genericas')
            ->table('item')
            ->select('referenciaItem', 'descripcionItem')
            ->where('referenciaItem', 'LIKE', "%".$referenciaProd."%")
            ->get();
            $descripcion = $queries[0]->referenciaItem." -- ".$queries[0]->descripcionItem;
            array_push($unProducto, $descripcion);
            array_push($tablaProductos, $unProducto);

        }
        return view('importacionesv2.importacionTemplate.showImportacion',
            compact('object',
                'titulo',
                'tablaProductos',
                'objeto2',
                'objeto4',
                'objeto5',
                'objeto6',
                'objeto7'));
    }

    /**
    * Muestra el formulario para editar un proceso de importacion en especifico
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
        // dd($objeto);
        //Titulo de la pagina
        $titulo = "EDITAR PROCESO DE IMPORTACION";
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
            $queries = DB::connection('genericas')
            ->table('item')
            ->select('referenciaItem', 'descripcionItem')
            ->where('referenciaItem', 'LIKE', "%".$referenciaProd."%")
            ->get();
            $descripcion = $queries[0]->referenciaItem." -- ".$queries[0]->descripcionItem;
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
        $ObjectUpdate = TImportacion::find($id);
        //Edita el registro en la tabla importacion
        $ObjectUpdate->imp_consecutivo = $request->imp_consecutivo;
        $ObjectUpdate->imp_proveedor = $request->imp_proveedor;
        $ObjectUpdate->imp_puerto_embarque = $request->imp_puerto_embarque;
        $ObjectUpdate->imp_iconterm = $request->imp_iconterm;
        $ObjectUpdate->imp_moneda_negociacion = $request->imp_moneda_negociacion;
        $date4 = Carbon::parse($request->imp_fecha_entrega_total)->format('Y-m-d');
        $ObjectUpdate->imp_fecha_entrega_total = $date4;
        $ObjectUpdate->imp_observaciones = $request->imp_observaciones;
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
    }


    /**
    * Funcion creada para el borrado de productos por ajax en el formulario importacion
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function borrar(Request $request)
    {
        #Consulto los productos asociados a la importacion y valido que exista almenos un registro en la base de datos, si hay mas de un registro el sistema debe permitir borrar
     $contador = TProductoImportacion::where('pdim_importacion', '=', intval($request->identificador))->get()->count();
     if($contador > 1){
            //Consulto objeto a borrar
        $ObjectDestroy = TProductoImportacion::find($request->obj);
        //Borro el objeto
        $ObjectDestroy->delete();

        return "Producto borrado exitosamente";
    }else{
        return "Debe existir almenos un producto asociado a la orden de importacion";
    }
}


    /**
    * Funcion creada para el borrado de la proforma asociada a la importacion por ajax
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


public function autocompleteProducto(Request $request){
    #Funcion de consulta de productos para el formulario de importaciones
  $referencia = strtoupper($request->obj);
  $referencia = str_replace("¬¬¬°°°", "+", $referencia);
  $queries = DB::connection('genericas')
  ->table('item')
  ->where('referenciaItem', 'LIKE', "%$referencia%")
  ->get();

  if($queries->all() != []){
    $string = $queries[0]->referenciaItem . " -- " . $queries[0]->descripcionItem;
    $producto = TProducto::where('prod_referencia','LIKE', "%$referencia%")
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
    * Funcion creada para generar las consultas de los combobox en las funciones create y edit
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
    * Funcion creada para generar la vista de consultas con filtros para las ordenes de importacion
    *
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
            $datos = TImportacion::with('estado','puerto_embarque','embarqueimportacion','proveedor','pagosimportacion')->orderBy('t_importacion.imp_consecutivo', 'desc')->get();
        }elseif($where != [] && $request->consulto == 1){
            $datos = TImportacion::with('estado')->with('puerto_embarque')->orWhere($where)->get();
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
            'estados'));

    }


    public function alertasImportacion(Request $request){
    //Seteo el titulo en la funcion para mostrar en la vista index
        $titulo = "CERRAR ALERTAS DE PRODUCTO IMPORTACION";
     /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
     $titulosTabla =  array('Referencia', 'Consecutivo importacion', 'Fecha declaracion anticipada', 'Fecha registro importacion',  'Alerta activa', 'Dias desde apertura', 'Cerrar alertas');

        //Genera url completa de consulta
     $url = route("consultaAlertas");
        #Retorna la informacion a la vista

     $datos = TProductoImportacion::with('importacion.embarqueimportacion')->with('producto')->where('pdim_alerta','=','1')->get(); 

     $embarque = TEmbarqueImportacion::where('emim_importacion', $datos[0]->pdim_importacion)->first();

     return view('importacionesv2.importacionTemplate.consultaAlertas', compact('titulo',
        'datos',
        'titulosTabla',
        'url',
        'embarque'));
 }

 public function cerrarOrden(Request $request){

    $objectImportacion = TImportacion::find($request->OrdenId);
    $objectImportacion->imp_estado_proceso = 6;
    $objectImportacion->save();
    $urlConsulta = route('consultaFiltros');
    return Redirect::to($urlConsulta);
}


}
