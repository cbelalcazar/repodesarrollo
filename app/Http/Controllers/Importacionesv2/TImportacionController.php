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
use App\Models\Importacionesv2\TPuertoEmbarque;
use App\Models\Importacionesv2\TIconterm;
use App\Models\Importacionesv2\TImportacion;

class TImportacionController extends Controller
{

    //Defino las reglas de validacion para el formulario
    public $rules = array();

    //Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array();
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

        $combos = $this->consultas();
        extract($combos);
        $usuario = Auth::user();
        $imp_consecutivo = 


        return view('importacionesv2.ImportacionTemplate.createImportacion', 
            compact('titulo',
                    'url',  
                    'validator', 
                    'puertos', 
                    'inconterm',
                    'moneda'));
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

    public function consultas(){

        $combos = array();
        // Combobox puertos
        $array = Cache::remember('puertoembarque', 60, function() {return TPuertoEmbarque::all();});
        $puertos = array();
        foreach ($array as $key => $value) {$puertos["$value->id"] = $value->puem_nombre;}
        $combos['puertos'] = $puertos;
        //end Combobox puertos
        // Combobox inconterm
        $array = Cache::remember('inconterm', 60, function(){return TIconterm::all();});
        $inconterm = array();
        foreach ($array as $key => $value) {$inconterm["$value->id"] = $value->inco_descripcion;}
        $combos['inconterm'] = $inconterm;
        //end Combobox puertos
        // Combobox monedas
        $array = Cache::remember('moneda', 60, function(){return DB::connection('besa')->table('9000-appweb_monedas_ERP')->get();});
        $moneda = array();
        foreach ($array as $key => $value) {$moneda["$value->id_moneda"] = $value->desc_moneda;}
        $combos['moneda'] = $moneda;
        //end Combobox puertos

        return $combos;
    }
}
