<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCausalesDemora
 */
class TCausalesDemora extends Model
{
    protected $table = 't_causales_demora';

    public $timestamps = true;

    protected $fillable = [
        'cdem_nombre',
        'cdem_metrica'
    ];

     protected $connection = 'importacionesV2';

}
