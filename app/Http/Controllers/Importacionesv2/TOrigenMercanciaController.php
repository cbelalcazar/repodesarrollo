<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TOrigenMercancia;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;

class TOrigenMercanciaController extends Controller
{

  //---------------------------------------------------------------------------------------------------------
  //DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------
  // Variable titulo sirve para setear el titulo en el formulario generico
  public $titulo = "ORIGEN MERCANCÍA";
  /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
  *[0]-> Nombre del campo en la tabla de la base de datos
  *[1]-> Tipo de dato del campo en la tabla de la base de datos
  *[2]-> Elemento de html que puede representarlo en un formulario
  *[3]-> Label que debe aparecer el el formulario
  */
  public $id = array('id', 'int', 'hidden', 'Identificacion del origen de la mercancia');
  public $ormer_nombre = array('ormer_nombre', 'string', 'text', 'Descripcion del origen de la mercancia');
  public $ormer_requ_cert_origen = array('ormer_requ_cert_origen', 'boolean', 'checkbox', 'Requiere certificado de origen?');

  //Defino las reglas de validacion para el formulario
  public $rules = array(
    'ormer_nombre'       => 'required',
  );

  //Defino los mensajes de alerta segun las reglas definidas en la variable rules
  public $messages = array(
    'ormer_nombre.required'       => 'Favor ingresar el nombre del origen de la mercancia',
  );
  //---------------------------------------------------------------------------------------------------------
  //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
  //---------------------------------------------------------------------------------------------------------

  //---------------------------------------------------------------------------------------------------------
  //FUNCIONES RESOURCE
  //---------------------------------------------------------------------------------------------------------

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    /**
    *Variable datos debe contener la informacion que se quiere mostrar en el formulario generico.
    */
    $datos = TOrigenMercancia::all();

    /**
    *Variable titulosTabla debe contener un array con los titulos de la tabla.
    *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
    */
    $titulosTabla =  array('Id', 'Nombre', 'Requiere Certificado de Origen', 'Acción');

    /**
    *Campos con su tipo de dato.
    *Variable que debe contener los campos de la tabla con su nombre real.
    *De primero siempre debe ir el identificador de la tabla.
    */
    $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);

    //url debe tener la url completa para consulta
    $url = url('importacionesv2/OrigenMercancia');

    return view('importacionesv2.index', array('titulo' => $this->titulo,
    'datos' => $datos,
    'titulosTabla' => $titulosTabla,
    'campos' => $campos,
    'url' => $url));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //Array que contiene
    $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);
    $url = url('importacionesv2/OrigenMercancia');
    $titulo = $this->titulo;
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
    $url = url('importacionesv2/OrigenMercancia');
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = TOrigenMercancia::where('ormer_nombre', '=', "$request->ormer_nombre")->get();
    if(count($validarExistencia) > 0){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return Redirect::to("$url/create")
      ->withErrors('El origen de la mercancia que intenta crear tiene el mismo nombre que un registro ya existente');
    }
    //Crea el registro en la tabla origen mercancia
    $origenMercancia = new TOrigenMercancia;
    $origenMercancia->ormer_nombre = strtoupper(Input::get('ormer_nombre'));
    if ($request->ormer_requ_cert_origen == 1){
      $origenMercancia->ormer_requ_cert_origen = 1;
    }else{
      $origenMercancia->ormer_requ_cert_origen = 0;
    }
    $origenMercancia->save();
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'Origen de la mercancia fue creada exitosamente!');
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
    $id = $id;
    $objeto = TOrigenMercancia::find($id);
    $campos =  array($this->id, $this->ormer_nombre, $this->ormer_requ_cert_origen);
    $titulo = "EDITAR ORIGEN MERCANCÍA";
    $url = url('importacionesv2/OrigenMercancia');
    $validator = JsValidator::make($this->rules, $this->messages);
    $route = 'OrigenMercancia.update';
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
    $url = url('importacionesv2/OrigenMercancia');
    //Consulto el registro a editar
    $origenMercancia = TOrigenMercancia::find($id);
    //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
    $validarExistencia = TOrigenMercancia::where('ormer_nombre', '=', "$request->ormer_nombre")->first();
    if(count($validarExistencia) > 0 && $validarExistencia != $origenMercancia){
      //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
      return Redirect::to("$url/create")
      ->withErrors('El origen de la mercancia que intenta crear tiene el mismo nombre que un registro ya existente');
    }
    //Edita el registro en la tabla origen mercancia
    $origenMercancia->ormer_nombre = strtoupper(Input::get('ormer_nombre'));
    if ($request->ormer_requ_cert_origen == 1){
      $origenMercancia->ormer_requ_cert_origen = 1;
    }else{
      $origenMercancia->ormer_requ_cert_origen = 0;
    }
    $origenMercancia->save();
    //Redirecciona a la pagina de consulta y muestra mensaje
    Session::flash('message', 'Origen de la mercancia fue editado exitosamente!');
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
       $origenMercancia = TOrigenMercancia::find($id);
       $origenMercancia->delete();
       $url = url('importacionesv2/OrigenMercancia');

       // redirect
       Session::flash('message', 'Origen de la mercancia borrado exitosamente!');
       return Redirect::to($url);
  }

  //---------------------------------------------------------------------------------------------------------
  //END FUNCIONES RESOURCE
  //---------------------------------------------------------------------------------------------------------
}
