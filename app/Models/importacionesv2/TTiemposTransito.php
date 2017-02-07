<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTiemposTransito
 */
class TTiemposTransito extends Model
{
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

}
