<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JsValidator;
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
use Carbon\Carbon;

class TImportacionController extends Controller
{

    //Defino las reglas de validacion para el formulario
  public $rules = array(
    'imp_consecutivo'       => 'required',
    'imp_proveedor'       => 'required',
    'imp_puerto_embarque'      => 'required',
    'imp_iconterm'      => 'required',
    'imp_moneda_negociacion'     => 'required',
    'origenMercancia'  => 'required|array|min:1',
    );

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'imp_consecutivo.required'       => 'Favor ingresar el consecutivo de importacion',
    'imp_proveedor.required'       => 'Favor ingresar el proveedor',
    'imp_puerto_embarque.required'      => 'Favor seleccionar el puerto de embarque',
    'imp_iconterm.required'      => 'Favor seleccionar el inconterm',
    'imp_moneda_negociacion.required'     => 'Favor seleccionar una moneda de negociacion',
    'origenMercancia.required'  => 'Favor ingresar el origen de la mercancia',
    );
    //url de consulta
  public $strUrlConsulta = 'importacionesv2/Importacion';
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
    public function create(Request $request)
    {
        //Variable que contiene el titulo de la vista crear
        $titulo = "CREAR IMPORTACION";
        //Libreria de validaciones con ajax
        $validator = JsValidator::make($this->rules, $this->messages);
        //Genera url de consulta
        $url = url($this->strUrlConsulta);
        //crea los array de las consultas para mostrar en los Combobox
        $consulta = array(1,2,3);
        $combos = $this->consultas($consulta);
        extract($combos);
        //Consigue el usuario de session y fecha actual
        $usuario = Auth::user();
        $date = Carbon::now();
        $year = $date->format('Y');
        //consigue el ultimo id de la tabla y genera un consecutivo de creacion
        $imp_consecutivo = TImportacion::max('id') + 1;
        $imp_consecutivo = "$imp_consecutivo/" .$year; 
        $origenMercancia = TOrigenMercancia::pluck('ormer_nombre', 'id');
        return view('importacionesv2.ImportacionTemplate.createImportacion', 
            compact('titulo',
                'url',  
                'validator', 
                'puertos', 
                'inconterm',
                'moneda',
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

        //Genera la url de consulta
        $url = url("importacionesv2/Importacion/create");
        $urlConsulta = route('consultaFiltros');
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TImportacion::where('imp_consecutivo', '=', "$request->imp_consecutivo")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('La importacion que intenta crear tiene el mismo nombre que un registro ya existente')->withInput();
        }
        if($request->tablaGuardar == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('Debe ingresar almenos un producto')->withInput();
        }
        
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
     if(!$ObjectCrear->id){
        App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema');
    }else{
        $cantidad = intval($request->tablaGuardar);
        
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


            }

        }

        $cantidadOrigenes = count($request->origenMercancia);
        for ($i=0; $i < $cantidadOrigenes ; $i++) { 
           $strorimerc = $i."variable";
           $strorimerc = new TOrigenMercanciaImportacion;
           $strorimerc->omeim_origen_mercancia = $request->origenMercancia[$i];
           $strorimerc->omeim_importacion = $ObjectCrear->id;
           $strorimerc->save();
       }



     Cache::forget('importacion');
        //Redirecciona a la pagina de creacion y muestra mensaje
     Session::flash('message', 'El proceso de importación fue creado exitosamente!');
     return Redirect::to($urlConsulta);

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
        // Combobox monedas
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

    return $combos;
}

public function consultaFiltrada(Request $request){

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
            $datos = TImportacion::with('estado')->with('puerto_embarque')->get();
        }elseif($where != [] && $request->consulto == 1){
            $datos = TImportacion::with('estado')->with('puerto_embarque')->orWhere($where)->get();
        }else{
            $datos = array();
        }
        
        /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
        $titulosTabla =  array('Consecutivo', 'Proveedor',  'Estado', 'Puerto de embarque', 'Editar', 'Eliminar');

        //crea los array de las consultas para mostrar en los Combobox
        $consulta = array(1, 4);
        $combos = $this->consultas($consulta);
        extract($combos);
        //Genera url completa de consulta
        $url = route("consultaFiltros");

        return view('importacionesv2.ImportacionTemplate.consultaImportacion', compact('titulo',
            'datos',
            'titulosTabla',
            'campos',
            'url',
            'puertos',
            'estados'));

    }
}
