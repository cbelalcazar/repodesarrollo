<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TImportacion;
use App\Models\Importacionesv2\TProductoImportacion;
use App\Models\Importacionesv2\TProforma;
use App\Models\Importacionesv2\TDeclaracion;
use App\Models\Importacionesv2\TContenedorEmbarque;
use App\Models\Importacionesv2\TTipoContenedor;
use App\Models\Importacionesv2\TEstado;
use App\Models\Importacionesv2\TTiemposTransito;
use App\Models\Importacionesv2\TPuertoEmbarque;
use Excel;
use \Cache;
use Carbon\Carbon;

class ReportesImportacionesController extends Controller
{
    //
    public $tabla;
    public $titulosTabla;
    public $variables;

    public function ExcelOrdenesGeneral(Request $request){
         #Genero los where para la consulta dependiendo de los filtros enviados por la vista
        $where = array();
        if($request->imp_estado_proceso != ""){
            $whereEstado = array('imp_estado_proceso', '=', $request->imp_estado_proceso);
            array_push($where, $whereEstado);
        }

        if($where == [] ){
            $importacionConsulta =  TImportacion::with('estado', 'proveedor', 'puerto_embarque', 'inconterm', 'embarqueimportacion.tipoCarga', 'embarqueimportacion.lineamaritima','pagosimportacion', 'nacionalizacionimportacion', 'origenMercancia.origenes')->orderBy('t_importacion.imp_consecutivo', 'desc')->get();
        }elseif($where != [] ){
            $importacionConsulta = TImportacion::with('estado', 'proveedor', 'puerto_embarque', 'inconterm', 'embarqueimportacion.tipoCarga', 'pagosimportacion', 'nacionalizacionimportacion', 'origenMercancia.origenes')->orWhere($where)->get();
        }else{
            $importacionConsulta = array();
        }

  
        $this->titulosTabla = array ('Estado', 'Consecutivo', 'Proveedor', 'Productos', 'Orden proveedor', 'Valor USD', 'Factura No.', 'Valor FOB USD', 'Doc. transporte', 'ETD', 'ETA', 'Puerto de embarque', 'Valor euros', 'Giro anticipo', 'Fecha anticipo', 'Giro saldo total', 'Fecha saldo total', 'Fecha legalizacion', 'Licencia importacion No.', 'Fecha factura', 'TRM liquidacion factura', 'Factura en contabilidad', 'Recibo doc. originales', 'Envio dctos A.A', 'Envio ficha tecnica A.A', 'Envio lista empaque', 'levante', 'Retiro puerto', 'Envio ASN - WMS', 'Llegada BESA', 'Recibo lista emp', 'Envio liquidacion y costeo', 'No. Comex', 'Fecha entrada al sistema', 'Origen de la mercancia', 'Tipo de carga (FCL / LCL)', 'Numero de contenedor', 'Volumen (CBM)', 'Cantidad de CTNS', 'Puerto de embarque', 'Embarcador', 'Linea maritima', 'Agencia de aduanas', 'Transporte Terrestre', 'No. declaracion', 'Vr. arancel', 'Vr. iva', 'Tasa dec imp', 'Factor importacion total', 'Factor importacion logistico', 'Solicitud de booking', 'Confirmacion de booking', 'Entrega del proveedor', 'Pre-inspeccion', 'Tipo de levante', 'Control posterior (Pto - planta)', 'Indicador transito internacional', 'Dias transito', 'Dias NAC SIA', 'Dias retiro de puerto', 'Dias para (ETD)', 'Dias legalizacion', 'Dias ficha tec. antes eta', 'Datos', 'Observaciones');
        $contenidoTabla = array();

        foreach ($importacionConsulta as $key => $value) {
        $fechaBase = $value->imp_fecha_entrega_total;
        $puertoEmbarque = $value->imp_puerto_embarque;
        $estimacion = $this->estimacionFechas($fechaBase, $puertoEmbarque);
          $contenidoFila = array();
    		//ingreso al array la informacion de la consulta de importacion
          array_push($contenidoFila, $value);

    		//ingreso al array la informacion de la consulta de productos asociadoss
          $Productos = TProductoImportacion::with('producto.productoItem')->where('pdim_importacion', '=', $value->id)->get();
          array_push($contenidoFila, $Productos);

    		//Ingreso al array todas las proforas asociadas a la orden de importación
          $proformas = TProforma::where('prof_importacion', '=', $value->id)->get();
          array_push($contenidoFila, $proformas);

            //Ingreso al array todas las declaraciones asociadas a la nacionalizacion y costeo
          $declaraciones = TDeclaracion::where('decl_nacionalizacion', '=', $value->nacionalizacionimportacion['id'])->get();
          array_push($contenidoFila, $declaraciones);

            //Ingreso al array los contenedores asociados.
          $embarque = TContenedorEmbarque::where('cont_embarque', '=', $value->embarqueimportacion['id'])->get();
          $contenedores = array();
          $tipoContenedor = TTipoContenedor::all();
          if($value->embarqueimportacion['emim_tipo_carga'] == 3){

            foreach($tipoContenedor as $key => $value){
                $contador = 0;
                foreach ($embarque as $key1 => $value1) {
                    if($value1->cont_tipo_contenedor ==  $value->id){
                        $contador++;
                    }
                }
                if($contador != 0){                            
                    array_push($contenedores, $contador."X".$value->tcont_descripcion);
                }
            }
        }
        array_push($contenidoFila, $embarque);
        array_push($contenidoFila, $contenedores);
        array_push($contenidoFila, $estimacion);

    		//Agrego todo al array principal
        array_push($contenidoTabla, $contenidoFila);
    }
    $this->tabla = $contenidoTabla;
     return view('importacionesv2.reportesImportaciones.reporteOrdenes', array('tabla' => $this->tabla, 'titulosTabla' => $this->titulosTabla));

    Excel::create('ReporteImportacion', function($excel) {

        $excel->sheet('Hoja 1', function($sheet) {

            $sheet->loadView('importacionesv2.reportesImportaciones.reporteOrdenes', array('tabla' => $this->tabla, 'titulosTabla' => $this->titulosTabla));
        });

    })->download('xls');
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ConsultaImportacionesExportar(Request $request)
    {
     $url = route('ExcelOrdenesGeneral');
     $titulo = "CONSULTAR IMPORTACIONES SABANA";
        //crea los array de las consultas para mostrar en los Combobox
     $consulta = array(1);
     $combos = $this->consultas($consulta);
     extract($combos);
     return view('importacionesv2.reportesImportaciones.consultaReporteOrdenes', 
        compact('url', 'titulo','estados'));
 }




 /**
    * Funcion creada para generar las consultas de los combobox en las funciones create y edit
    *
    */
 public function consultas($consulta){

    $combos = array();

    if(in_array(1, $consulta)){
        $array = Cache::remember('estado', 60, function(){return TEstado::all();});
        $inconterm = array();
        foreach ($array as $key => $value) {$inconterm["$value->id"] = $value->est_nombre;}
        $combos['estados'] = $inconterm;
    }
    return $combos;
}


public function estimacionFechas($fechaBase, $puertoEmbarque){
  $estimacion = [];
  $estimacion['fechaETD'] = Carbon::parse($fechaBase)->subDays(8)->format('d-m-Y');
  $puertoEmbarque = TPuertoEmbarque::where('id', $puertoEmbarque)->first();
  $estimacion['fechaETA'] = Carbon::parse($estimacion['fechaETD'])->addDays($puertoEmbarque->puem_itime)->format('d-m-Y');

  return $estimacion;
}


public function GenerarExcelUAP(){
  $url = route('ReporteUAP');
  $titulo = "GENERAR REPORTE UAP POR FECHAS";
  return view('importacionesv2.reportesImportaciones.consultaUAP', 
        compact('url', 'titulo'));
}


public function ReporteUAP(Request $request){
  $from = Carbon::parse($request->desde)->format('Y-m-d');
  $to = Carbon::parse($request->hasta)->format('Y-m-d');
  $declaracion = TDeclaracion::with('nacionalizacion.importacion.proveedor', 'nacionalizacion.tiponacionalizacion', 'admindianDeclaracion')->whereBetween('decl_fecha_legaliza_giro', array($from, $to))->get();

  $groupDeclaraciones = array();
  $array = array();
  $numero = 0;
  foreach ($declaracion as $key => $value) {    
    if($numero == 0){
      array_push($array, $value);
      $numero = $value->decl_nacionalizacion; 
    }elseif($numero == $value->decl_nacionalizacion){
      array_push($array, $value);
    }elseif($numero != $value->decl_nacionalizacion){
      array_push($groupDeclaraciones, $array);
      $array = array();
      array_push($array, $value);
      $numero = $value->decl_nacionalizacion; 
    }
    if($key == count($declaracion)-1){
      array_push($groupDeclaraciones, $array);
    }
  }

  $arancelesTotal = [];
  $ivaTotal = [];
  $otrosTotal = [];
  $totalArray = [];

  $manualesIva = 0;
  $automaticasIva = 0;
  $sumatodasIva = 0;

  $manualesArancel = 0;
  $automaticasArancel = 0;
  $sumatodasArancel = 0;

  $manualesOtros = 0;
  $automaticasOtros = 0;
  $sumatodasOtros = 0;

  $manualesTotal = 0;
  $automaticasTotal = 0;
  $sumatodasTotal = 0;


  foreach ($groupDeclaraciones as $key => $value) {
    $valorArancelTotal = 0;
    $valorIvaTotal = 0;
    $valorOtrosTotal = 0;
    $valorTotales = 0;
    foreach ($value as $key => $valor) {

      $valorArancelTotal = $valorArancelTotal + $valor->decl_arancel;
      $valorIvaTotal = $valorIvaTotal + $valor->decl_iva;
      $valorOtrosTotal = $valorOtrosTotal + $valor->decl_valor_otros;
      $valorTotales = $valorTotales + $valor->decl_arancel + $valor->decl_iva + $valor->decl_valor_otros;

      $sumatodasArancel = $sumatodasArancel + $valor->decl_arancel;
      $sumatodasIva = $sumatodasIva + $valor->decl_iva;
      $sumatodasOtros = $sumatodasOtros + $valor->decl_valor_otros;
      $sumatodasTotal = $sumatodasTotal + $valor->decl_arancel + $valor->decl_iva + $valor->decl_valor_otros;

      if ($valor->nacionalizacion->naco_tipo_nacionalizacion == 1) {
        $automaticasArancel = $automaticasArancel + $valor->decl_arancel;
      } elseif($valor->nacionalizacion->naco_tipo_nacionalizacion == 2) {
        $manualesArancel = $manualesArancel + $valor->decl_arancel;
      }

      if ($valor->nacionalizacion->naco_tipo_nacionalizacion == 1) {
        $automaticasIva = $automaticasIva + $valor->decl_iva;
      } elseif($valor->nacionalizacion->naco_tipo_nacionalizacion == 2) {
        $manualesIva = $manualesIva + $valor->decl_iva;
      }

      if ($valor->nacionalizacion->naco_tipo_nacionalizacion == 1) {
        $automaticasOtros = $automaticasOtros + $valor->decl_valor_otros;
      } elseif($valor->nacionalizacion->naco_tipo_nacionalizacion == 2) {
        $manualesOtros = $manualesOtros + $valor->decl_valor_otros;
      }

      if ($valor->nacionalizacion->naco_tipo_nacionalizacion == 1) {
        $automaticasTotal = $automaticasTotal + $valor->decl_arancel + $valor->decl_iva + $valor->decl_valor_otros;
      } elseif($valor->nacionalizacion->naco_tipo_nacionalizacion == 2) {
        $manualesTotal = $manualesTotal + $valor->decl_arancel + $valor->decl_iva + $valor->decl_valor_otros;
      }
    }
    array_push($arancelesTotal, $valorArancelTotal);
    array_push($ivaTotal, $valorIvaTotal);
    array_push($otrosTotal, $valorOtrosTotal);
    array_push($totalArray, $valorTotales);
  }

   $this->variables =  compact('groupDeclaraciones','arancelesTotal','ivaTotal','otrosTotal','totalArray','manualesIva','automaticasIva','sumatodasIva','manualesArancel','automaticasArancel','sumatodasArancel','manualesOtros','automaticasOtros','sumatodasOtros','manualesTotal','automaticasTotal','sumatodasTotal');

  Excel::create('ReporteUAP', function($excel) {

        $excel->sheet('Hoja 1', function($sheet) {

            $sheet->loadView('importacionesv2.reportesImportaciones.reporteUAP', $this->variables);
        });

    })->download('xls');
}


}
