<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoNegociacion
 */
class TipoNegociacion extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tiponegociacion';

    protected $fillable = [
        'tin_id',
        'tin_descripcion',
        'tin_ayuda',
        'tin_aplicafoto',
        'tin_aplicaacta',
        'tin_estado',
    ];

}