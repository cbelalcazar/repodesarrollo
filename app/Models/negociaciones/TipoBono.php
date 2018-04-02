<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoBono
 */
class TipoBono extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipobono';

    protected $fillable = [
        'tib_id',  
        'tib_descripcion',  
        'tib_estado',
    ];

}