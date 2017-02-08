<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTipoCarga
 */
class TTipoCarga extends Model
{
    use SoftDeletes;

    protected $table = 't_tipo_carga';

    public $timestamps = true;

    protected $fillable = [
        'tcar_descripcion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
