<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TOrigenMercancium
 */
class TOrigenMercancia extends Model
{
    use SoftDeletes;

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
