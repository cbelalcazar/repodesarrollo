<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TTipoCarga;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;
use \Cache;


/**
 * @resource TTipoCargaController
 *
 * Controlador creado para el crud de tipo de carga
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTipoCargaController extends Controller
{

  //---------------------------------------------------------------------------------------------------------
  //DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------
  // Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "TIPO DE CARGA";
  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  *[4]-> Placeholder que debe aparecer en el formulario
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion del tipo de carga', '');
  public $tcar_descripcion = array('tcar_descripcion', 'string', 'text', 'Descripcion del tipo de carga', 'Ingresar el tipo de carga');

  //Strings urls
  //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
  //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
  //** method GET|HEAD
  public $strUrlConsulta = 'importacionesv2/TipoCarga';

  //Defino las reglas de validacion para el formulario
  public $rules = array(
    'tcar_descripcion'         => 'required',
  );

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'tcar_descripcion.required'       => 'Favor ingresar el tipo de carga',
  );
  //---------------------------------------------------------------------------------------------------------
  //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------

  /**
  * index
  * 
  * Esta funcion debe retornar al usuario una vista de consulta de todos los tipos de carga existentes
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
    $datos = Cache::remember('tipocarga', 60, function()
    {
        return TTipoCarga::all();
    });

    /**
    *Variable titulosTabla debe contener un array con los titulos de la tabla.
    *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
    */
    $titulosTabla =  array('Id', 'Descripcion', 'Editar', 'Eliminar');

    /**
    *Campos con su tipo de dato.
    *Variable que debe contener los campos de la tabla con su nombre real.
    *De primero siempre debe ir el identificador de la tabla.
    */
    $campos =  array($this->id, $this->tcar_descripcion);

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
  * Esta funcion debe retornar al usuario un formulario de creacion para la tabla t_tipo_carga
  * 
  * Esta funcion debe poner en el formulario de creacion la funcion javascript de la libreria jsvalidator para hacer las validaciones a traves de ajax
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
    $campos =  array($this->id, $this->tcar_descripcion);
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
  * esta funcion recibe como parametro el request que tiene toda la informacion del formulario de creacion
  * 
  * debe validar que no exista ningun registro en la tabla t_tipo_carga con la misma tcar_descripcion
  * 
  * debe crear un registro en la tabla tcar_descripcion 
  * 
  * debe redireccionar a la funcion index y mostrar mensaje de exito
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //Genera la url de consulta
    $url = url($this->strUrlConsulta);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = TTipoCarga::where('tcar_descripcion', '=', "$request->tcar_descripcion")->get();
    if(count($validarExistencia) > 0){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return Redirect::to("$url/create")
      ->withErrors('El tipo de carga que intenta crear tiene la misma descripcion que un registro ya existente');
    }
    //Crea el registro en la tabla origen mercancia
    $ObjectCrear = new TTipoCarga;
    $ObjectCrear->tcar_descripcion = strtoupper(Input::get('tcar_descripcion'));
    $ObjectCrear->save();
    Cache::forget('tipocarga');
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'El tipo de carga fue creado exitosamente!');
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
  * esta funcion recibe como parametro el id del registro que deseo editar en la tabla t_tipo_carga
  * 
  * debe retornar al usuario un formulario para realizar la actualizacion de los datos de un registro de la tabla t_tipo_carga
  * 
  * 
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //Id del registro que deseamos editar
    $id = $id;
    //Consulto el registro que deseo editar
    $objeto = TTipoCarga::find($id);
    //organizo el array que me sirve para mostrar el formulario de edicion
    $campos =  array($this->id, $this->tcar_descripcion);
    //Titulo de la pagina
    $titulo = "EDITAR ".$this->titulo;
    //url de redireccion para consultar
    $url = url($this->strUrlConsulta);
    // Validaciones ajax
    $validator = JsValidator::make($this->rules, $this->messages);
    //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
    //correspondiente a este controlador
    $route = 'TipoCarga.update';

    return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
  }

  /**
  * update
  * 
  * esta funcion recibe como parametro el id del registro que deseo editar en la tabla t_tipo_carga
  * y el request con la informacion 
  * 
  * debe actualizar un registro en la tabla t_tipo_carga 
  * 
  * debe validar que no exista un registr con la misma tcar_descripcion
  * 
  * debe redireccionar a la funcion index y mostrar mensaje de actualizacion exitosa
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
    $ObjectUpdate = TTipoCarga::find($id);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = TTipoCarga::where('tcar_descripcion', '=', "$request->tcar_descripcion")->first();
    if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return Redirect::to("$url/$id/edit")
      ->withErrors('El tipo de carga que intenta editar tiene el mismo nombre que un registro ya existente');
    }
    //Edita el registro en la tabla
    $ObjectUpdate->tcar_descripcion = strtoupper(Input::get('tcar_descripcion'));
    $ObjectUpdate->save();
    Cache::forget('tipocarga');
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'El tipo de carga fue editado exitosamente!');
    return Redirect::to($url);
  }

  /**
  * destroy
  * 
  * esta funcion recibe como parametro el id de el registro que deseo eliminar de la tabla t_tipo_carga
  * 
  * debe borrar el registro usando softdeletes
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
          //Consulto objeto a borrar
          $ObjectDestroy = TTipoCarga::find($id);
          //Borro el objeto
          $ObjectDestroy->delete();
          //Obtengo url de redireccion
          $url = url($this->strUrlConsulta);
          //borro la cache del tipo de carga
          Cache::forget('tipocarga');
          // redirect
          Session::flash('message', 'El tipo de carga fue borrado exitosamente!');
          return Redirect::to($url);
  }
}
