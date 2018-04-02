<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ClaseNegociacion
 */
class ClaseNegociacion extends Model
{
	use SoftDeletes;
	
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_clasenegociacion';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'cneg_descripcion',
    ];

}
