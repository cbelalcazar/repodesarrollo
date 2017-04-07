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
     // return view('importacionesv2.reportesImportaciones.reporteOrdenes', array('tabla' => $this->tabla, 'titulosTabla' => $this->titulosTabla));

    Excel::create('Archivoprueba', function($excel) {

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






}
