<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TPuertoEmbarque;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use Session;
use JsValidator;
use \Cache;


/**
 * @resource TPuertoEmbarqueController
 *
 * Controlador creado para el crud de puerto de embarque
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TPuertoEmbarqueController extends Controller
{
    //---------------------------------------------------------------------------------------------------------
    //DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------
    // Variable titulo sirve para setear el titulo en el formulario generico
    public $titulo = "PUERTO DE EMBARQUE";
    /**Array que representa los campos de la tabla, cada posicion corresponde a la siguiente informacion
    *[0]-> Nombre del campo en la tabla de la base de datos
    *[1]-> Tipo de dato del campo en la tabla de la base de datos
    *[2]-> Elemento de html que puede representarlo en un formulario
    *[3]-> Label que debe aparecer el el formulario
    *[4]-> Place holder que debe aparecer en el formulario
    */
    public $id = array('id', 'int', 'hidden', 'Identificacion del puerto de embarque', '');
    public $puem_nombre = array('puem_nombre', 'string', 'text', 'Descripcion del puerto de embarque', 'Ingresar el nombre del puerto de embarque:');

    public $puem_itime = array('puem_itime', 'string', 'text', 'Ingresar el I time del puerto de embarque', 'Ingresar el I time del puerto de embarque:');


    //Strings urls
    //Para diligenciar este campo debes en consola escribir php artisan route:list ya tienes que haber declarado
    //la ruta en el archivo routes y debes buscar el method y uri correspondiente correspondiente a este controlador resource
    //** method GET|HEAD
    public $strUrlConsulta = 'importacionesv2/PuertoEmbarque';

    //Defino las reglas de validacion para el formulario
    public $rules = array(
        'puem_nombre'       => 'required',
        'puem_itime'       => 'required'
        );

    //Defino los mensajes de alerta segun las reglas definidas en la variable rules
    public $messages = array(
        'puem_nombre.required'       => 'Favor ingresar el nombre del puerto de embarque',
         'puem_itime.required'       => 'Favor ingresar el I time del puerto de embarque'
        );


    //---------------------------------------------------------------------------------------------------------
    //END DEFINICION DE VARIABLES GLOBALES A LA CLASE
    //---------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------
    //FUNCIONES RESOURCE
    //---------------------------------------------------------------------------------------------------------


    /**
    * index
    * 
    * Esta funcion debe retornar una vista de consulta de todos los puertos de embarque
    * 
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
        $datos = Cache::remember('puertoembarque', 60, function()
        {
            return TPuertoEmbarque::all();
        });

        /**
        *Variable titulosTabla debe contener un array con los titulos de la tabla.
        *La cantidad de titulos debe corresponder a la cantidad de columnas que trae la consulta.
        */
        $titulosTabla =  array('Id', 'Descripcion', 'I time',  'Editar', 'Eliminar');

        /**
        *Campos con su tipo de dato.
        *Variable que debe contener los campos de la tabla con su nombre real.
        *De primero siempre debe ir el identificador de la tabla.
        */
        $campos =  array($this->id, $this->puem_nombre, $this->puem_itime);

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
    * Esta funcion debe retornar al usuario un formulario para ingresar datos de el puerto de embarque
    * 
    * Esta funcion debe poner al formulario la funcion ajax con la libreria jsvalidator y hacer las validaciones por medio de ajax
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
        $campos =  array($this->id, $this->puem_nombre, $this->puem_itime);
        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);
        //Variable que contiene el titulo de la vista crear
        $titulo = "CREAR ".$this->titulo;
        //Libreria de validaciones con ajax
        $validator = JsValidator::make($this->rules, $this->messages);

        return view('importacionesv2.create', compact('titulo','campos' ,'url', 'validator'));

    }


     /**
    * Puertoajax
    * 
    * Esta funcion debe retornar al usuario un formulario para ingresar datos de el puerto de embarque encima de una ventana modal llamado a traves de ajax desde el formulario de creación de la orden de importacion
    * 
    * Esta funcion debe poner al formulario la funcion ajax con la libreria jsvalidator y hacer las validaciones por medio de ajax
    *
    * @return \Illuminate\Http\Response
    */
    public function Puertoajax()
    {
        //Array que contiene los campos que deseo mostrar en el formulario no debes tiene en cuenta timestamps ni softdeletes
        $campos =  array($this->id, $this->puem_nombre, $this->puem_itime);
        //Genera url completa de consulta
        $url = url($this->strUrlConsulta);

        $route = route('storeajaxpuerto');
        //Variable que contiene el titulo de la vista crear
        $titulo = "CREAR ".$this->titulo;
        //Libreria de validaciones con ajax
        $validator = JsValidator::make($this->rules, $this->messages);

        return view('importacionesv2.ImportacionTemplate.createajax', compact('titulo','campos' ,'url', 'validator', 'route'));

    }

    /**
    * store
    * 
    * Esta funcion recibe por el request toda la informacion del formulario de creacion de puertos de embarque.
    * 
    * Debe validar que no exista un registro con el mismo puem_nombre
    * 
    * Esta funcion debe crear un  nuevo registro en la tabla puerto de embarque
    * 
    * Debe retornar al usuario un mensaje informando que la creacion del registro fue exitosa   * 
    * 
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //Genera la url de consulta
        $url = url($this->strUrlConsulta);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TPuertoEmbarque::where('puem_nombre', '=', "$request->puem_nombre")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/create")
            ->withErrors('El puerto de embarque que intenta crear tiene el mismo nombre que un registro ya existente');
        }
        //Crea el registro en la tabla puerto de embarque
        $ObjectCrear = new TPuertoEmbarque;
        $ObjectCrear->puem_nombre = strtoupper(Input::get('puem_nombre'));
        $ObjectCrear->puem_itime = strtoupper(Input::get('puem_itime'));
        $ObjectCrear->save();
        Cache::forget('puertoembarque');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El puerto de embarque fue creado exitosamente!');
        return Redirect::to($url);
    }

      /**
    * storeAjax
    * 
    * Guarda un registro en la tabla puerto de embarque que se manda a crear por medio de una peticion ajax
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
      public function storeAjax(Request $request)
      {
        //Genera la url de consulta
        $url = url($this->strUrlConsulta);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TPuertoEmbarque::where('puem_nombre', '=', "$request->puem_nombre")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
           return array('error', 'Ya existe un puerto de embarque con la misma descripcion', '');
        }

        $validator = Validator::make(Input::all(), $this->rules, $this->messages);

     // process the login
        if ($validator->fails()) {
            return array('error', 'Favor validar la integridad de los campos', '');
        } else {
        //Crea el registro en la tabla puerto de embarque
            $ObjectCrear = new TPuertoEmbarque;
            $ObjectCrear->puem_nombre = strtoupper(Input::get('puem_nombre'));
            $ObjectCrear->puem_itime = strtoupper(Input::get('puem_itime'));
            $ObjectCrear->save();
            Cache::forget('puertoembarque');
        //Redirecciona a la pagina de consulta y muestra mensaje
            return array('success', $ObjectCrear->id, $ObjectCrear->puem_nombre, '#imp_puerto_embarque');
        }
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
    * Esta funcion recibe como parametro el id del puerto de embarque que deseo editar
    * 
    * Debe retornar al usuario el formulario para editar un registro de la tabla puerto de embarque
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //Id del registro que deseamos editar
        $id = $id;
        //Consulto el registro que deseo editar
        $objeto = TPuertoEmbarque::find($id);
        //organizo el array que me sirve para mostrar el formulario de edicion
        $campos =  array($this->id, $this->puem_nombre, $this->puem_itime);
        //Titulo de la pagina
        $titulo = "EDITAR ".$this->titulo;
        //url de redireccion para consultar
        $url = url($this->strUrlConsulta);
        // Validaciones ajax
        $validator = JsValidator::make($this->rules, $this->messages);
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'PuertoEmbarque.update';

        return view('importacionesv2.edit', compact('campos', 'url', 'titulo', 'validator', 'route', 'id' ,'objeto'));
    }

    /**
    * update
    * 
    * Esta funcion recibe como parametro la informacion del formulario de actualizacion
    * 
    * recibe tambien el id del puerto de embarque que se desea editar
    * 
    * debe validar que no exista ningun registro con el mismo puem_nombre
    * 
    * debe actualizar el registro en la tabla
    * 
    * debe redireccionar a la vista de consulta de puertos de embarque
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
        $ObjectUpdate = TPuertoEmbarque::find($id);
        //Valida la existencia del registro que se intenta crear en la tabla de la bd por el campo ormer_nombre
        $validarExistencia = TPuertoEmbarque::where('puem_nombre', '=', "$request->puem_nombre")->first();
        if(count($validarExistencia) > 0 && $validarExistencia != $ObjectUpdate){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return Redirect::to("$url/$id/edit")
            ->withErrors('El puerto de embarque que intenta editar tiene el mismo nombre que un registro ya existente');
        }
        //Edita el registro en la tabla
        $ObjectUpdate->puem_nombre = strtoupper(Input::get('puem_nombre'));
        $ObjectUpdate->puem_itime = strtoupper(Input::get('puem_itime'));
        $ObjectUpdate->save();
        Cache::forget('puertoembarque');
        //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El puerto de embarque fue editado exitosamente!');
        return Redirect::to($url);
    }

    /**
    * destroy
    * 
    * Esta funcion recibe como parametro el id del registro de la tabla t_puerto_embarque, que deseo eliminar
    * 
    * Debe eliminar un registro de la tabla t_puerto_embarque haciendo uso de softdelete
    * 
    * debe borrar la variable de cache 
    * 
    * debe redireccionar a la vista de consulta
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //Consulto objeto a borrar
        $ObjectDestroy = TPuertoEmbarque::find($id);
        //Borro el objeto
        $ObjectDestroy->delete();
        //Obtengo url de redireccion
        $url = url($this->strUrlConsulta);
        Cache::forget('puertoembarque');
        // redirect
        Session::flash('message', 'El puerto de embarque fue borrado exitosamente!');
        return Redirect::to($url);
    }

    //---------------------------------------------------------------------------------------------------------
    //END FUNCIONES RESOURCE
    //---------------------------------------------------------------------------------------------------------


}