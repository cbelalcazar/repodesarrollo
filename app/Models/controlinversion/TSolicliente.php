<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicliente
 */
class TSolicliente extends Model
{
    protected $table = 't_solicliente';

    protected $primaryKey = 'scl_id';

	public $timestamps = false;

    protected $fillable = [
        'scl_sci_id',
        'scl_cli_id',
        'scl_nombre',
        'scl_ventaesperada',
        'scl_desestimado',
        'scl_por',
        'scl_estado'
    ];

    protected $guarded = [];

        
}