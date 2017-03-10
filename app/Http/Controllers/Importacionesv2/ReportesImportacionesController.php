<?php

namespace App\Http\Controllers\Importacionesv2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importacionesv2\TImportacion;
use App\Models\Importacionesv2\TProductoImportacion;
use App\Models\Importacionesv2\TProforma;

class ReportesImportacionesController extends Controller
{
    //
    public function ExcelOrdenesGeneral(Request $request){
    	$importacionConsulta = TImportacion::with('estado', 'proveedor', 'puerto_embarque', 'inconterm', 'embarqueimportacion', 'pagosimportacion', 'nacionalizacionimportacion')->get();

    	$titulosTabla = array ('Estado', 'Consecutivo', 'Proveedor', 'Productos', 'Orden proveedor', 'Valor USD', 'Factura No.', 'Valor FOB USD', 'Doc. transporte', 'ETD', 'ETA', 'Puerto de embarque');
		$contenidoTabla = array();
    	foreach ($importacionConsulta as $key => $value) {
    		$contenidoFila = array();
    		//ingreso al array la informacion de la consulta de importacion
    		array_push($contenidoFila, $value);

    		//ingreso al array la informacion de la consulta de productos asociadoss
    		$Productos = TProductoImportacion::with('producto.productoItem')->where('pdim_importacion', '=', $value->id)->get();
    		array_push($contenidoFila, $Productos);

    		//Ingreso al array todas las proforas asociadas a la orden de importación
    		$proformas = TProforma::where('prof_importacion', '=', $value->id)->get();
    		array_push($contenidoFila, $proformas);
    		//Agrego todo al array principal
    		array_push($contenidoTabla, $contenidoFila);
    	}

    	$tabla = $contenidoTabla;
    	 return view('importacionesv2.reportesImportaciones.reporteOrdenes', 
            compact('tabla',
            		'titulosTabla'));

    }
}
