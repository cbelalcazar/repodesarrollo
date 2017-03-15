<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use App\Models\Importacionesv2\TTiemposTransito;
use App\Models\Importacionesv2\TPuertoEmbarque;
use App\Models\Importacionesv2\TTipoCarga;
use \Cache;
use JsValidator;
use Session;
use Redirect;

use Illuminate\Http\Request;

class TTiemposTransitoController extends Controller
{


  //---------------------------------------------------------------------------------------------
  //DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------
  // Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "TIEMPOS DE TRANSITO";
  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  *[4]-> Placeholder que debe aparecer en el formulario
  *[5]-> Consulta para llenar combobox si es el caso - se setea en la funcion respectiva debe siempre declararse vacia ('')
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion la metrica', '','');
  public $tran_embarcador = array('tran_embarcador', 'string', 'autocomplete', 'Favor ingresar el embarcador', 'Favor ingresar el embarcador','','');
  public $tran_puerto_embarque = array('tran_puerto_embarque', 'relation', 'select', 'Seleccionar el puerto de embarque', 'Seleccionar el puerto de embarque...','',array('puerto_embarque','puem_nombre'));
  public $tran_linea_maritima = array('tran_linea_maritima', 'string', 'autocomplete', 'Favor ingresar la linea maritima', 'Favor ingresar la linea maritima','','');
  public $tran_tipo_carga = array('tran_tipo_carga', 'relation', 'select', 'Seleccionar el tipo de carga', 'Seleccionar el tipo de carga...','',array('tipoCarga','tcar_descripcion'));
  public $tran_numero_dias = array('tran_numero_dias', 'string', 'text', 'Favor ingresar el numero de dias de transito', 'Favor ingresar el numero de dias de transito','','');



  //Strings urls
  //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
  //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
  //** method GET|HEAD
  public $strUrlConsulta = 'importacionesv2/TiemposTransito';

  //Defino las reglas de validacion para el formulario
  public $rules = array('tran_embarcador' => 'required',
    'tran_puerto_embarque' => 'required',
    'tran_linea_maritima' => 'required',
    'tran_tipo_carga' => 'required',
    'tran_numero_dias' => 'required');

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array('tran_embarcador.required' => 'Favor ingresar el embarcador',
    'tran_puerto_embarque.required' => 'Favor ingresar el puerto de embarque',
    'tran_linea_maritima.required' => 'Favor ingresar la linea maritima',
    'tran_tipo_carga.required' => 'Favor ingresar el tipo de carga',
    'tran_numero_dias.required' => 'Favor ingresar el numero de dias');
  //---------------------------------------------------------------------------------------------------------
  //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------

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
    $datos = Cache::remember('tiemposTransito', 60, function() {
      return TTiemposTransito::with(array('puerto_embarque' => function($query){$query->withTrashed();}),array('tipoCarga' => function($query){$query->withTrashed();}))->get();
  });


    /**
    *Variable titulosTabla debe contener un array con los titulos de la tabla.
    *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
    */
    $titulosTabla =  array('Id', 'Embarcador', 'Puerto embarque',  'Linea maritima', 'Tipo de carga', 'Numero de dias', 'Editar', 'Eliminar');

    /**
    *Campos con su tipo de dato.
    *Variable que debe contener los campos de la tabla con su nombre real.
    *De primero siempre debe ir el identificador de la tabla.
    */
    $campos =  array($this->id, $this->tran_embarcador, $this->tran_puerto_embarque, $this->tran_linea_maritima, $this->tran_tipo_carga, $this->tran_numero_dias);

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
         //Consulta para mostrar combobox y guarda la consulta en cache para ser reutilizada en max 60 minutos
        $array = Cache::remember('puertoembarque', 60, function()
        {
            return TPuertoEmbarque::all();
        });

        //Se crea array con dos posiciones para llenar el combobox
        $combobox = array();
        foreach ($array as $key => $value) {
          $combobox["$value->id"] = $value->puem_nombre;
      }

          //Consulta para mostrar combobox y guarda la consulta en cache para ser reutilizada en max 60 minutos
      $array1 = Cache::remember('tipocarga', 60, function()
      {
        return TTipoCarga::all();
    });

        //Se crea array con dos posiciones para llenar el combobox
      $combobox1 = array();
      foreach ($array1 as $key => $value) {
          $combobox1["$value->id"] = $value->tcar_descripcion;
      }


      $tran_puerto_embarque = $this->tran_puerto_embarque;
      $tran_puerto_embarque[5] = $combobox;

