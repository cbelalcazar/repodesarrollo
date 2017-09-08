<?php

namespace App\Http\Controllers\recepcionProveedores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recepcionProveedores\TProgramacion;
use App\Models\recepcionProveedores\TInfoReferencia;
use App\Models\BESA\OrdenCompraVista;
use Carbon\Carbon;
use Mail;
use App\Mail\notifProvCita;

class tareaCitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulo = 'TAREA CITAS';
        $ruta = 'Tarea citas // Crear citas';
        // Obtiene fecha inicio y fin del servidor
        $inicio = Carbon::now()->format('Ymd');
        $fin = Carbon::now()->addDays(2)->format('Ymd');
        // Consulta el unoE y trae las ordenes de compra a programar
        $OrdenCompraVista = OrdenCompraVista::
            whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB', 'ONP', 'ONB'])
            ->whereIn('EstadoMovto', ['1', '2'])            
            ->whereIn('TipoInventario', ['INMP', 'INVME', 'INSUMOS'])
            ->whereBetween('f421_fecha_entrega', [$inicio, $fin])
            ->get();

        // Filtra las ordenes de compra teniendo como criterio que no se encuentren en la tabla de programables y que no exista una programacion ya creada para la misma orden de compra
        $collection = collect($OrdenCompraVista);        
        $OrdenCompraVista = $collection->filter(function ($value, $key) {                               
                                return ($value->refProgramables == null && $value->OrdenesProgramadas == null);
                            })->values();

        // Crea el objeto de la programacion en la base de datos y lo guarda en un array para el envio del correo
        $progAutomaticas = [];
        foreach ($OrdenCompraVista as $key => $value) {
            $objProg = [];
            $objProg['prg_num_orden_compra'] = trim($value->ConsDocto);
            $objProg['prg_tipo_doc_oc'] = trim($value->TipoDocto);
            $objProg['prg_referencia'] = $value->Referencia;
            $objProg['prg_desc_referencia'] = $value->DescripcionReferencia;
            $objProg['prg_nit_proveedor'] = $value->NitTercero;
            $objProg['prg_razonSocialTercero'] = $value->RazonSocialTercero;
            $objProg['prg_fecha_programada'] = Carbon::parse($value->f421_fecha_entrega)->format('Y-m-d');
            $objProg['prg_cant_programada'] = round(intval($value->CantPendiente));
            $objProg['prg_cant_solicitada_oc'] = round(intval($value->CantPedida));
            $objProg['prg_cant_entregada_oc'] = round(intval($value->CantEntrada));
            $objProg['prg_cant_pendiente_oc'] = round(intval($value->CantPendiente));
            $objProg['prg_unidadreferencia'] = $value->UndOrden;
            // Queda en 3 pendiente que confirme proveedor ya que el solicita el dia y en que empaque va a traer la mercancia
            $objProg['prg_estado'] = 3;
            $objProg['prg_tipo_programacion'] = "NoProgramable";
            $objProg['prg_fecha_ordenCompra'] = Carbon::parse($value->f421_fecha_entrega)->format('Y-m-d');
            $objProg['prg_consecutivoRefOc'] = $value->f421_rowid;
            $objProg['prg_id_cita'] = $value->ConsDocto;
            $objeto = TProgramacion::Create($objProg);
            $objProg['id'] = $objeto->id;

            array_push($progAutomaticas, $objProg);
        }

        // Debo agrupar por fecha y luego por proveedor para enviar un solo correo por dia al proveedor.
        $collection = collect($progAutomaticas);
        $progAgrupFecha = $collection->groupBy('prg_fecha_ordenCompra');
        foreach ($progAgrupFecha as $key => $value) {
            $collection1 = collect($value);            
            $progAgrupProv = $collection1->groupBy('prg_nit_proveedor');
            foreach ($progAgrupProv as $nitProveedor => $arrayProveedor) {
                $correoProveedor = ['cabelalcazar@bellezaexpress.com'];
                // Envia correo al proveedor informando las programaciones que tiene para le dia en especifico
                Mail::to($correoProveedor)->send(new notifProvCita($arrayProveedor));
                // Marca el envio del correo
                $idsPrgCorreo = array_pluck($arrayProveedor, 'id');
                $query = TProgramacion::whereIn('id', $idsPrgCorreo)->update(['prg_envioCorreo' => 'Enviado']);
            }
        }
        return view('layouts.recepcionProveedores.programacion.vistaTareaCitas', compact('titulo', 'ruta', 'progAutomaticas'));
    }

}
