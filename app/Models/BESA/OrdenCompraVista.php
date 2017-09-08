<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraVista extends Model
{
    protected $connection = 'besa';

    protected $table = '102_OrdenCompra';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'CO',
        'TipoDocto',
        'ConsDocto',
        'Fecha',
        'Concepto',
        'NomConcepto',
        'EstadoDocto',
        'desc_estado_docto',
        'IdProducto',
        'Referencia',
        'DescripcionReferencia',
        'CodTipodeInventario',
        'NomTipodeInventario',
        'TipoInventario',
        'IdTercero',
        'NitTercero',
        'RazonSocialTercero',
        'Establecimiento',
        'CantPedida',
        'CantEntrada',
        'CantPendiente',
        'f421_fecha_entrega',
        'EstadoMovto',
        'f421_rowid',
        'f421_rowid_movto_entidad',
        'f420_fecha_ts_cumplido',
        'UndOrden',
    ];

    public function refProgramables(){
    	return $this->hasOne('App\Models\recepcionProveedores\TInfoReferencia', 'iref_referencia', 'Referencia');
    }

    public function OrdenesProgramadas(){
    	return $this->hasOne('App\Models\recepcionProveedores\TProgramacion', 'prg_consecutivoRefOc', 'f421_rowid');
    }
}
