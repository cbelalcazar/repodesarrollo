<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TPeriodo
 */
class TPeriodo extends Model
{
	use SoftDeletes;

	protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_periodo';

    public $timestamps = true;

    protected $fillable = [
        'per_fecha_inicio',
        'per_fecha_fin'
    ];

    protected $guarded = [];

    protected $dates = ['deleted_at'];

        
}