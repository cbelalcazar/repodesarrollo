<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTiemposTransito
 */
class TTiemposTransito extends Model
{
    use SoftDeletes;

    protected $table = 't_tiempos_transito';

    public $timestamps = true;

    protected $fillable = [
        'tran_embarcador',
        'tran_puerto_embarque',
        'tran_linea_maritima',
        'tran_tipo_carga',
        'tran_numero_dias'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}