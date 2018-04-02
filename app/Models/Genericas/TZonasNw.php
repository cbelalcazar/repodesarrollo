<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TZonasNw
 */
class TZonasNw extends Model
{
	protected $connection = 'genericas';

    protected $table = 't_zonas_nw';

    public $timestamps = false;

    protected $fillable = [
        'znw_descripcion',
        'znw_estado'
    ];

    protected $guarded = [];

        
}