      $tran_tipo_carga = $this->tran_tipo_carga;
      $tran_tipo_carga[5] = $combobox1;
    //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
      $campos =  array($this->id, $this->tran_embarcador, $tran_puerto_embarque, $this->tran_linea_maritima, $tran_tipo_carga, $this->tran_numero_dias);
    //Genera url completa de consulta
      $url = url($this->strUrlConsulta);
    //Variable que contiene el titulo de la vista crear
      $titulo = "CREAR ".$this->titulo;
    //Libreria de validaciones con ajax
      $validator = JsValidator::make($this->rules, $this->messages);

      $javascriptImport = true;

      return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator', 'javascriptImport'));
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


        $validarExistencia = TTiemposTransito::where(array(array('tran_embarcador', '=', "$request->tran_embarcador"), array('tran_puerto_embarque', '=', "$request->tran_puerto_embarque"), array('tran_linea_maritima', '=', "$request->tran_linea_maritima"), array('tran_tipo_carga', '=', "$request->tran_tipo_carga")))->get();
        if(count($validarExistencia) > 0){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
          return Redirect::to("$url/create")
          ->withErrors('El tiempo de transito que intenta parametrizar ya existe');
      }
    //Crea el registro en la tabla origen mercancia
      $ObjectCrear = new TTiemposTransito;
      $ObjectCrear->tran_embarcador = $request->tran_embarcador;
      $ObjectCrear->tran_puerto_embarque = intval($request->tran_puerto_embarque);
      $ObjectCrear->tran_linea_maritima = $request->tran_linea_maritima;
      $ObjectCrear->tran_tipo_carga = intval($request->tran_tipo_carga);
      $ObjectCrear->tran_numero_dias = intval($request->tran_numero_dias);

      $ObjectCrear->save();
      Cache::forget('tiemposTransito');
    //Redirecciona a la pagina de consulta y muestra mensaje
      Session::flash('message', 'El tiempo de transito fue creado exitosamente!');
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
        $objeto = TTiemposTransito::find($id);

         //Consulta para mostrar combobox y guarda la consulta en cache para ser reutilizada en max 60 minutos
        $array = Cache::remember('puertoembarque', 60, function()
        {
            return TPuertoEmbarque::all();
        });

        //Se crea array con dos posiciones para llenar el combobox
        $combobox = array();
        foreach ($array as $key => $value) {
          $combobox["$value->id"] = $value->puem_nombre;
      }

          //Consulta para mostrar combobox y guarda la consulta en cache para ser reutilizada en max 60 minutos
      $array1 = Cache::remember('tipocarga', 60, function()
      {
        return TTipoCarga::all();
    });

        //Se crea array con dos posiciones para llenar el combobox
      $combobox1 = array();
      foreach ($array1 as $key => $value) {
          $combobox1["$value->id"] = $value->tcar_descripcion;
      }


      $tran_puerto_embarque = $this->tran_puerto_embarque;
      $tran_puerto_embarque[5] = $combobox;

      $tran_tipo_carga = $this->tran_tipo_carga;
      $tran_tipo_carga[5] = $combobox1;

       //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
      $campos =  array($this->id, $this->tran_embarcador, $tran_puerto_embarque, $this->tran_linea_maritima, $tran_tipo_carga, $this->tran_numero_dias);
    //Titulo de la pagina
      $titulo = "EDITAR ".$this->titulo;
    //url de redireccion para consultar
      $url = url($this->strUrlConsulta);
    // Validaciones ajax
      $validator = JsValidator::make($this->rules, $this->messages);
    //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
    //correspondiente a este controlador
      $route = 'TiemposTransito.update';
      $javascriptImport = true;

      return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto', 'javascriptImport'));
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
        $ObjectUpdate = TTiemposTransito::find($id);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TTiemposTransito::where(array(array('tran_embarcador', '=', "$request->tran_embarcador"), array('tran_puerto_embarque', '=', "$request->tran_puerto_embarque"), array('tran_linea_maritima', '=', "$request->tran_linea_maritima"), array('tran_tipo_carga', '=', "$request->tran_tipo_carga")))->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
          return Redirect::to("$url/$id/edit")
          ->withErrors('El tiempo de transito ya que intenta parametrizar ya existe');
      }
    //Edita el registro en la tabla
      $ObjectUpdate->tran_embarcador = $request->tran_embarcador;
      $ObjectUpdate->tran_puerto_embarque = intval($request->tran_puerto_embarque);
      $ObjectUpdate->tran_linea_maritima = $request->tran_linea_maritima;
      $ObjectUpdate->tran_tipo_carga = intval($request->tran_tipo_carga);
      $ObjectUpdate->tran_numero_dias = intval($request->tran_numero_dias);

      $ObjectUpdate->save();
      Cache::forget('tiemposTransito');
    //Redirecciona a la pagina de consulta y muestra mensaje
      Session::flash('message', 'El tiempo de transito fue actualizado exitosamente!');
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
        //
    }
}
