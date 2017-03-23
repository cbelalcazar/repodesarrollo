<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TOrigenMercancia;
use Illuminate\Support\Facades\Validator;
use Session;
use JsValidator;
use \Cache;


/**
 * @resource TOrigenMercanciaController
 *
 * Controlador creado para el crud de origen de la mercancia
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 22/02/2017
 */
class TOrigenMercanciaController extends Controller
{
  /**
  *DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */

  #Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "ORIGEN MERCANCÍA";

  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  *[4]-> Place holder que debe aparecer en el formulario
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion del origen de la mercancia', '');
  public $ormer_nombre = array('ormer_nombre', 'string', 'text', 'Descripcion del origen de la mercancia', '');
  public $ormer_requ_cert_origen = array('ormer_requ_cert_origen', 'boolean', 'checkbox', 'Requiere certificado de origen?', '');

  /**Strings urls
  *Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
  *la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
  * method GET|HEAD
  */
  public $strUrlConsulta = 'importacionesv2/OrigenMercancia';

  #Defino las reglas de validacion para el formulario
  public $rules = array(
    'ormer_nombre'       => 'required',
    );

  #Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'ormer_nombre.required'       => 'Favor ingresar el nombre del origen de la mercancia',
    );
  /**
  END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */


  /**
  * index
  * Funcion que consulta todos los origenes de la mercancia y los retorna a la vista resource/views/importacionesv2/index.blade.php
  *
  * 1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 2 -  Asigno variable $datos con la consulta de todos los registros de la tabla t_origen mercancia <br> 
  * 3 -  Asigno la variable $titulosTabla con un array donde cada posicion hace referencia a un titulo de columna de la tabla a mostrar, siempre al final le pongo las acciones editar y eliminar los demas campos son los mismos del array $campos <br>
  * 4 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en la tabla lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array <br>
  * 5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 
  * Return: retornar una vista con una lista de todas los origenes de la mercancia 
  * @return \Illuminate\Http\Response $titulo, $datos, $titulosTabla, $campos, $url
  */
  public function index()
  { 
    #1
    $titulo = $this->titulo;
    #2
    $datos = Cache::remember('origenmercancia', 60, function()
    {
      return TOrigenMercancia::all();
    });
    #3
    $titulosTabla =  array('Id', 'Descripcion', 'Requiere Certificado de Origen', 'Editar', 'Eliminar');
    #4
    $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);
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
  * 1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 2 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
  * 3 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 4 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador
  * 
  * Return: Debe retornar una vista con un formulario de creacion con los campos para la orden de importacion
  * @return \Illuminate\Http\Response titulo, campos, url, validator
  */
  public function create()
  {
    #1
    $titulo = "CREAR ".$this->titulo;
    #2
    $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);
    #3
    $url = url($this->strUrlConsulta);
    #4
    $validator = JsValidator::make($this->rules, $this->messages);
    return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
  }

  /**
  * store
  * Funcion que se encarga de guardar la informacion del formulario de creacion y redireccionar al index
  *
  * 1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 2 -  Valida que no exista ningun registro con el mismo ormer nombre en la tabla t_origen_mercancia, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
  * 3 -  Crea un registro en la tabla t_origen_mercancia <br>
  * 4 -  Borra la variable de cache <br>
  * 5 -  Redirecciona a la pagina de consulta y muestra un mensaje de exito <br>
  * 
  * Return: Debe retornar un mensaje de exito en caso de que se cree correctamente o un mensaje e error si encuentra un registro con el mismo ormer_nombre
  * @return \Illuminate\Http\Response message
  */
  public function store(Request $request)
  {
    #1
    $url = url($this->strUrlConsulta);
    #2
    $validarExistencia = TOrigenMercancia::where('ormer_nombre', '=', "$request->ormer_nombre")->get();
    if(count($validarExistencia) > 0){
      return redirect("$url/create")
      ->withErrors('El origen de la mercancia que intenta crear tiene el mismo nombre que un registro ya existente');
    }
    #3
    $ObjectCrear = new TOrigenMercancia;
    $ObjectCrear->ormer_nombre = strtoupper($request->ormer_nombre);
    if ($request->ormer_requ_cert_origen == 1){
      $ObjectCrear->ormer_requ_cert_origen = 1;
    }else{
      $ObjectCrear->ormer_requ_cert_origen = 0;
    }
    $ObjectCrear->save();
    #4
    Cache::forget('origenmercancia');
    #5
    Session::flash('message', 'Origen de la mercancia fue creada exitosamente!');
    return redirect($url);
  }

  /**
  * show
  * 
  * Funcion resource no usada
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    //

  }

/**
  * create
  * Funcion que muestra el formulario de editar resource/views/importacionesv2/edit.blade.php
  *
  * 1 -  Asigno la variable id con el parametro id del origen de la mercancia que deseo editar <br>
  * 2 -  Consulto el objeto que deseo editar <br>
  * 3 -  Creo un array donde cada posicion hace referencia a un campo de la tabla t_origen_mercancia, el cual quiero mostrar en el formulario de creacion. <br>
  * 4 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 6 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador <br>
  * 7 -  Asigno el string que hace referencia al name de la ruta update <br>
  * 
  * Return: Debe retornar una vista con un formulario para editar un registro de origen mercancia
  * @param $id
  * @return \Illuminate\Http\Response id, objeto, campos, titulo, url, validator, route
  */
