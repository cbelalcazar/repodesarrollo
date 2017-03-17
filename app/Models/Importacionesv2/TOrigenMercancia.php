<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TOrigenMercancium
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TOrigenMercancia extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_origen_mercancia';

    public $timestamps = true;

    protected $fillable = [
        'ormer_nombre',
        'ormer_requ_cert_origen'
    ];

     protected $connection = 'importacionesV2';

      public function origenMercanciaImportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TOrigenMercanciaImportacion', 'omeim_importacion', 'id');
    }

}
