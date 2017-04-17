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


/**
 * @resource TTipoLevanteController
 *
 * Controlador creado para el crud de producto
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 22/02/2017
 */
class TTipoLevanteController extends Controller
{
    #Variable titulo sirve para setear el titulo en el formulario generico
    public $titulo = "TIPO DE LEVANTE";

    /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
    *[0]-> Nombre del campo en la tabla de la base de datos
    *[1]-> Tipo de dato del campo en la tabla de la base de datos
    *[2]-> Elemento de html que puede representarlo en un formulario
    *[3]-> Label que debe aparecer el el formulario
    *[4]-> Place holder que debe aparecer en el formulario
    */
    public $id = array('id', 'int', 'hidden', 'Identificacion del tipo de levante', '');
    public $tlev_nombre = array('tlev_nombre', 'string', 'text', 'Descripcion del tipo de levante', 'Ingresar el nombre del tipo de levante:');

    #Strings urls
    #Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
    #la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
    //method GET|HEAD
    public $strUrlConsulta = 'importacionesv2/TipoLevante';

    #Defino las reglas de validacion para el formulario
    public $rules = array(
        'tlev_nombre'       => 'required',
        );

    #Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
        'tlev_nombre.required'       => 'Favor ingresar la descripcion del tipo de levante',
        );


  /**
  * index
  * Funcion que consulta todos los tipos de levante y los retorna a la vista resource/views/importacionesv2/index.blade.php
  *
  * 1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 2 -  Asigno variable $datos con la consulta de todos los registros de la tabla t_producto <br> 
  * 3 -  Asigno la variable $titulosTabla con un array donde cada posicion hace referencia a un titulo de columna de la tabla a mostrar, siempre al final le pongo las acciones editar y eliminar los demas campos son los mismos del array $campos <br>
  * 4 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en la tabla lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array <br>
  * 5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 
  * Return: retornar una vista con una lista de todas los productos 
  * @return \Illuminate\Http\Response $titulo, $datos, $titulosTabla, $campos, $url
  */
  public function index()
    {
        #1
        $titulo = $this->titulo;
        #2
        $datos = Cache::remember('tipolevante', 60, function()
        {
            return TTipoLevante::all();
        });
        #3 
        $titulosTabla =  array('Id', 'Descripcion',  'Editar', 'Eliminar');
        #4
        $campos =  array($this->id, $this->tlev_nombre);
        #5
        $url = url($this->strUrlConsulta);

        return view('importacionesv2.index', compact('titulo',
            'datos',
            'titulosTabla',
            'campos',
            'url'));
    }

