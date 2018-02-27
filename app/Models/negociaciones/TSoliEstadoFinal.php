<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliEstadoFinal
 */
class TSoliEstadoFinal extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_soliestadofinal';

    protected $fillable = [
        'sef_id',
        'sef_descripcion', 
        'sef_estado',
    ];

}