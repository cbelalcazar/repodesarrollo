<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TFormaPago extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_forma_pago';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'fpag_descripcion'
    ];

}
