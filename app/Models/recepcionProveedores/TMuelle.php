<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TMuelle
 */
class TMuelle extends Model
{
	 use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_muelles';

    public $timestamps = true;

    protected $fillable = [
        'mu_abreviatura',
        'title'
    ];

    protected $guarded = [];
        
}