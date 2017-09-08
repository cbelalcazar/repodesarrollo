<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use DB;

/**
 * Class TProgramacion
 */
class TProgramacion extends Model
{
    use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_programacion';

    public $timestamps = true;

    protected $fillable = [
    'prg_num_orden_compra',
    'prg_tipo_doc_oc',
    'prg_referencia',
    'prg_desc_referencia',
    'prg_nit_proveedor',
    'prg_razonSocialTercero',
    'prg_fecha_programada',
    'prg_cant_programada',
    'prg_cant_solicitada_oc',
    'prg_cant_entregada_oc',
    'prg_cant_pendiente_oc',
    'prg_prioridad',
    'prg_estado',
    'prg_observacion',
    'prg_tipo_programacion',
    'prg_fecha_ordenCompra',
    'prg_consecutivoRefOc', 
    'prg_tipoempaque',
    'prg_cantidadempaques',
    'prg_unidadreferencia'
    ];

    protected $guarded = [];

    /**
     * consProveePorMesUnoeMatEmpaq($fechaInicial, FechaFinal)
     * 
     * Esta funcion consulta y retorna los proveedores que debo evaluar para un mes en especifico solo de material de empaque
     * Ambas deben tener los mismos filtros siempre su unica diferencia es que una agrupa y la otra no.
     * 
     * Filtra por:
     * Tipo de documento
     * Estado de documento
     * Tipo de inventario
     * Fecha de entrega
     *
     * @return ConsultaUNOEE
     */
    public static function referenciasOrOc($nitProveedor, $seleccionConsulta, $refYaProgramadas, $refProgramables){
        if ($seleccionConsulta == 2) {
            return DB::connection('besa')->table('102_OrdenCompra')
            ->select('Referencia', 'DescripcionReferencia')
            ->whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB', 'ONP', 'ONB'])
            ->whereIn('EstadoMovto', ['1', '2'])
            ->whereIn('Referencia', $refProgramables)
            ->whereIn('TipoInventario', ['INMP', 'INVME', 'INSUMOS'])
            ->whereNotIn('f421_rowid', $refYaProgramadas)
            ->where('NitTercero', 'like', "%".$nitProveedor."%")
            ->groupBy('Referencia', 'DescripcionReferencia')
            ->orderBy('Referencia', 'desc')
            ->get();
        } elseif($seleccionConsulta == 1) {
            return DB::connection('besa')->table('102_OrdenCompra')
            ->whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB', 'ONP', 'ONB'])
            ->whereIn('EstadoMovto', ['1', '2'])            
            ->whereIn('TipoInventario', ['INMP', 'INVME', 'INSUMOS'])
            ->whereIn('Referencia', $refProgramables)
            ->whereNotIn('f421_rowid', $refYaProgramadas)
            ->where('NitTercero', 'like', "%".$nitProveedor."%")
            ->get();
        }
        
        
    }

    public static function refExcluir($proveedor){
        return  DB::connection('bd_recepcionProveedores')->table('t_programacion')
                ->select('prg_consecutivoRefOc', DB::raw('SUM(prg_cant_programada) as total_prog, prg_cant_pendiente_oc'))
                ->groupBy('prg_consecutivoRefOc')
                ->havingRaw('SUM(prg_cant_programada) >= prg_cant_pendiente_oc')
                ->where('prg_nit_proveedor', $proveedor['nitTercero'])
                ->get();
    }


    /**
     *
     * @return ConsultaUNOEE
     */
    public static function OcTarea($refYaProgramadas, $refNoProgramables, $hoy, $unaSemanaDespues){
            return DB::connection('besa')->table('102_OrdenCompra')
            ->whereIn('TipoDocto', ['OC', 'OCB', 'OMB', 'OMC', 'OR', 'ORB', 'ONP', 'ONB'])
            ->whereIn('EstadoMovto', ['1', '2'])            
            ->whereIn('TipoInventario', ['INMP', 'INVME', 'INSUMOS'])
            ->whereNotIn('Referencia', $refNoProgramables)
            ->whereNotIn('f421_rowid', $refYaProgramadas)
            ->where('f421_fecha_entrega', '<', $unaSemanaDespues)
            ->get();        
    }

    public static function ordenesExcluirTarea(){
        return  DB::connection('bd_recepcionProveedores')->table('t_programacion')
                ->select('prg_consecutivoRefOc', DB::raw('SUM(prg_cant_programada) as total_prog, prg_cant_pendiente_oc'))
                ->groupBy('prg_consecutivoRefOc')
                ->havingRaw('SUM(prg_cant_programada) >= prg_cant_pendiente_oc')
                ->get();
    }


}