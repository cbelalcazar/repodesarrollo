<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TipNegociacion extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipnegociacion';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'tneg_descripcion',
    ];

}
