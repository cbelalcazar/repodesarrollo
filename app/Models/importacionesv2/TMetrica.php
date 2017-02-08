<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TMetrica
 */
class TMetrica extends Model
{
    use SoftDeletes;

    protected $table = 't_metrica';

    public $timestamps = true;

    protected $fillable = [
        'met_nombre',
        'met_numero_dias'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];
}
