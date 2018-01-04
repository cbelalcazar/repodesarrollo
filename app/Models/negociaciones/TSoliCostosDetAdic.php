<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliCostosDetAdic
 */
class TSoliCostosDetAdic extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicostosdetadic';

    protected $fillable = [
        'scd_id',  
        'scd_soc_id',  
        'scd_detalle',
        'scd_valor',
        'scd_estado',
    ];

}