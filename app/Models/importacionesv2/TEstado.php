<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TEstado
 */
class TEstado extends Model
{
    protected $table = 't_estados';

    public $timestamps = true;

    protected $fillable = [
        'est_nombre'
    ];

     protected $connection = 'importacionesV2';

}
