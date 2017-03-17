<?php

namespace App\Models\Importacionesv2;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TCausalesDemora
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TCausalesDemora extends Model
{
    use SoftDeletes;
    use Auditable;
    protected $table = 't_causales_demora';

    public $timestamps = true;

    protected $fillable = [
        'cdem_nombre',
        'cdem_metrica'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function metricas()
    {
        return $this->hasOne('App\Models\Importacionesv2\TMetrica', 'id', 'cdem_metrica');
    }

}
