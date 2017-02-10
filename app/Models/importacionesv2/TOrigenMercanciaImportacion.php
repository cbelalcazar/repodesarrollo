<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TOrigenMercanciaImportacion
 */
class TOrigenMercanciaImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_origen_mercancia_importacion';

    public $timestamps = true;

    protected $fillable = [
        'omeim_importacion',
        'omeim_origen_mercancia'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