/**
  * create
  * Funcion que muestra el formulario de creacion resource/views/importacionesv2/create.blade.php
  *
  * 1 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
  * 2 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 3 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 4 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador
  * 
  * Return: Debe retornar una vista con un formulario de creacion con los campos para productos
  * @return \Illuminate\Http\Response titulo, campos, url, validator
  */  
    public function create()
    {
        #1
        $campos =  array($this->id, $this->tlev_nombre);
        #2
        $url = url($this->strUrlConsulta);
        #3
        $titulo = "CREAR ".$this->titulo;
        #4
        $validator = JsValidator::make($this->rules, $this->messages);

        return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
    }

    /**
    * store 
    * 
    * Esta funcion debe validar que no exista un registro con el mismo nombre de tipo de levante, y validar la obligatoriedad de los campos 
    * y en caso de no encontrar ningun problema debe crear un nuevo tipo de levante en la tabla t_tipo_levante, luego redireccionar a la vista
    * de consulta y mostrar mensaje de exitoso.
    * 
    * 1 - Asigno a la variable url la ruta de la vista de consulta <br>
    * 2 - Asigno a la variable $validarExistencia la consulta a la tabla TTipoLevante donde el nombre del tipo de levante sea igual a uno ya 
    * existente <br>
    * 3 - Valido si la consulta trajo algun resultado, en caso de que si traiga resultado muestro mensaje de error <br>
    * 4 - Creo un objeto nuevo del tipo de levante <br>
    * 5 - Guardo la informacion que viene del formulario <br>
    * 6 - Borro la cache <br>
    * 7 - Genero mensaje de creacion exitosa y redirecciono a la vista de consulta <br>
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        #1
        $url = url($this->strUrlConsulta);
        #2
        $validarExistencia = TTipoLevante::where('tlev_nombre', '=', "$request->tlev_nombre")->get();
        #3
        if(count($validarExistencia) > 0){
            return Redirect::to("$url/create")
            ->withErrors('El tipo de levante que intenta crear tiene la misma descripcion que un registro ya existente');
        }
        #4
        $ObjectCrear = new TTipoLevante;
        $ObjectCrear->tlev_nombre = strtoupper(Input::get('tlev_nombre'));
        #5
        $ObjectCrear->save();
        #6
        Cache::forget('tipolevante');
        #7
        Session::flash('message', 'El tipo de levante fue creada exitosamente!');
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
    * Retorna al usuario una vista con un formulario para editar un tipo de levante /resource/views/importacionesv2/edit.blade.php
    * 
    * 1 - Obtengo el id del tipo de levante que viene como parametro de la funcion y lo asigno a la variable $id <br>
    * 2 - Obtengo el objeto del tipo de levante segun el id y lo asigno a la variable $objeto <br>
    * 3 - Creo un array de arrays llamado $campos con los campos que voy a hacer render en el formulario <br>
    * 4 - Asigno el titulo del formulario a la variable $titulo <br>
    * 5 - Asigno la ruta de consulta a la variable de $url <br>
    * 6 - Asigno la validacion javascript de la libreria JSVALIDATOR a la variable $validator <br>
    * 7 - Asigno el name de la ruta de update a la variabe $route <br>
    * 8 - Retorno la vista importacionesv2.edit <br>
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        #1
        $id = $id;
        #2
        $objeto = TTipoLevante::find($id);
        #3
        $campos =  array($this->id, $this->tlev_nombre);
        #4
        $titulo = "EDITAR ".$this->titulo;
        #5
        $url = url($this->strUrlConsulta);
        #6
        $validator = JsValidator::make($this->rules, $this->messages);
        #7
        $route = 'TipoLevante.update';
        #8
        return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
    }

    /**
    * update
    * 
    * Su funcionalidad que actualizar un registro de la tabla t_tipo levante segun el id que se le entrege como parametro
    * 
    * 1 -  Asigna a la variable $url la ruta de consulta que apunta hacia el index de este crud <br>
    * 2 -  Obtiene el objeto de la tabla t_tipo_levante y lo asigna a la variable $ObjectUpdate <br>
    * 3 -  Valida que no exista otro registro con el mismo tlev_nombre, si existe alguno genera error y no permite editar el registro <br>
    * 4 -  Si no existe ningun registro igual actualiza los campos y graba <br>
    * 5 -  Borra la cache de esta tabla <br>
    * 6 -  Redirecciona a la url de consulta con mensaje de exito <br>
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        #1
        $url = url($this->strUrlConsulta);
        #2
        $ObjectUpdate = TTipoLevante::find($id);
        #3
        $validarExistencia = TTipoLevante::where('tlev_nombre', '=', "$request->tlev_nombre")->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
            return Redirect::to("$url/$id/edit")
            ->withErrors('El tipo de levante que intenta editar tiene el mismo nombre que un registro ya existente');
        }
        #4
        $ObjectUpdate->tlev_nombre = strtoupper(Input::get('tlev_nombre'));
        $ObjectUpdate->save();
        #5
        Cache::forget('tipolevante');
        #6
        Session::flash('message', 'El tipo de levante fue editado exitosamente!');
        return Redirect::to($url);
    }

    /**
    * destroy
    * 
    * Su funcionalidad es borrar un registro de la tabla t_tipo_levante segun el id que le pases a la funcion
    * 
    * 1 -  Asigno a la variable $ObjectDestroy el objeto que deseo eliminar <br>
    * 2 -  Borro el objeto <br>
    * 3 -  Obtengo la url de consuta de tipo levante <br>
    * 4 -  Borro la cache <br>
    * 5 -  redirecciono a la vista de consulta <br>
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        #1
        $ObjectDestroy = TTipoLevante::find($id);
        #2
        $ObjectDestroy->delete();
        #3
        $url = url($this->strUrlConsulta);
        #4
        Cache::forget('tipolevante');
        #5
        Session::flash('message', 'El tipo de levante fue borrado exitosamente!');
        return Redirect::to($url);
    }
}
