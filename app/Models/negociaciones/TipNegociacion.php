<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TipNegociacion
 */
class TipNegociacion extends Model
{
	use SoftDeletes;

    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipnegociacion';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'tneg_descripcion',
    ];

}
