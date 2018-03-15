<?php

namespace App\Http\Controllers\recepcionproveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\bd_wmsmaterialempaque\TEntradawm;
use App\Models\bd_wmsmaterialempaque\TRefentrada;
use App\Models\unoeereal\T021MmTiposDocumentos;
use App\Models\BESA\BodegasUbicaciones;
use App\Models\recepcionProveedores\TEntradaInventario;
use App\Http\Controllers\generalPlanoSiesa\planosSiesaController;
use App\Http\Controllers\recepcionProveedores\ProgramacionController;
use App\Models\recepcionProveedores\TBodega;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class docEntradaAlmacenController extends Controller
{

  protected $planoSiesaController;
  protected $programacionController;


  /**
   * Constructor
   */
  public function __construct(planosSiesaController $planoSiesaController, ProgramacionController $programacionController){
    $this->planoSiesaController = $planoSiesaController;
    $this->programacionController = $programacionController;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $ruta = "Sistema de Administracion de Almacenamiento (WMS) // Validacion Documentos en Ciego";
    $titulo =  "Validacion documento ciego";
    return view('layouts/recepcionproveedores/wmsmaterialempaque/indexValidacionCiego', compact('ruta' , 'titulo'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function docEntradaAlmacenGetInfo()
  {
    // Falta un join con bd_wmsservi.t_tiposubicacion
    $entradas = TEntradawm::where([['entm_txt_estadocreacion', 'Cerrado'], ['entm_txt_estadodocumento', 'En Proceso']])->orderBy('entm_int_id')->get();
    $response = compact('entradas');
    return response()->json($response);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $ruta = "Sistema de Administracion de Almacenamiento (WMS) // Validacion de Documentos en Ciego";
    $titulo =  "Validacion documento en ciego";
    $info = $id;
    return view('layouts/recepcionproveedores/wmsmaterialempaque/formValidDocCiego', compact('ruta', 'titulo', 'info'));
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function formValidacionCiegoGetInfo(Request $request)
  {
    $data = $request->all();
    // esto consulta toda la informacion de la entrada
    $entrada = TEntradawm::with('TRefentrada', 'TCita.programaciones', 'TSucursalProveedor', 'TRefentrada.item')->where('entm_int_id', $data[0])->first();

    //Consulta para llenar el combobox de tipos de documentos
    $tiposDocumentos = T021MmTiposDocumentos::where([['f021_id','like','E%'], ['f021_id_flia_docto', '03']])->get();

    //Esto lo realizo para seleccionar el campo del combobox tipos de documentos
    $documentoSeleccionado = T021MmTiposDocumentos::where('f021_id', $entrada['entm_txt_tipo_documento'])->get();

    if (count($documentoSeleccionado) > 0) {
      $entrada['entm_txt_tipo_documento'] = $documentoSeleccionado[0];
    }

    // Obtengo los codigos de bodega del catalogo creado
    $catalogoBodega = TBodega::all();
    // Obtengo las ubicaciones de las bodegas
    $bodegasUbica = BodegasUbicaciones::whereIn('id_bodega', $catalogoBodega->pluck('bod_codigo')->all())->get();

    // Agrego a cada referencia su programacion 
    $referenciasConProgramacion = collect($entrada['TRefentrada'])->map(function($item, $key) use($entrada){
      
      $obtengoProgramacion = collect($entrada['TCita']['programaciones'])->where('prg_referencia', $item['rec_txt_referencia'])->values();

      if (count($obtengoProgramacion) > 0) {
        $item->programacion = $obtengoProgramacion[0];
        $item->ordenCompra = DB::connection('besa')->table('102_OrdenCompra')
            ->where('TipoDocto', $obtengoProgramacion[0]['prg_tipo_doc_oc'])
            ->where('CO', $obtengoProgramacion[0]['prg_centro_operacion'])
            ->where('ConsDocto', $obtengoProgramacion[0]['prg_num_orden_compra'])
            ->take(1)
            ->get();  

        // $item->bodega = BodegasUbicaciones::where('id_bodega', $item->ordenCompra[0]->cod_bodega)->get();
        $item->bodega = $item->ordenCompra[0]->cod_bodega;
      }
      else{
        $item->programacion = null;
        $item->ordenCompra = null;
        $item->bodega = null;
      }


      
      
      return $item;
    });

    $response = compact('data', 'entrada', 'tiposDocumentos', 'referenciasConProgramacion', 'bodegasUbica');
    return response()->json($response);
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function guardarEntrada(Request $request)
  {
    try {

      // Obtengo la informacion de la entrada
      $information = $request->all();
      // Guardo la informacion general de la entrada
      $updateEntrada = $this->guardaCambiosEntrada($information);

      $arregloReferencias = [];
      // En cada posicion del arreglo de referencias genero un string con centro de operacion, tipo de documento y numero de orden de compra,
      foreach ($information['t_refentrada'] as $key => $value) {
        // Guardo los cambios generados en cada referencia en la vista
        $referencia = $this->guardarReferencia($value);

        // Obtengo la informacion de la orden de compra si tiene programacion
        if ($value['programacion'] != null) {
          $programacion = $value['programacion'];
          $value['refGroupBy'] = trim($programacion['prg_centro_operacion']) . '-' .  trim($programacion['prg_tipo_doc_oc']) . '-' .  trim($programacion['prg_num_orden_compra'] . '-' .  trim($value['ordenCompra'][0]['suc_proveedor']));
          // Obtengo la informacion de orden de compra si no tiene programacion
        }elseif(isset($value['ocACargar']) && $value['ocACargar'] != null){
          $ocAcargar = $value['ocACargar'];
          $value['refGroupBy'] = trim($ocAcargar['CO']) . '-' .  trim($ocAcargar['TipoDocto']) . '-' .  trim($ocAcargar['ConsDocto']) . '-' .  trim($ocAcargar['suc_proveedor']);
          
        } 
        array_push($arregloReferencias, $value);              
      }  

      // Agrupo el arreglo de referencias por el string anteriormente generado
      $refAgrupadasPorOC = collect($arregloReferencias)->groupBy('refGroupBy');

      // Consulta la estructura del archivo
      $estructura =  TEntradaInventario::all();
      // Setea la estructura del arreglo guardada en la tabla TEntradaInventario
      $this->planoSiesaController->setEstructura($estructura);
      // Genera la linea inicial del plano
      $this->planoSiesaController->generarLineaInicial();

      $listaLineas = [];
      $incrPorEncabezado = 1;
      // Recorre el arreglo de referencias agrupadas por orden de compra
      // Por cada orden de compra se genera un encabezado
      foreach ($refAgrupadasPorOC as $key => $referencias) {        

        $cantidadTotalCajas = collect($referencias)->pluck('rec_int_cajas')->sum();        

        $stringOc = explode("-", $key);   

        // //  +++debo consultar la orden de compra y obtener la sucursal para ponerla en el encabezado del plano   

        // $ordenCompra = DB::connection('besa')->table('102_OrdenCompra')
        //     ->where('TipoDocto', $stringOc[1])
        //     ->where('CO', $stringOc[0])
        //     ->where('ConsDocto', $stringOc[2])
        //     ->take(1)
        //     ->get();  

        // arreglo con donde la primera posicion contiene un arreglo con el tipo del documento un string en donde se debe guardar la linea que se genera y un arreglo que debe guardar cualquier error que se presente en su comparacion con la base de datos segun la estructura del plano enviada por siesa
        $lineaEncabezado = 
        [
          [
            'tipoDocumento' => 'a',
            'txtLineaGenerada' => '',
            'arrayErrores' => []
          ],
          // Este arreglo tiene la informacion de cada atributo que sera comparado con el de la base de datos
          // Cuando el campo esta default la posicion toma el valor del campo dco_segmento se le adiciona ademas espacios y ceros
          // Cuando el campo esta vacio la posicion del elemento queda vacia pero con espacios o ceros
          [
            'F_NUMERO-REG' => 'consecutivo',
            'F_TIPO-REG' => 'default',
            'F_SUBTIPO-REG' => 'default',
            'F_VERSION-REG' => 'default',
            'F_CIA' => 'default',
            'F_LIQUIDA_IMPUESTO' => 'default',
            'F_CONSEC_AUTO_REG' => 'default',
            'f350_id_co' => 'default',
            'f350_id_tipo_docto' => $information['entm_txt_tipo_documento']['f021_id'], //Debe seleccionar este elemento en la vista
            'f350_consec_docto' => $incrPorEncabezado , //consecutivo por cada encabezado
            'f350_fecha' => Carbon::parse($information['entm_txt_fechacreacion'])->format('Ymd'), // formato AAAAMMDD
            'f350_id_tercero' => $information['entm_txt_idproveedor'],
            'f350_id_clase_docto' => 'default',
            'f350_ind_estado' => 'default',
            'f350_ind_impresión' => 'default',
            'f350_notas' => $information['entm_txt_observaciones'],
            'f451_id_concepto' => 'default',
            'f451_id_grupo_clase_docto' => 'default',
            'f451_id_sucursal_prov' => $stringOc[3], // debo consultar la sucursal en genericas sucursal proveedor la que tenga menor numero
            'f451_id_tercero_comprador' => '31578808', // pendiente verificar oscar
            'f451_num_docto_referencia' => substr($information['entm_txt_factura'], 0, 12), //substring
            'f451_id_moneda_docto' => 'COP', // * pendiente verificar oscar COP
            'f451_id_moneda_conv' => 'default',
            'f451_tasa_conv' => 'default',
            'f451_id_moneda_local' => 'default',
            'f451_tasa_local' => 'default',
            'f451_tasa_dscto_global1' => 'default',
            'f451_tasa_dscto_global2' => 'default',
            'f462_id_vehiculo' => 'vacio',
            'f462_id_tercero_transp' => 'vacio',
            'f462_id_sucursal_transp' => 'vacio',
            'f462_id_tercero_conductor' => 'vacio',
            'f462_nombre_conductor' => 'vacio',
            'f462_identif_conductor' => 'vacio',
            'f462_numero_guia' => 'vacio',
            'f462_cajas' => $cantidadTotalCajas, // cantiadad cajas total de toda la entrada
            'f462_peso' => 'vacio',
            'f462_volumen' => 'vacio',
            'f462_valor_seguros' => 'vacio',
            'f462_notas' => 'vacio',
            'f451_ind_consignacion' => 'vacio',
            'f420_id_co_docto' => $stringOc[0], 
            'f420_id_tipo_docto' => $stringOc[1],
            'f420_consec_docto' => $stringOc[2], // consecutivo orden de compra 
            'f420_ind_modo_sobrecosto' => 'default'
          ]
        ];

        // CUANDO ES MATERIA PRIMA SE CARGA A LA MP001 SI ES MATERIAL DE EMPAQUE ME001 SI ES MATERIAL POP DISMK
        // DENTRO DE CADA BODEGA EXISTEN UBICACIONES. 

        $lineaEncabezado = $this->planoSiesaController->validaArreglos($lineaEncabezado);
        array_push($listaLineas, $lineaEncabezado);
        $consecDetalle = 1;

        // Por cada referencia de la orden de compra se genera un detalle
        foreach ($referencias as $key => $value) {

            if ($value['ubicacion']['id_ubic'] == 'No Aplica') {
              $value['ubicacion']['id_ubic'] = "";
            }

            $lineaDetalle = [
              [
                'tipoDocumento' => 'b',
                'txtLineaGenerada' => '',
                'arrayErrores' => []
              ],
              [
              'F_NUMERO-REG' => 'consecutivo',
              'F_TIPO-REG' => 'default',
              'F_SUBTIPO-REG' => 'default',
              'F_VERSION-REG' => 'default',
              'F_CIA' => 'default',
              'f470_id_co' => 'default',
              'f470_id_tipo_docto' => 'EAC', // Debo hacer catalogo 
              'f470_consec_docto' => $incrPorEncabezado, // deben tener todos el mismo consecutivo del encabezado
              'f470_nro_registro' => $consecDetalle++, // * Incrementa en el numero de movimientos que tenga el archivo plano 
              'f_campo' => 'vacio',
              'f470_id_bodega' => $value['ubicacion']['id_bodega'], // * Catalogo bodegas entreprise 
              'f470_id_ubicacion_aux' => $value['ubicacion']['id_ubic'],// * ubicaciones por bodega enterprise 
              'f470_id_lote' => $value['rec_txt_lote'], // * por cada referencia su respectivo lote trefentrada -rec-txt-lote 
              'f470_id_unidad_medida' => $value['item']['unidadMedida'], // * se obtiene de genericas item - unidad de medida 
              'f421_fecha_entrega' => Carbon::parse($value['ordenCompra'][0]['f421_fecha_entrega'])->format('Ymd'), // * entm_txt_fechacreacion 
              'f470_cant_base' => $value['rec_int_cantidad'], // * t_refentrada - rec_int_cantidad 
              'f470_cant_2' => 'default',
              'f470_notas' => $information['entm_txt_observaciones'], // observaciones de todo el movimiento 
              'f470_id_item' => 'vacio',
              'f470_referencia_item' => $value['rec_txt_referencia'], //  * trefentrada - rec_txt_referencia 
              'f470_codigo_barras' => 'vacio',
              'f470_id_ext1_detalle' => 'vacio',
              'f470_id_ext2_detalle' => 'vacio',
              'f470_id_ccosto_movto' => '', 
              'f470_id_proyecto' => 'vacio',
              'f470_rowid' => 'default'
              ]
            ];

            $lineaDetalle = $this->planoSiesaController->validaArreglos($lineaDetalle);
            array_push($listaLineas, $lineaDetalle);

        }      
        $incrPorEncabezado++;         
      }
      // Genera la linea final del plano
      $this->planoSiesaController->generarLineaFinal();
      // Obtiene los txt generados en el proceso
      $txtXml = $this->planoSiesaController->generarLineaTxt();
      $txtPlano = $this->planoSiesaController->txtPlano;
      $respuesta = $this->planoSiesaController->enviarNusoap();
      $respuesta = array_values($respuesta);
      if (isset($respuesta[0]['diffgram']['NewDataSet']['Table'])) {
        $respuesta = collect($respuesta[0]['diffgram']['NewDataSet'])->pluck('f_detalle')->toArray();
        if (count($respuesta) > 0) {          
          $erroresNusoap = [];
          foreach ($respuesta as $key => $value) {
            array_push($erroresNusoap, utf8_decode($value));
          }
        }
      }

      $url = route('docEntradaAlmacen.index');
      $response = compact('information', 'refAgrupadasPorOC', 'txtXml', 'txtPlano', 'listaLineas', 'erroresNusoap', 'lineaEncabezado', 'url');
      return response()->json($response);

      // captura la informacion.
    } catch (Exception $e) {
      return response()->json($e);
    }

  }

  
  public function guardaCambiosEntrada($information)
  {
    extract($information);

    if ($entm_txt_naverias == null && $entm_txt_ndiferenciaunidad == null && $entm_txt_nincofactura == null && $entm_txt_nmcdindocuemnto == null && $entm_txt_nmcmalrotulada == null && $entm_txt_notros == null) {
      $information['entm_txt_sinnovedad'] = 'Si';
    }


    $information['entm_txt_usumonta'] = Auth::user()->login;
    $fechaActual = Carbon::now();
    $information['entm_txt_fechamonta'] = $fechaActual->format('Y-m-d');
    $information['entm_txt_horamonta'] = $fechaActual->toTimeString();
    $information['entm_txt_tipo_documento'] = $information['entm_txt_tipo_documento']['f021_id'];
    unset($information['t_cita'], $information['t_refentrada'], $information['t_sucursal_proveedor']);
    return TEntradawm::where('entm_int_id', $entm_int_id)->update($information);      

  }

  public function guardarReferencia($referencia)
  {
    unset($referencia['programacion'], $referencia['ocACargar'], $referencia['item'], $referencia['bodega'], $referencia['ubicacion'], $referencia['ordenCompra']);
    return TRefentrada::where('rec_int_id', $referencia['rec_int_id'])->update($referencia);
  }

  

  public function generarProgramacion(Request $request){
    $data = $request->all();
    $respuesta = $this->programacionController->referenciasPorOc($request, $data);
    $response = compact('respuesta');
    return response()->json($response);
  }
}
