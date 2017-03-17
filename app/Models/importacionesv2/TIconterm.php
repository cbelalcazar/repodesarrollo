<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TIconterm
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TIconterm extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_iconterm';

    public $timestamps = true;

    protected $fillable = [
        'inco_descripcion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function importacion()
	{
		return $this->belongsTo('App\Models\Importacionesv2\TImportacion', 'imp_iconterm', 'id');
	}
}
