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
    // Variable titulo sirve para setear el titulo en el formulario generico
    public $titulo = "ORIGEN MERCANCÍA";
    public $id = array('id', 'int', 'hidden', 'Identificacion del origen de la mercancia');
    public $ormer_nombre = array('ormer_nombre', 'string', 'text', 'Descripcion del origen de la mercancia');
    public $ormer_requ_cert_origen = array('ormer_requ_cert_origen', 'boolean', 'checkbox', 'Requiere certificado de origen?');
    //Defino las reglas de validacion
    public $rules = array(
           'ormer_nombre'       => 'required',
        );
    //Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
           'ormer_nombre.required'       => 'Favor ingresar el nombre del origen de la mercancia',
        );

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

      //Ejecuto clase validadora de laravel
          $validator = Validator::make(Input::all(), $this->rules, $this->messages);
          $url = url('importacionesv2/OrigenMercancia');

          if ($validator->fails()) {
            return Redirect::to("$url/create")
                ->withErrors($validator);
          }else {
              // Guardar
              $origenMercancia = new TOrigenMercancia;
              $origenMercancia->ormer_nombre = Input::get('ormer_nombre');
              if (Input::get('ormer_requ_cert_origen') == 1){
                $origenMercancia->ormer_requ_cert_origen = 1;
              }else{
                $origenMercancia->ormer_requ_cert_origen = 0;
              }
              $origenMercancia->save();

              // redirect
              Session::flash('message', 'Origen de la mercancia fue creada exitosamente!');
              return Redirect::to($url);
          }
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
        //
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
        //
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
