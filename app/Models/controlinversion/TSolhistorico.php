<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolhistorico
 */
class TSolhistorico extends Model
{
    protected $table = 't_solhistorico';

    protected $primaryKey = 'soh_id';

	public $timestamps = false;

    protected $fillable = [
        'soh_sci_id',
        'soh_soe_id',
        'soh_idTercero_envia',
        'soh_idTercero_recibe',
        'soh_observacion',
        'soh_fechaenvio',
        'soh_estadoenvio'
    ];

    protected $guarded = [];

        
}