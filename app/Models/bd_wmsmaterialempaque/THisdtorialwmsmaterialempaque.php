<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class THisdtorialwmsmaterialempaque
 */
class THisdtorialwmsmaterialempaque extends Model
{
    protected $table = 't_hisdtorialwmsmaterialempaque';

    protected $primaryKey = 'hiw_int_id';

	public $timestamps = false;

    protected $fillable = [
        'hiw_txt_estiba',
        'hiw_txt_movimiento',
        'hiw_txt_posicion',
        'hiw_txt_referencia',
        'hiw_txt_lote',
        'hiw_int_cantidad',
        'hiw_int_undempaque',
        'hiw_int_cajas',
        'hiw_int_saldo',
        'hiw_txt_idestado',
        'hiw_txt_hora',
        'hiw_txt_fecha',
        'hiw_txt_usuario',
        'hiw_txt_ingreso'
    ];

    protected $guarded = [];

        
}