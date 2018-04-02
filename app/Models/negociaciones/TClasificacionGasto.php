<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TClasificacionGasto
 */
class TClasificacionGasto extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_clasificaciongasto';

    protected $fillable = [
        'clg_id',
        'clg_descripcion',   
        'clg_estado',
    ];

}