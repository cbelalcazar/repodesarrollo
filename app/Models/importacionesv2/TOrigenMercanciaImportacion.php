<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TOrigenMercanciaImportacion
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TOrigenMercanciaImportacion extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_origen_mercancia_importacion';

    public $timestamps = true;

    protected $fillable = [
        'omeim_importacion',
        'omeim_origen_mercancia'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

       public function importacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TImportacion', 'omeim_importacion', 'id');
    }

     public function origenes()
    {
        return $this->hasMany('App\Models\Importacionesv2\TOrigenMercancia', 'id', 'omeim_origen_mercancia');
    }


}