public function edit($id)
{
    #1
  $id = $id;
    #2
  $objeto = TOrigenMercancia::find($id);
    #3
  $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);
    #4
  $titulo = "EDITAR ".$this->titulo;
    #5
  $url = url($this->strUrlConsulta);
    #6
  $validator = JsValidator::make($this->rules, $this->messages);
    #7
  $route = 'OrigenMercancia.update';

  return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
}

  /**
  * update
  * Funcion que edita el registro en la tabla origen mercancia
  *
  * 1 -  Asigna a la variable $url la url de consulta <br>
  * 2 -  Obtengo el objeto de origen mercancia que deseo editar <br>
  * 3 -  Consulto en la tabla t_origen_mercancia si existe algun registro con el mismo ormer nombre, en caso de encontrar alguno redirecciona a la funcion edit y retorna el error <br>
  * 4 -  Edita el registro de la tabla <br>
  * 5 -  Borra la cache del string origenmercancia <br>
  * 6 -  Redirecciona a vista de consulta <br>
  * 
  * Return: debe retornar exito en caso de haber hecho update sobre el registro, o error en caso de que el origen de la mercancia tenga el mismo ormer_nombre que otro
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    #1
    $url = url($this->strUrlConsulta);
    #2
    $ObjectUpdate = TOrigenMercancia::find($id);
    #3
    $validarExistencia = TOrigenMercancia::where('ormer_nombre', '=', "$request->ormer_nombre")->first();
    if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
      return redirect("$url/$id/edit")
      ->withErrors('El origen de la mercancia que intenta editar tiene el mismo nombre que un registro ya existente');
    }
    #4
    $ObjectUpdate->ormer_nombre = strtoupper($request->ormer_nombre);
    if ($request->ormer_requ_cert_origen == 1){
      $ObjectUpdate->ormer_requ_cert_origen = 1;
    }else{
      $ObjectUpdate->ormer_requ_cert_origen = 0;
    }
    $ObjectUpdate->save();
    #5
    Cache::forget('origenmercancia');
    #6
    Session::flash('message', 'Origen de la mercancia fue editado exitosamente!');
    return redirect($url);
  }

  /**
  * destroy
  * 
  * Hace un softdelete sobre el objeto de origen mercancia cuyo id coincida con el enviado a traves del parametro de la funcion
  * 
  * 1 -  Asigna el objeto de origen mercancia cuyo $id coincida con el enviado a traves del parametro de la funcion a la variable $ObjectDestroy  <br>
  * 2 -  Borra el objeto $ObjectDestroy <br>
  * 3 -  Asigna la url completa a la variable $url <br>
  * 4 -  Borra la cache del string origenmercancia <br>
  * 5 -  Redirecciona a la url <br>
  *
  * Return: Retorna mensaje de exito una ves elimina el origen de la mercancia
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    #1
    $ObjectDestroy = TOrigenMercancia::find($id);
    #2
    $ObjectDestroy->delete();
    #3
    $url = url($this->strUrlConsulta);
    #4
    Cache::forget('origenmercancia');
    #5
    Session::flash('message', 'El origen de la mercancia fue borrado exitosamente!');
    return redirect($url);

  }
  /** 
  END FUNCIONES RESOURCE
  */  
}