<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TCausalesDemora;
use App\Models\Importacionesv2\TMetrica;
use Session;
use JsValidator;
use \Cache;

/**
 * @resource TCausalesDemoraController
 *
 * Controlador creado para generar crud de causales demora
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 21/04/2017
 */
class TCausalesDemoraController extends Controller
{

  //---------------------------------------------------------------------------------------------------------
  //DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------
  // Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "CAUSALES DEMORA";
  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  *[4]-> Placeholder que debe aparecer en el formulario
  *[5]-> Consulta para llenar combobox si es el caso - se setea en la funcion respectiva debe siempre declararse vacia ('') si no se compone array('nombre de la relacion', 'nombre del campo')
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion la metrica', '','');
  public $cdem_nombre = array('cdem_nombre', 'string', 'text', 'Descripcion de la causal de demora', 'Ingresar la descripcion de la causal de demora','','');
  public $cdem_metrica = array('cdem_metrica', 'relation', 'select', 'Seleccionar metrica', 'Seleccionar la metrica deseada...','',array('metricas','met_nombre'));

  //Strings urls
  //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
  //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
  //** method GET|HEAD
  public $strUrlConsulta = 'importacionesv2/CausalesDemora';

  //Defino las reglas de validacion para el formulario
  public $rules = array(
    'cdem_nombre'         => 'required',
    'cdem_metrica'    => 'required',
  );

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'cdem_nombre.required'       => 'Favor ingresar la descripcion de la causal de demora',
    'cdem_metrica.required'       => 'Favor seleccionar la metrica',
  );
  //---------------------------------------------------------------------------------------------------------
  //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------


  /**
  * index
  * 
  * Retorna al usuario un formulario con la tabla que muestra todos los causales de demora existentes
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
    $datos = Cache::remember('causalesDemora', 60, function() {
      return TCausalesDemora::with(array('metricas' => function($query) {
        $query->withTrashed();
      }))->get();
    });

    /**
    *Variable titulosTabla debe contener un array con los titulos de la tabla.
    *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
    */
    $titulosTabla =  array('Id', 'Descripcion', 'Metrica',  'Editar', 'Eliminar');

    /**
    *Campos con su tipo de dato.
    *Variable que debe contener los campos de la tabla con su nombre real.
    *De primero siempre debe ir el identificador de la tabla.
    */
    $campos = $this->arrayCampos();

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
  * Retorna al usuario un formulario para la creacion de un registro en la tabla t_causales_demora
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //Proceso para generar la informacion para llenar el combobox
    $this->suministrarInfoCombobox();
    //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
    $campos =  $this->arrayCampos();
    //Genera url completa de consulta
    $url = url($this->strUrlConsulta);
    //Variable que contiene el titulo de la vista crear
    $titulo = "CREAR ".$this->titulo;
    //Libreria de validaciones con ajax
    $validator = $this->jsValidator();

    return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));
  }

  /**
  * store
  * 
  * Recibe la informacion del formulario de creacion y valida que no exista una causal de demora con el mismo nombre de la que intenta crea, posteriormente si no existe ninguna, crea un registro nuevo en la tabla t_causales_demora
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //Genera la url de consulta
    $url = url($this->strUrlConsulta);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = $this->validarExistencia($request->cdem_nombre);
    if(count($validarExistencia) > 0){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return redirect("$url/create")
      ->withErrors('La causal de demora que intenta crear tiene la misma descripcion que un registro ya existente');
    }
    //Crea el registro en la tabla origen mercancia
    $ObjectCrear = new TCausalesDemora;
    $this->storeOrUpdateAnObject($ObjectCrear, $request);
    Cache::forget('causalesDemora');
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'La causal de demora fue creada exitosamente!');
    return redirect($url);
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
  * Retorna al usuario un formulario para editar un registro de la tabla t_causales_demora.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    //Id del registro que deseamos editar
    $id = $id;
    //Consulto el registro que deseo editar
    $objeto = TCausalesDemora::find($id);
    //Proceso para generar la informacion para llenar el combobox
    $this->suministrarInfoCombobox();
    //Campos para hacer que el formulario sepa que campos mostrar y con que informacion
    $campos =  $this->arrayCampos();
    //Titulo de la pagina
    $titulo = "EDITAR ".$this->titulo;
    //url de redireccion para consultar
    $url = url($this->strUrlConsulta);
    // Validaciones ajax
    $validator = $this->jsValidator();
    //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
    //correspondiente a este controlador
    $route = 'CausalesDemora.update';

    return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
  }

  /**
  * update
  * 
  * Recibe la informacion del formulario a traves del request para actualizar un registro de la tabla t_causales_demora
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
    $ObjectUpdate = TCausalesDemora::find($id);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = $this->validarExistencia($request->cdem_nombre);
    if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return redirect("$url/$id/edit")
      ->withErrors('El causal de demora que intenta editar tiene el mismo nombre que un registro ya existente');
    }
    //Edita el registro en la tabla
    $this->storeOrUpdateAnObject($ObjectUpdate, $request);
    Cache::forget('causalesDemora');
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'El causal de demora fue editado exitosamente!');
    return redirect($url);
  }

  /**
  * destroy
  * 
  * Borra un registro de la tabla t_causales demora, segun el id que se le pasa a la funcion.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    //Consulto objeto a borrar
    $ObjectDestroy = TCausalesDemora::find($id);
    //Borro el objeto
    $ObjectDestroy->delete();
    //Obtengo url de redireccion
    $url = url($this->strUrlConsulta);
    Cache::forget('causalesDemora');

    // redirect
    Session::flash('message', 'La causal de demora fue borrada exitosamente!');
    return redirect($url);
  }

  /**
  * arrayCampos
  * 
  * Debe retornar un array de arrays con las variables globales declaradas arriba que permiten al formulario saber que campos mostrar al usuario
  * 
  * Funcion llamada en funciones de index - create - edit del mismo controlador
  */
  public function arrayCampos(){
    return  [$this->id, $this->cdem_nombre, $this->cdem_metrica];
  }

  /**
  * validarExistencia
  * 
  * Consulta la tabla obteniendo las causales demora que tengan el mismo el nombre que la que se intenta crear o actualizar
  * 
  * funcion llamada en store - update del mismo controlador
  */
  public function validarExistencia($cdem_nombre){
    return TCausalesDemora::where('cdem_nombre', $cdem_nombre)->first();
  }

  /**
  * suministrarInfoCombobox
  * 
  * Obtiene las metricas y las organiza en un array luego las setea a la variable global para que el formulario las pinte en el combobox
  * 
  * Funcion usada en edit - create del mismo controlador
  * 
  */
  public function suministrarInfoCombobox(){
    //Consulta para mostrar combobox y guarda la consulta en cache para ser reutilizada en max 60 minutos
    $array = Cache::remember('metrica', 60, function() {
      return TMetrica::all();
    });
    //Se crea array con dos posiciones para llenar el combobox
    $combobox = [];
    foreach ($array as $key => $value) {
      $combobox["$value->id"] = $value->met_nombre;
    }
    $this->cdem_metrica[5] = $combobox;
  }

  /**
  * storeOrUpdateAnObject
  * 
  * Cumple la funcion de guardar o actualizar un registro de la bd
  * 
  * Funcion usada en store - update del mismo controlador
  * 
  */
  public function storeOrUpdateAnObject($objeto, $request){
    //Obtiene el objeto que quiero crear o actualizar
    //Cambia o agrega atributos al objeto
    $objeto->cdem_nombre = strtoupper($request->cdem_nombre);
    $objeto->cdem_metrica = $request->cdem_metrica;
    //Guarda el objeto en la bd
    $objeto->save();
  }


 /**
  * jsValidator
  * 
  * retorna el script de jquery para validar el formulario
  * 
  * Funcion usada en create - edit de este controlador
  * 
  */
  public function jsValidator(){
    return JsValidator::make($this->rules, $this->messages);
  }
}
