<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoBono
 */
class TEventoTemp extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_eventotemp';

    protected $fillable = [
        'evt_id',  
        'evt_can_id',
        'evt_idTercero',  
        'evt_tipo',
        'evt_descripcion', 
        'evt_estado',
    ];

}