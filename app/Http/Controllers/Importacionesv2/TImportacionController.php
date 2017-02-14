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
    );

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'imp_consecutivo.required'       => 'Favor ingresar el consecutivo de importacion',
    'imp_proveedor.required'       => 'Favor ingresar el proveedor',
    'imp_puerto_embarque.required'      => 'Favor seleccionar el puerto de embarque',
    'imp_iconterm.required'      => 'Favor seleccionar el inconterm',
    'imp_moneda_negociacion.required'     => 'Favor seleccionar una moneda de negociacion',
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
        return view('importacionesv2.ImportacionTemplate.createImportacion', 
            compact('titulo',
                'url',  
                'validator', 
                'puertos', 
                'inconterm',
                'moneda',
                'imp_consecutivo'));
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
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TImportacion::where('imp_consecutivo', '=', "$request->imp_consecutivo")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("importacionesv2/Importacion/create")
            ->withErrors('La importacion que intenta crear tiene el mismo nombre que un registro ya existente');
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
     Cache::forget('importacion');
        //Redirecciona a la pagina de creacion y muestra mensaje
     Session::flash('message', 'El proceso de importación fue creado exitosamente!');
     return Redirect::to($url);
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
        //Funcion para autocompletado
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
