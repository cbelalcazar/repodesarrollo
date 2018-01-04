<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class EventoTemp extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_eventotemp';

    public $incrementing = false;

    protected $primaryKey = 'evt_id';

    public $timestamps = false;

    protected $fillable = [
        'evt_can_id',
        'evt_idTercero',
        'evt_tipo',
        'evt_descripcion',
        'evt_estado',
    ];

}
