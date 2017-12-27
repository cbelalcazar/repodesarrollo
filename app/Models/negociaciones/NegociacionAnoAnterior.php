<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class NegociacionAnoAnterior extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_negoanoanterior';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'nant_descripcion',
    ];

}
