<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TEstado
 */
class TEstado extends Model
{
    use SoftDeletes;

    protected $table = 't_estados';

    public $timestamps = true;

    protected $fillable = [
        'est_nombre'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
