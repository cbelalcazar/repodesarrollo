<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TTipoCarga;
use App\Models\Importacionesv2\TImportacion;
use App\Models\Importacionesv2\TTipoContenedor;
use App\Models\Importacionesv2\TEmbarqueImportacion;
use App\Models\Importacionesv2\TContenedorEmbarque;
use App\Models\Importacionesv2\TProductoImportacion;
use App\Models\Importacionesv2\TLineaMaritima;
use \Cache;
use Validator;
use Carbon\Carbon;
use Session;
use Redirect;
use DB;
use Auth;
use App\Models\Importacionesv2\TPermisosImp;

/**
 * @resource TEmbarqueImportacionController
 *
 * Controlador creado para generar el proceso de embarque importación
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 21/04/2017
 */
class TEmbarqueImportacionController extends Controller
{


  //REGLAS DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $rules = array(
    'emim_embarcador'                             => 'required',
    'emim_linea_maritima'                         => 'required',
    'emim_aduana'                                 => 'required',
    'emim_transportador'                          => 'required',
    'emim_tipo_carga'                             => 'required',
    'emim_fecha_etd'                              => 'required|date',
    'emim_fecha_eta'                              => 'required|date',
    'emim_fecha_recibido_documentos_ori'          => 'date',
    'emim_fecha_envio_aduana'                     => 'date',
    'emim_fecha_envio_ficha_tecnica'              => 'date',
    'emim_fecha_envio_lista_empaque'              => 'date',
    'emim_fecha_solicitud_reserva'                => 'required|date',
    'emim_fecha_confirm_reserva'                  => 'required|date',
    'emim_documento_transporte'                   => 'required|',
    'emim_valor_flete'                            => 'numeric');

  //MENSAJES DE VALIDACION EJECUTADOS ANTES DE GRABAR EL OBJETO 
  public $messages = array(
    'emim_embarcador.required'       => 'Favor ingresar el embarcador',
    'emim_linea_maritima.required'       => 'Favor ingresar la linea maritima',
    'emim_aduana.required'       => 'Favor ingresar la aduana',
    'emim_transportador.required'       => 'Favor ingresar el transportador',
    'emim_tipo_carga.required'       => 'Favor ingresar el tipo de carga',
    'emim_fecha_etd.required'       => 'Favor ingresar la fecha del ETD',
    'emim_fecha_etd.date'       => 'El campo fecha del etd debe tener formato fecha',
    'emim_fecha_eta.required'       => 'Favor ingresar la fecha del ETA',
    'emim_fecha_eta.date'       => 'El campo fecha del ETA debe tener formato fecha',
    'emim_fecha_recibido_documentos_ori.date'       => 'El campo fecha de recibido documentos originales debe tener formato fecha',
    'emim_fecha_envio_aduana.date'       => 'El campo fecha de envio a la aduana debe tener formato fecha',
    'emim_fecha_envio_ficha_tecnica.date'       => 'El campo fecha de envio ficha tecnica debe tener formato fecha',
    'emim_fecha_envio_lista_empaque.date'       => 'El campo fecha de envio lista de empaque debe tener formato fecha',
    'emim_fecha_solicitud_reserva.required'       => 'Favor ingresar la fecha de la solicitud de la reserva',
    'emim_fecha_solicitud_reserva.date'       => 'El campo fecha de la solicitud de la reserva debe tener formato fecha',
    'emim_fecha_confirm_reserva.required'       => 'Favor ingresar la fecha de confirmación de la reserva',
    'emim_fecha_confirm_reserva.date'       => 'El campo fecha de confirmacion de la reserva debe tener formato fecha',
    'emim_documento_transporte.required'       => 'Favor ingresar el numero del documento de transporte',
    'emim_valor_flete.integer'       => 'El campo valor del flete debe tener formato numerico');

  //Name de la url de consulta la uso para no redundar este string en mis funciones
  public $strUrlConsulta = 'importacionesv2/Embarque';


    /**
     * index
     * 
     * Sin ninguna funcionalidad
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * permisos
     * 
     * Su funcion es retornar 1 si el usuario es la jefe o 0 si es auxiliar consultando en la tabla TPermisosImp
     *
     * @return \Illuminate\Http\Response
     */
    public function permisos(){
        $usuario = Auth::user();
        $permisos = TPermisosImp::where('perm_cedula', '=',"$usuario->idTerceroUsuario")->first();
        if($permisos == null || $permisos->perm_cargo == 2){
            return 0;
        }elseif($permisos->perm_cargo == 1){
           return 1;
       }
   }

    /**
     * create
     * 
     * Su funcionalidad es mostrar el formulario de creacion para las tablas t_embarque_importacion asociando t_tipo_carga, t_tipo_contenedor y t_linea_maritima
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $idImportacion=$id;
        $ObtenerFecha = TImportacion::find($idImportacion);
        $imp_fechaentregatotal = Carbon::parse($ObtenerFecha->imp_fecha_entrega_total);
        $imp_fechaentregatotal =  $imp_fechaentregatotal->addDays(8)->format('Y-m-d');
        #Contiene el titulo de formulario
        $titulo = "CREAR EMBARQUE DE - ". $ObtenerFecha->imp_consecutivo;
        #String que hace referencia al URI del route que se le pasa al formulario y genere la url de post
        $url = "importacionesv2/Embarque";
        #Crea los array de las consultas para mostrar en los combobox en el formulario
        $consulta = array(1,2,3);
        $combos = $this->consultas($consulta);
        #Convierte cada posicion del array en variables independientes
        extract($combos);
        #Envia la informacion a la vista
        return view('importacionesv2.EmbarqueTemplate.createEmbarque', 
            compact('titulo',
                'url',
                'tipocarga',
                'contenedores',
                'idImportacion',
                'imp_fechaentregatotal',
                'lineasMaritimas'));
    }

    /**
     * store
     * 
     * Esta funcion valida  la obligatoriedad de los campos y demas acciones del validator, tambien que no exista un embarque con el mismo numero de importacion, y crea un registro en la tabla t_embarque_importacion, t_contenedores y modifica los estados de la tabla t_producto importacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //     
        $urlConsulta = route('consultaFiltros'); 
        $url = url("importacionesv2/Embarque/create");
        //libreria validator.
        $rules = array();
        if($request->emim_tipo_carga == 1 || $request->emim_tipo_carga == 2){
            $rules = $this->rules;
            $rules['cubicaje'] = 'required|numeric';
            $rules['peso'] = 'required|numeric';
            $rules['cajas'] = 'required|numeric';
        }
        if($rules == array()){
            $rules = $this->rules;
        }
        if($request->emim_tipo_carga == 3){
            if($request->emim_tipo_carga == ""){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
                return redirect()->action(
                    'Importacionesv2\TEmbarqueImportacionController@create', ['id' => $request->emim_importacion]
                    )->withErrors('Favor ingresar informacion de contenedores a importar')->withInput();            
            }
        }

        $validator = Validator::make($request->all(), $rules, $this->messages);
        if ($validator->fails()) {
            return redirect()->action(
                'Importacionesv2\TEmbarqueImportacionController@create', ['id' => $request->emim_importacion]
                )->withErrors($validator)->withInput();
        }

        //Valida la existencia del registro que se intenta crear en la tabla de la bd 
        $validarExistencia = TEmbarqueImportacion::where('emim_importacion', '=', "$request->emim_importacion")->get();
        if(count($validarExistencia) > 0){
            //retorna error en caso de encontrar algun registro en la tabla con el mismo nombre
            return redirect()->action(
                'Importacionesv2\TEmbarqueImportacionController@create', ['id' => $request->emim_importacion]
                )->withErrors('El proceso de embarque que intenta crear ya existe en la base de datos')->withInput();            
        }
        DB::beginTransaction();
         //Crea el registro en la tabla importacion
        $ObjectCrear = new TEmbarqueImportacion;
        $ObjectCrear->emim_importacion = $request->emim_importacion;
        $ObjectCrear->emim_embarcador = $request->emim_embarcador;
        $ObjectCrear->emim_linea_maritima = $request->emim_linea_maritima;
        $ObjectCrear->emim_aduana = $request->emim_aduana;
        $ObjectCrear->emim_transportador = $request->emim_transportador;
        $ObjectCrear->emim_tipo_carga = $request->emim_tipo_carga;

        $ObjectCrear->emim_fecha_etd = Carbon::parse($request->emim_fecha_etd)->format('Y-m-d');
        $ObjectCrear->emim_fecha_eta = Carbon::parse($request->emim_fecha_eta)->format('Y-m-d');

        if ($request->emim_fecha_recibido_documentos_ori != "") {
            $ObjectCrear->emim_fecha_recibido_documentos_ori == Carbon::parse($request->emim_fecha_recibido_documentos_ori)->format('Y-m-d');
        }

     if ($request->emim_fecha_envio_aduana != "") {
            $ObjectCrear->emim_fecha_envio_aduana = Carbon::parse($request->emim_fecha_envio_aduana)->format('Y-m-d');
    }

 if ($request->emim_fecha_envio_ficha_tecnica != "") {
    $ObjectCrear->emim_fecha_envio_ficha_tecnica = Carbon::parse($request->emim_fecha_envio_ficha_tecnica)->format('Y-m-d');
} 

if ($request->emim_fecha_envio_lista_empaque != "") {
     $ObjectCrear->emim_fecha_envio_lista_empaque = Carbon::parse($request->emim_fecha_envio_lista_empaque)->format('Y-m-d');
} 

$ObjectCrear->emim_fecha_solicitud_reserva = Carbon::parse($request->emim_fecha_solicitud_reserva)->format('Y-m-d');
$ObjectCrear->emim_fecha_confirm_reserva = Carbon::parse($request->emim_fecha_confirm_reserva)->format('Y-m-d');
$ObjectCrear->emim_fecha_confirm_reserva = Carbon::parse($request->emim_fecha_confirm_reserva)->format('Y-m-d');
$ObjectCrear->emim_documento_transporte = strtoupper($request->emim_documento_transporte);

if ($request->emim_valor_flete != "") {
     $ObjectCrear->emim_valor_flete = $request->emim_valor_flete;
} 
$ObjectCrear->save();

if(!$ObjectCrear->id){
 DB::rollBack();
 App::abort(500, 'La importacion no fue creada, consultar con el administrador del sistema [error 201]');        
}else{

    if($request->emim_tipo_carga == 1 || $request->emim_tipo_carga == 2){
        $objContenedor = new TContenedorEmbarque;
        $objContenedor->cont_embarque = $ObjectCrear->id;
        $objContenedor->cont_cubicaje = $request->cubicaje;
        $objContenedor->cont_peso     = $request->peso;
        $objContenedor->cont_cajas    = $request->cajas;
        $objContenedor->save();
        if(!$objContenedor->id){                    
            DB::rollBack();
            App::abort(500, 'La importacion no fue creada, se genero un problema en la creacion de la carga [error 204]');
        }   
    }elseif($request->emim_tipo_carga == 3){
            #Crea todas las proformas asociadas en la tabla
        $cantidad = intval($request->tablaContenedorGuardar);
        $contador = 1;
        do {
            $objContenedor1 = new TContenedorEmbarque;
            $objContenedor1->cont_embarque = $ObjectCrear->id;

            $tipoContenedor1 = "$contador"."-tipocont";
            $objContenedor1->cont_tipo_contenedor = $request->$tipoContenedor1;

            $cantidad1 = "$contador"."-cantidad";
            $objContenedor1->cont_cantidad = $request->$cantidad1;

            $numeroImportacion1 = "$contador"."-numeroImportacion";
            $objContenedor1->cont_numero_contenedor = $request->$numeroImportacion1;

            $cubicaje1 = "$contador"."-cubicaje";
            $objContenedor1->cont_cubicaje = $request->$cubicaje1;

            $peso1 = "$contador"."-peso";
            $objContenedor1->cont_peso = $request->$peso1;

            $objContenedor1->save();
            $contador++;
        } while ($contador <= $cantidad);

    }else{
       DB::rollBack();
       App::abort(500, 'Favor validar el tipo de carga seleccionado [error 202]');     
   }

   DB::commit();
           #Cambia el estado de la orden de importacion a transito
   $objImportacion = TImportacion::find($request->emim_importacion);
   $objImportacion->imp_estado_proceso = 2;
   $objImportacion->save();

   $objProductosImportacion = TProductoImportacion::where('pdim_importacion','=', $request->emim_importacion)->get();
   foreach ($objProductosImportacion as $key => $value) {
       if($value->pdim_fech_req_declaracion_anticipado != null){
        $value->pdim_fech_req_declaracion_anticipado = Carbon::now()->format('Y-m-d');
    }
    if($value->pdim_fech_requ_registro_importacion != null){
        $value->pdim_fech_requ_registro_importacion = Carbon::now()->format('Y-m-d');
    }
    $value->save();
}
}

Session::flash('message', 'El proceso de embarque fue creado exitosamente!');
return Redirect::to($urlConsulta);
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
     * Esta funcion debe entregar un formulario para editar un embarque importacion asociado a una importacion
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Id del registro que deseamos editar
        $id = $id;
        //Consulto el registro que deseo editar
        $objeto = TEmbarqueImportacion::with('importacion', 'lineamaritima', 'aduana', 'transportador', 'embarcador')->find($id);
        //Titulo de la pagina
        $titulo = "EDITAR PROCESO DE EMBARQUE - ".$objeto->importacion->imp_consecutivo;       
        //url de redireccion para consultar
        $url = route('Embarque.store');
        //url de redireccion para editar -- Name url correspondiente a method PUT|PATCH en comando route.list
        //correspondiente a este controlador
        $route = 'Embarque.update';
        #Consulta los origenes de la mercancia importacion asociados a esta en especifico
        $contenedoresArray = TContenedorEmbarque::where('cont_embarque','=', "$objeto->id" )->get();
        $cantidadContenedores = count($contenedoresArray);
        #Crea los array de las consultas para mostrar en los combobox en el formulario
        $consulta = array(1,2,3);
        $combos = $this->consultas($consulta);
        extract($combos);
        $urlBorrar = "";
        $hasPerm = $this->permisos();
        return view('importacionesv2.EmbarqueTemplate.editEmbarque', 
            compact('url',
             'titulo', 
             'route', 
             'id',
             'objeto',
             'tipocarga',
             'contenedores',
             'contenedoresArray',
             'cantidadContenedores',
             'urlBorrar',
             'hasPerm',
             'lineasMaritimas'));
    }

    /**
     * update
     * 
     * Esta funcion modifica un registro de la tabla t_embarque importacion segun el usuario diligencia en la tabla de la bd, edita tambien contenedores de embarque y retorna exito al editar y redirige a la pagina de consulta principal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Genera la url de consulta
        $url = route('consultaFiltros');
        //Consulto el registro a editar
        $ObjectUpdate = TEmbarqueImportacion::find($id);
        $ObjectUpdate->emim_importacion = $request->emim_importacion;
        $ObjectUpdate->emim_embarcador = $request->emim_embarcador;
        $ObjectUpdate->emim_linea_maritima = $request->emim_linea_maritima;
        $ObjectUpdate->emim_aduana = $request->emim_aduana;
        $ObjectUpdate->emim_transportador = $request->emim_transportador;
        $ObjectUpdate->emim_tipo_carga = $request->emim_tipo_carga;

        $ObjectUpdate->emim_fecha_etd = Carbon::parse($request->emim_fecha_etd)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_eta = Carbon::parse($request->emim_fecha_eta)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_recibido_documentos_ori = Carbon::parse($request->emim_fecha_recibido_documentos_ori)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_envio_aduana = Carbon::parse($request->emim_fecha_envio_aduana)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_envio_ficha_tecnica = Carbon::parse($request->emim_fecha_envio_ficha_tecnica)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_envio_lista_empaque = Carbon::parse($request->emim_fecha_envio_lista_empaque)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_solicitud_reserva = Carbon::parse($request->emim_fecha_solicitud_reserva)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_confirm_reserva = Carbon::parse($request->emim_fecha_confirm_reserva)->format('Y-m-d');
        $ObjectUpdate->emim_fecha_confirm_reserva = Carbon::parse($request->emim_fecha_confirm_reserva)->format('Y-m-d');
        $ObjectUpdate->emim_documento_transporte =strtoupper($request->emim_documento_transporte);
        $ObjectUpdate->emim_valor_flete =$request->emim_valor_flete;
        $ObjectUpdate->save();

        $contenedoresBorrar = TContenedorEmbarque::where('cont_embarque','=', "$ObjectUpdate->id")->delete();;


        if($request->emim_tipo_carga == 1 || $request->emim_tipo_carga == 2){
            $objContenedor = new TContenedorEmbarque;
            $objContenedor->cont_embarque = $ObjectUpdate->id;
            $objContenedor->cont_cubicaje = $request->cubicaje;
            $objContenedor->cont_peso     = $request->peso;
            $objContenedor->cont_cajas    = $request->cajas;
            $objContenedor->save();
            if(!$objContenedor->id){                    
                DB::rollBack();
                App::abort(500, 'La importacion no fue creada, se genero un problema en la creacion de la carga [error 204]');
            }   
        }elseif($request->emim_tipo_carga == 3){
            #Crea todas las proformas asociadas en la tabla
            $cantidad = intval($request->tablaContenedorGuardar);
            $contador = 1;
            do {
                $objContenedor1 = new TContenedorEmbarque;
                $objContenedor1->cont_embarque = $ObjectUpdate->id;

                $tipoContenedor1 = "$contador"."-tipocont";
                $objContenedor1->cont_tipo_contenedor = $request->$tipoContenedor1;

                $cantidad1 = "$contador"."-cantidad";
                $objContenedor1->cont_cantidad = $request->$cantidad1;

                $numeroImportacion1 = "$contador"."-numeroImportacion";
                $objContenedor1->cont_numero_contenedor = $request->$numeroImportacion1;

                $cubicaje1 = "$contador"."-cubicaje";
                $objContenedor1->cont_cubicaje = $request->$cubicaje1;

                $peso1 = "$contador"."-peso";
                $objContenedor1->cont_peso = $request->$peso1;

                $objContenedor1->save();
                $contador++;
            } while ($contador <= $cantidad);

        }
         //Redirecciona a la pagina de consulta y muestra mensaje
        Session::flash('message', 'El proceso de embarque fue editado exitosamente!');
        return Redirect::to($url);
    }

    /**
     * destroy
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


 /**
    * consultas
    * 
    * Esta funcion genera un array de arrays indexado con palabras cuya funcionalidad es proveer la consulta necesaria para pintar los combobox en los formularios
    *
    */
 public function consultas($consulta){

    $combos = array();
        // Combobox puertos
    if(in_array(1, $consulta)){
        $array = Cache::remember('tipocarga', 60, function() {return TTipoCarga::all();});
        $tipocarga = array();
        foreach ($array as $key => $value) {$tipocarga["$value->id"] = $value->tcar_descripcion;}
        $combos['tipocarga'] = $tipocarga;
    }

    // Combobox contenedores
    if(in_array(1, $consulta)){
        $array = Cache::remember('tipocontenedor', 60, function() {return TTipoContenedor::all();});
        $contenedores = array();
        foreach ($array as $key => $value) {$contenedores["$value->id"] = $value->tcont_descripcion;}
        $combos['contenedores'] = json_encode($contenedores);
    }

    // Combobox contenedores
    if(in_array(3, $consulta)){
        $array = Cache::remember('lineamaritima', 60, function() {return TLineaMaritima::all();});
        $lineasMaritimas = array();
        foreach ($array as $key => $value) {$lineasMaritimas["$value->id"] = $value->lmar_descripcion;}
        $combos['lineasMaritimas'] = $lineasMaritimas;
    }

    return $combos;
}



}