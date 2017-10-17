<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolestado
 */
class TSolestado extends Model
{
    protected $table = 't_solestado';

    protected $primaryKey = 'soe_id';

	public $timestamps = false;

    protected $fillable = [
        'soe_descripcion',
        'soe_estado'
    ];

    protected $guarded = [];

        
}