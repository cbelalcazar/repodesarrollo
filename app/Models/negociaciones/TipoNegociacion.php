<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TipoNegociacion extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tiponegociacion';

    public $incrementing = false;

    protected $primaryKey = 'tin_id';

    public $timestamps = false;

    protected $fillable = [
        'tin_descripcion',
        'tin_ayuda',
        'tin_aplicafoto',
        'tin_aplicaacta',
        'tin_estado'
    ];

}
