<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TProforma
 */
class TProforma extends Model
{
    protected $table = 't_proforma';

    public $timestamps = true;

    protected $fillable = [
        'prof_importacion',
        'prof_numero',
        'prof_fecha_creacion',
        'prof_fecha_entrega',
        'prof_valor_proforma',
        'prof_principal'
    ];

     protected $connection = 'importacionesV2';
}
