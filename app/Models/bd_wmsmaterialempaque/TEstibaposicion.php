<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TEstibaposicion
 */
class TEstibaposicion extends Model
{
    protected $table = 't_estibaposicion';

    public $timestamps = false;

    protected $fillable = [
        'espo_txt_posicion',
        'espo_txt_estiba',
        'espo_int_cantidad',
        'espo_txt_referencia',
        'espo_txt_lote',
        'espo_txt_undempaque',
        'espo_int_saldo',
        'espo_int_planchas',
        'espo_txt_estado',
        'espo_int_idtipoubicacion',
        'espo_txt_idcliente',
        'espo_txt_idproveedor',
        'espo_int_idpais',
        'espo_int_exportacion',
        'espo_txt_fecha'
    ];

    protected $guarded = [];

        
}