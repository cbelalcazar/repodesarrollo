<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TCausalesNego
 */
class TCausalesNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_causalesnego';

    protected $fillable = [
        'can_id',
        'can_descripcion',  
        'can_ayuda',  
        'can_estado',  
    ];

}