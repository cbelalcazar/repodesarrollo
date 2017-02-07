<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TOrigenMercancium
 */
class TOrigenMercancia extends Model
{
    protected $table = 't_origen_mercancia';

    public $timestamps = true;

    protected $fillable = [
        'ormer_nombre',
        'ormer_requ_cert_origen'
    ];

     protected $connection = 'importacionesV2';

}
