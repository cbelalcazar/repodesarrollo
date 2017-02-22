<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TMetrica
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TMetrica extends Model
{
    use SoftDeletes;

    protected $table = 't_metrica';

    public $timestamps = true;

    protected $fillable = [
        'met_nombre',
        'met_numero_dias'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function causalesdemora()
   {
       return $this->belongsTo('App\Models\Importacionesv2\TCausalesDemora', 'cdem_metrica', 'id');
   }
}
