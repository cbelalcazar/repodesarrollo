<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TTipoLevante;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;
use \Cache;

class TTipoLevanteController extends Controller
{

    //---------------------------------------------------------------------------------------------------------
    //DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------
    // Variable titulo sirve para setear el titulo en el formulario generico
    public $titulo = "TIPO DE LEVANTE";
    /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
    *[0]-> Nombre del campo en la tabla de la base de datos
    *[1]-> Tipo de dato del campo en la tabla de la base de datos
    *[2]-> Elemento de html que puede representarlo en un formulario
    *[3]-> Label que debe aparecer el el formulario
    *[4]-> Place holder que debe aparecer en el formulario
    */
    public $id = array('id', 'int', 'hidden', 'Identificacion del tipo de importacion', '');
    public $tlev_nombre = array('tlev_nombre', 'string', 'text', 'Descripcion del tipo de levante', 'Ingresar el nombre del tipo de levante:');

    //Strings urls
    //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
    //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
    //** method GET|HEAD
    public $strUrlConsulta = 'importacionesv2/TipoLevante';

    //Defino las reglas de validacion para el formulario
    public $rules = array(
        'tlev_nombre'       => 'required',
    );

    //Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
        'tlev_nombre.required'       => 'Favor ingresar la descripcion del tipo de levante',
    );
    //---------------------------------------------------------------------------------------------------------
    //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------


    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //Seteo el titulo en la funcion para mostrar en la vista index
        $titulo = $this->titulo;

        /**
        *Variable datos debe contener la informacion que se quiere mostrar en el formulario generico.
        */
        $datos = Cache::remember('tipolevante', 60, function()
        {
            return TTipoLevante::all();
        });

        /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
        $titulosTabla =  array('Id', 'Descripcion',  'Editar', 'Eliminar');

        /**
        *Campos con su tipo de dato.
        *Variable que debe contener los campos de la tabla con su nombre real.
        *De primero siempre debe ir el identificador de la tabla.
        */
        $campos =  array($this->id, $this->tlev_nombre);

        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);

        return view('importacionesv2.index', compact('titulo',
        'datos',
        'titulosTabla',
        'campos',
        'url'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
        $campos =  array($this->id, $this->tlev_nombre);
        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);
        //Variable que contiene el titulo de la vista crear
        $titulo = "CREAR ".$this->titulo;
        //Libreria de validaciones con ajax
        $validator = JsValidator::make($this->rules, $this->messages);

        return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
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
        $url = url($this->strUrlConsulta);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TTipoLevante::where('tlev_nombre', '=', "$request->tlev_nombre")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/create")
            ->withErrors('El tipo de levante que intenta crear tiene la misma descripcion que un registro ya existente');
        }
        //Crea el registro en la tabla origen mercancia
        $ObjectCrear = new TTipoLevante;
        $ObjectCrear->tlev_nombre = strtoupper(Input::get('tlev_nombre'));
        $ObjectCrear->save();
        Cache::forget('tipolevante');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El tipo de levante fue creada exitosamente!');
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
        //Id del registro que deseamos editar
        $id = $id;
        //Consulto el registro que deseo editar
        $objeto = TTipoLevante::find($id);
        //organizo el array que me sirve para mostrar el formulario de edicion
        $campos =  array($this->id, $this->tlev_nombre);
        //Titulo de la pagina
        $titulo = "EDITAR ".$this->titulo;
        //url de redireccion para consultar
        $url = url($this->strUrlConsulta);
        // Validaciones ajax
        $validator = JsValidator::make($this->rules, $this->messages);
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'TipoLevante.update';

        return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
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
        $url = url($this->strUrlConsulta);
        //Consulto el registro a editar
        $ObjectUpdate = TTipoLevante::find($id);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TTipoLevante::where('tlev_nombre', '=', "$request->tlev_nombre")->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/$id/edit")
            ->withErrors('El tipo de importacion que intenta editar tiene el mismo nombre que un registro ya existente');
        }
        //Edita el registro en la tabla
        $ObjectUpdate->tlev_nombre = strtoupper(Input::get('tlev_nombre'));
        $ObjectUpdate->save();
        Cache::forget('tipolevante');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El tipo de levante fue editado exitosamente!');
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
        //Consulto objeto a borrar
        $ObjectDestroy = TTipoLevante::find($id);
        //Borro el objeto
        $ObjectDestroy->delete();
        //Obtengo url de redireccion
        $url = url($this->strUrlConsulta);
        Cache::forget('tipolevante');
        // redirect
        Session::flash('message', 'El tipo de importacion fue borrado exitosamente!');
        return Redirect::to($url);
    }
}
