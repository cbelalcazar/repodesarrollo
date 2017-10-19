<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TTipoImportacion;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;
use \Cache;


/**
 * @resource TTipoImportacionController
 *
 * Controlador creado para el crud de tipo importacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTipoImportacionController extends Controller
{
    //---------------------------------------------------------------------------------------------------------
    //DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------
    // Variable titulo sirve para setear el titulo en el formulario generico
    public $titulo = "TIPO DE IMPORTACION";
    /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
    *[0]-> Nombre del campo en la tabla de la base de datos
    *[1]-> Tipo de dato del campo en la tabla de la base de datos
    *[2]-> Elemento de html que puede representarlo en un formulario
    *[3]-> Label que debe aparecer el el formulario
    *[4]-> Place holder que debe aparecer en el formulario
    */
    public $id = array('id', 'int', 'hidden', 'Identificacion del tipo de importacion', '');
    public $timp_nombre = array('timp_nombre', 'string', 'text', 'Descripcion del tipo de importacion', 'Ingresar el nombre del tipo de importacion:');

    //Strings urls
    //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
    //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
    //** method GET|HEAD
    public $strUrlConsulta = 'importacionesv2/TipoImportacion';

    //Defino las reglas de validacion para el formulario
    public $rules = array(
        'timp_nombre'       => 'required',
    );

    //Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
        'timp_nombre.required'       => 'Favor ingresar la descripcion del tipo de importacion',
    );
    //---------------------------------------------------------------------------------------------------------
    //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------


    /**
    * index
    * 
    * retorna al usuario un formulario con todos los tipos de imporacion existentes
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
        $datos = Cache::remember('tipoimportacion', 60, function()
        {
            return TTipoImportacion::all();
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
        $campos =  array($this->id, $this->timp_nombre);

        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);

        return view('importacionesv2.index', compact('titulo',
        'datos',
        'titulosTabla',
        'campos',
        'url'));
    }

    /**
    * create
    * 
    * debe retornar al usuario un formulario de creacion para la tabla t_tipo_importacion
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
        $campos =  array($this->id, $this->timp_nombre);
        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);
        //Variable que contiene el titulo de la vista crear
        $titulo = "CREAR ".$this->titulo;
        //Libreria de validaciones con ajax
        $validator = JsValidator::make($this->rules, $this->messages);

        return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
    }

    /**
    * store
    * 
    * recibe como parametro el request con la informacion del formulario de creacion
    * 
    * debe validar que no exista un registro en la tabla t_tipo_importacion con el mismo timp_nombre
    * 
    * debe crear un registro en la tabla t_tipo_importacion
    * 
    * debe redireccionar a la funcion del index con un mensaje de creacion exitosa
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //Genera la url de consulta
        $url = url($this->strUrlConsulta);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TTipoImportacion::where('timp_nombre', '=', "$request->timp_nombre")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/create")
            ->withErrors('El tipo de importacion que intenta crear tiene la misma descripcion que un registro ya existente');
        }
        //Crea el registro en la tabla origen mercancia
        $ObjectCrear = new TTipoImportacion;
        $ObjectCrear->timp_nombre = strtoupper(Input::get('timp_nombre'));
        $ObjectCrear->save();
        Cache::forget('tipoimportacion');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El tipo de importacion fue creada exitosamente!');
        return Redirect::to($url);
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
    * Recibe como parametro el id del tipo de importacion que desea actualizar
    * 
    * debe retornar al usuario un formulario de actualizacion del registro con el id correspondiente
    * 
    * debe imprimir la funcion javascript de la libreria jsvalidator en el formulario para hacer las validaciones ajax 
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //Id del registro que deseamos editar
        $id = $id;
        //Consulto el registro que deseo editar
        $objeto = TTipoImportacion::find($id);
        //organizo el array que me sirve para mostrar el formulario de edicion
        $campos =  array($this->id, $this->timp_nombre);
        //Titulo de la pagina
        $titulo = "EDITAR ".$this->titulo;
        //url de redireccion para consultar
        $url = url($this->strUrlConsulta);
        // Validaciones ajax
        $validator = JsValidator::make($this->rules, $this->messages);
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'TipoImportacion.update';

        return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
    }

    /**
    * update
    * 
    * esta funcion  recibe como parametro el request con toda la informacion del formulario de actualizacion
    * 
    * debe validar que no exista ningun registro con el mismo timp_nombre
    * 
    * debe actualizar un registro en la tabla t_tipo_importacion 
    * 
    * debe redireccionar a la funcion index y mostrar un mensaje de actualizacion exitosa
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
        $ObjectUpdate = TTipoImportacion::find($id);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TTipoImportacion::where('timp_nombre', '=', "$request->timp_nombre")->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/$id/edit")
            ->withErrors('El tipo de importacion que intenta editar tiene el mismo nombre que un registro ya existente');
        }
        //Edita el registro en la tabla
        $ObjectUpdate->timp_nombre = strtoupper(Input::get('timp_nombre'));
        $ObjectUpdate->save();
        Cache::forget('tipoimportacion');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El tipo de importacion fue editado exitosamente!');
        return Redirect::to($url);
    }

    /**
    * destroy
    * 
    * Esta funcion recibe como parametro el id de el registro de la tabla t_tipo_impórtacion que deseo eliminar
    * 
    * debe eliminar el registro usando softdelete
    * 
    * debe redireccionar a la funcion index con mensaje de borrado exitoso
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //Consulto objeto a borrar
        $ObjectDestroy = TTipoImportacion::find($id);
        //Borro el objeto
        $ObjectDestroy->delete();
        //Obtengo url de redireccion
        $url = url($this->strUrlConsulta);
        Cache::forget('tipoimportacion');
        // redirect
        Session::flash('message', 'El tipo de importacion fue borrado exitosamente!');
        return Redirect::to($url);
    }
}