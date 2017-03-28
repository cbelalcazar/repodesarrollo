<?php


namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TLineaMaritima;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;
use \Cache;


/**
 * @resource TLineaMaritimaController
 *
 * Controlador creado para el crud de linea maritima
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 27/03/2017
 */
class TLineaMaritimaController extends Controller
{

  /**
  *DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */

  #Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "LINEA MARITIMA";
    /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
    *[0]-> Nombre del campo en la tabla de la base de datos
    *[1]-> Tipo de dato del campo en la tabla de la base de datos
    *[2]-> Elemento de html que puede representarlo en un formulario
    *[3]-> Label que debe aparecer el el formulario
    *[4]-> Place holder que debe aparecer en el formulario
    */
    public $id = array('id', 'int', 'hidden', 'Identificacion de la linea maritima', '');
    public $lmar_descripcion = array('lmar_descripcion', 'string', 'text', 'Descripcion de la linea maritima', 'Ingresar el nombre de la linea maritima:');

    #Strings urls
    #Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
    #la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
    //method GET|HEAD
    public $strUrlConsulta = 'importacionesv2/LineaMaritima';

    #Defino las reglas de validacion para el formulario
    public $rules = array(
        'lmar_descripcion'       => 'required',
        );

    #Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
        'lmar_descripcion.required'       => 'Favor ingresar la descripcion de la linea maritima',
        );
    /**
  END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  */

  /**
  * index
  * Funcion que consulta todos las lineas maritimas y los retorna a la vista resource/views/importacionesv2/index.blade.php
  *
  * 1 -  Asigno la variable $titulo con que se definio en la variable global titulo <br>
  * 2 -  Asigno variable $datos con la consulta de todos los registros de la tabla t_linea_maritima <br> 
  * 3 -  Asigno la variable $titulosTabla con un array donde cada posicion hace referencia a un titulo de columna de la tabla a mostrar, siempre al final le pongo las acciones editar y eliminar los demas campos son los mismos del array $campos <br>
  * 4 -  Asigno la variable campos con un array de arrays cada array contenido en cada posicion debe tener informacion del campo de la base de datos que quiero mostrar en la tabla lo realizo para que la vista ejecute la accion de mostrar solo los campos que yo le indico en este array <br>
  * 5 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 
  * Return: retornar una vista con una lista de todas las lineas maritimas 
  * @return \Illuminate\Http\Response $titulo, $datos, $titulosTabla, $campos, $url
  */
  public function index()
  {
        #1
    $titulo = $this->titulo;
        #2
    $datos = Cache::remember('lineamaritima', 60, function()
    {
        return TLineaMaritima::all();
    });
        #3 
    $titulosTabla =  array('Id', 'Descripcion',  'Editar', 'Eliminar');
        #4
    $campos =  array($this->id, $this->lmar_descripcion);
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
  * Return: Debe retornar una vista con un formulario de creacion con los campos para linea maritima
  * @return \Illuminate\Http\Response titulo, campos, url, validator
  */
public function create()
{
    #1
    $campos =  array($this->id, $this->lmar_descripcion);
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
  * Funcion que se encarga de guardar la informacion del formulario de creacion y redireccionar al index
  *
  * 1 -  Asigno la variable $url la cual tiene ulr completa de consulta <br>
  * 2 -  Valida que no exista ningun registro con el mismo lmar_descripcion en la tabla t_linea_maritima, en caso de encontrar alguno retorna error a la vista create.blade.php <br>
  * 3 -  Crea un registro en la tabla t_linea_maritima <br>
  * 4 -  Redirecciona a la pagina de consulta y muestra un mensaje de exito <br>
  * 
  * Return: Debe retornar un mensaje de exito en caso de que se cree correctamente o un mensaje e error si encuentra un registro con el mismo lmar_descripcion
  * @return \Illuminate\Http\Response message
  */
    public function store(Request $request)
    {

      #1
      $url = url($this->strUrlConsulta);
      #2
      $validarExistencia = TLineaMaritima::where('lmar_descripcion', '=', "$request->lmar_descripcion")->get();
      if(count($validarExistencia) > 0){
        return Redirect::to("$url/create")
        ->withErrors('La linea maritima que intenta crear tiene el mismo nombre que un registro ya existente');
    }
      #3
    $ObjectCrear = new TLineaMaritima;
    $ObjectCrear->lmar_descripcion = strtoupper($request->lmar_descripcion);
    $ObjectCrear->save();

    Cache::forget('lineamaritima');
      #4
    Session::flash('message', 'La linea maritima fue creada exitosamente!');
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
    $objeto = TLineaMaritima::find($id);
    #3
    $campos =  array($this->id, $this->lmar_descripcion);
    #4
    $titulo = "EDITAR ".$this->titulo;
    #5
    $url = url($this->strUrlConsulta);
    #6
    $validator = JsValidator::make($this->rules, $this->messages);
    #7
    $route = 'LineaMaritima.update';
    return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
}

    /**
  * update
  * Funcion que actualiza el registro en la tabla linea maritima
  *
  * 1 -  Asigna a la variable $url la url de consulta <br>
  * 2 -  Obtengo el objeto que deseo editar <br>
  * 3 -  Consulto en la tabla si existe algun registro con el mismo lmar_descripcion, en caso de encontrar alguno redirecciona a la funcion edit y retorna el error <br>
  * 4 -  Edita el registro de la tabla <br>
  * 5 -  Borra la cache del string <br>
  * 6 -  Redirecciona a vista de consulta <br>
  * 
  * Return: debe retornar exito en caso de haber hecho update sobre el registro, o error en caso de que la linea maritima tenga el mismo lmar_descripcion que otro
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
    public function update(Request $request, $id)
    {
        #1
        $url = url($this->strUrlConsulta);
        #2
        $ObjectUpdate = TLineaMaritima::find($id);
        #3
        $validarExistencia = TLineaMaritima::where('lmar_descripcion', '=', "$request->lmar_descripcion")->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
          return Redirect::to("$url/$id/edit")
          ->withErrors('La linea maritima que intenta editar tiene el mismo nombre que un registro ya existente');
      }
        #4
      $ObjectUpdate->lmar_descripcion = strtoupper($request->lmar_descripcion);
      $ObjectUpdate->save();
        #5
      Cache::forget('lineamaritima');
        #6
      Session::flash('message', 'La linea maritima fue editada exitosamente!');
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
        $ObjectDestroy = TLineaMaritima::find($id);
        #2
        $ObjectDestroy->delete();
        #3
        $url = url($this->strUrlConsulta);
        #4
        Cache::forget('lineamaritima');
        #5
        Session::flash('message', 'La linea maritima fue borrado exitosamente!');
        return Redirect::to($url);
    }
}
