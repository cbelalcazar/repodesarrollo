<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TOrigenMercanciaImportacion
 */
class TOrigenMercanciaImportacion extends Model
{
    protected $table = 't_origen_mercancia_importacion';

    public $timestamps = true;

    protected $fillable = [
        'omeim_importacion',
        'omeim_origen_mercancia'
    ];

     protected $connection = 'importacionesV2';

}
