<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TMuelle
 */
class TBodega extends Model
{
	 use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_bodega';

    public $timestamps = true;

    protected $fillable = [
        'bod_codigo'
    ];

    protected $guarded = [];
        
}