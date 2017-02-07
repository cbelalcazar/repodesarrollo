<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TMetrica
 */
class TMetrica extends Model
{
    protected $table = 't_metrica';

    public $timestamps = true;

    protected $fillable = [
        'met_nombre',
        'met_numero_dias'
    ];

     protected $connection = 'importacionesV2';
}
