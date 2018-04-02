<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class NegociacionAnoAnterior
 */
class NegociacionAnoAnterior extends Model
{
	use SoftDeletes;
	
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_negoanoanterior';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'nant_descripcion',
    ];

}
