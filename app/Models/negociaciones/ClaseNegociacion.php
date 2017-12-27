<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class ClaseNegociacion extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_clasenegociacion';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cneg_descripcion',
    ];

}
