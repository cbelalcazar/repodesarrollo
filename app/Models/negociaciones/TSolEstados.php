<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolEstados
 */
class TSolEstados extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solestados';

    protected $fillable = [
        'ser_id',
        'ser_descripcion',  
        'ser_orden',  
        'ser_estado',
    ];

}