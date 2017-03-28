<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TProducto;
use App\Models\Genericas\Item;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;


/**
 * @resource TProductoController
 *
 * Controlador creado para el crud de producto
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 22/02/2017
 */
class TProductoController extends Controller
{
  /**
  *DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */

  #Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "PRODUCTO";

  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  *[4]-> Place holder que debe aparecer en el formulario
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion del producto', '');
  public $prod_referencia = array('prod_referencia', 'string', 'text', 'Descripcion del origen de la mercancia', '');
  public $prod_req_declaracion_anticipado = array('prod_req_declaracion_anticipado', 'boolean', 'checkbox', 'Requiere declaracion anticipada', '','','');
  public $prod_req_registro_importacion = array('prod_req_registro_importacion', 'boolean', 'checkbox', 'Requiere registro de importacion', '','','');

  #Strings urls
  #Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
  #la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
  #method GET|HEAD
  public $strUrlConsulta = 'importacionesv2/Producto';

  #Defino las reglas de validacion para el formulario
  public $rules = array(
    'prod_referencia'       => 'required',
    );

  #Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'prod_referencia.required'       => 'Favor seleccionar la referencia del producto',
    );

   /**
  END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */

  /**
  * index
  * Funcion que consulta todos los origenes de la mercancia y los retorna a la vista resource/views/importacionesv2/index.blade.php
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
    $datos = TProducto::all();
    #3
    $titulosTabla =  array('Id', 'Descripcion', 'Requiere declaracion anticipada','Requiere registro de importacion', 'Editar', 'Eliminar');
    #4
    $campos =  array($this->id, $this->prod_referencia, $this->prod_req_declaracion_anticipado, $this->prod_req_registro_importacion);
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
    $campos =  array($this->id, $this->prod_referencia, $this->prod_req_declaracion_anticipado, $this->prod_req_registro_importacion);
    #2
    $url = url($this->strUrlConsulta);
    #3
    $titulo = "CREAR ".$this->titulo;
    #4
    $validator = JsValidator::make($this->rules, $this->messages);

    return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
  }

  /**
  * Productoajax
  * Funcion que muestra el formulario de creacion cargado a traves de ajax en un modal de la vista de create importacion
  *
  * 1 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en el formulario lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array y crear solo una vista <br>
  * 2 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 3 -  Asigno a la variable $route la ruta de la funcion que recibe la peticion ajax de creacion <br>
  * 4 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 5 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador
  * 
  * Return: Debe retornar una vista con un formulario de creacion con los campos para productos en resource/views/importacioensv2/ImportacionTemplate/createajax
  * @return \Illuminate\Http\Response titulo, campos, url, validator
  */
  public function Productoajax()
  {
    #1
    $campos =  array($this->id, $this->prod_referencia, $this->prod_req_declaracion_anticipado, $this->prod_req_registro_importacion);
    #2
    $url = url($this->strUrlConsulta);
    #3
    $route = route('storeajaxproducto');
    #4
    $titulo = "CREAR ".$this->titulo;
    #5
    $validator = JsValidator::make($this->rules, $this->messages);

    return view('importacionesv2.ImportacionTemplate.createajax', compact('titulo','campos' ,'url', 'validator', 'route'));

  }


 /**
  * store
  * Funcion que se encarga de guardar la informacion del formulario de creacion y redireccionar al index
  *
  * 1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 2 -  Valida que no exista ningun registro con el mismo prod_referencia en la tabla t_producto, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
  * 3 -  Crea un registro en la tabla t_producto <br>
  * 4 -  Redirecciona a la pagina de consulta y muestra un mensaje de exito <br>
  * 
  * Return: Debe retornar un mensaje de exito en caso de que se cree correctamente o un mensaje e error si encuentra un registro con el mismo prod_referencia
  * @return \Illuminate\Http\Response message
  */
 public function store(Request $request)
 {       
      #1
  $url = url($this->strUrlConsulta);
      #2
  $validarExistencia = TProducto::where('prod_referencia', '=', "$request->prod_referencia")->get();
  if(count($validarExistencia) > 0){
        //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
    return Redirect::to("$url/create")
    ->withErrors('El producto que intenta crear tiene el mismo nombre que un registro ya existente');
  }
      #3
  $ObjectCrear = new TProducto;
  $ObjectCrear->prod_referencia = strtoupper(Input::get('prod_referencia'));
  ($request->prod_req_declaracion_anticipado == 1) ? $ObjectCrear->prod_req_declaracion_anticipado = 1 : $ObjectCrear->prod_req_declaracion_anticipado = 0;
  ($request->prod_req_registro_importacion == 1) ? $ObjectCrear->prod_req_registro_importacion = 1 : $ObjectCrear->prod_req_registro_importacion = 0;  
  $ObjectCrear->save();
      #4
  Session::flash('message', 'El producto fue creado exitosamente!');
  return Redirect::to($url);
}



  /**
  * storeAjax
  * Funcion que se encarga de guardar la informacion del formulario de creacion por una peticion ajax y redireccionar al index
  *
  * 1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 2 -  Valida que no exista ningun registro con el mismo prod_referencia en la tabla t_producto, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
  * 3 -  Verifica el request con respecto a las reglas de validacion, en caso de encontrar algun error lo retorna
  * 4 -  Crea el objeto producto con la informacion
  * 
  * Return: retorna un array() con la info del producto y success1
  * @return \Illuminate\Http\Response message
  */
  public function storeAjax(Request $request)
  {
    #1
    $url = url($this->strUrlConsulta);
    #2
    $validarExistencia = TProducto::where('prod_referencia', '=', "$request->prod_referencia")->get();
    if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
     return array('error', 'Ya existe un producto con la misma descripción', '');
   }
    #3
   $validator = Validator::make(Input::all(), $this->rules, $this->messages);
   if ($validator->fails()) {
     return array('error', 'Favor validar la integridad de los campos', '');
   }else {
     #4
     $ObjectCrear = new TProducto;
     $ObjectCrear->prod_referencia = strtoupper(Input::get('prod_referencia'));

      if ($request->prod_req_declaracion_anticipado == 1){
        $ObjectCrear->prod_req_declaracion_anticipado = 1;
      }else{
        $ObjectCrear->prod_req_declaracion_anticipado = 0;
      }

      if ($request->prod_req_registro_importacion == 1){
        $ObjectCrear->prod_req_registro_importacion = 1;
      }else{
        $ObjectCrear->prod_req_registro_importacion = 0;
      }
    $ObjectCrear->save();
    #5
    return array('success1', $ObjectCrear->id, $ObjectCrear->prod_referencia, $ObjectCrear->prod_req_declaracion_anticipado , $ObjectCrear->prod_req_registro_importacion);
  }
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
  * edit
  * Funcion que muestra el formulario de editar resource/views/importacionesv2/edit.blade.php
  *
  * 1 -  Asigno la variable id con el parametro id del modelo que deseo editar <br>
  * 2 -  Consulto el objeto que deseo editar <br>
  * 3 -  Creo un array donde cada posicion hace referencia a un campo de la tabla t_producto, el cual quiero mostrar en el formulario de creacion. <br>
  * 4 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 6 -  Asigno la variable $validator la cual va a contener un script javascript que voy a pintar en la vista para realizar las rules de validacion que defino en el controlador <br>
  * 7 -  Asigno el string que hace referencia al name de la ruta update <br>
  * 
  * Return: Debe retornar una vista con un formulario para editar un registro 
  * @param $id
  * @return \Illuminate\Http\Response id, objeto, campos, titulo, url, validator, route
  */
  public function edit($id)
  {
    #1
    $id = $id;
    #2
    $objeto = TProducto::find($id);
    #3
    $campos =  array($this->id, $this->prod_referencia, $this->prod_req_declaracion_anticipado, $this->prod_req_registro_importacion);
    #4
    $titulo = "EDITAR ".$this->titulo;
    #5
    $url = url($this->strUrlConsulta);
    #6
    $validator = JsValidator::make($this->rules, $this->messages);
    #7
    $route = 'Producto.update';

    return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
  }

  /**
  * update
  * Funcion que actualiza el registro en la tabla origen mercancia
  *
  * 1 -  Asigna a la variable $url la url de consulta <br>
  * 2 -  Obtengo el objeto que deseo editar <br>
  * 3 -  Consulto en la tabla si existe algun registro con el mismo prod_referencia, en caso de encontrar alguno redirecciona a la funcion edit y retorna el error <br>
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
    $ObjectUpdate = TProducto::find($id);
    #3
    $validarExistencia = TProducto::where('prod_referencia', '=', "$request->prod_referencia")->first();
    if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
      return Redirect::to("$url/$id/edit")
      ->withErrors('El producto que intenta editar tiene el mismo nombre que un registro ya existente');
    }
    #4
    $ObjectUpdate->prod_referencia = strtoupper(Input::get('prod_referencia'));

    if ($request->prod_req_declaracion_anticipado == 1){
      $ObjectUpdate->prod_req_declaracion_anticipado = 1;
    }else{
      $ObjectUpdate->prod_req_declaracion_anticipado = 0;
    }

    if ($request->prod_req_registro_importacion == 1){
      $ObjectUpdate->prod_req_registro_importacion = 1;
    }else{
      $ObjectUpdate->prod_req_registro_importacion = 0;
    }
    $ObjectUpdate->save();
    #6
    Session::flash('message', 'El producto fue editado exitosamente!');
    return Redirect::to($url);
  }


 /**
  * destroy
  * 
  * Hace un softdelete sobre el objeto de cuyo id coincida con el enviado a traves del parametro de la funcion
  * 
  * 1 -  Asigna el objeto cuyo $id coincida con el enviado a traves del parametro de la funcion a la variable $ObjectDestroy  <br>
  * 2 -  Borra el objeto $ObjectDestroy <br>
  * 3 -  Asigna la url completa a la variable $url <br>
  * 4 -  Borra la cache del string <br>
  * 5 -  Redirecciona a la url <br>
  *
  * Return: Retorna mensaje de exito una ves elimina el origen de la mercancia
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    #1
    $ObjectDestroy = TProducto::find($id);
    #2
    $ObjectDestroy->delete();
    #3
    $url = url($this->strUrlConsulta);
    #4
    Session::flash('message', 'El producto fue borrado exitosamente!');
    return Redirect::to($url);
  }
}
