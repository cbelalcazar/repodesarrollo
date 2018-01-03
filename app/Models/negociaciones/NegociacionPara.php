<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class NegociacionPara extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_negociacionpara';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'npar_descripcion',
    ];

}
