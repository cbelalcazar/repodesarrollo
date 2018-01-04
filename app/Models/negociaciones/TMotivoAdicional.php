<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TMotivoAdicional
 */
class TMotivoAdicional extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_motivoadicional';

    protected $fillable = [
        'mta_id',  
        'mta_descripcion',  
        'mta_ayuda',
        'mta_estado',
    ];

}