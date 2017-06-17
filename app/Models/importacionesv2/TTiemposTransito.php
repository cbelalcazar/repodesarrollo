<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TTiemposTransito
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTiemposTransito extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_tiempos_transito';

    public $timestamps = true;

    protected $fillable = [
        'tran_embarcador',
        'tran_puerto_embarque',
        'tran_linea_maritima',
        'tran_tipo_carga',
        'tran_numero_dias'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function puerto_embarque()
    {
        return $this->hasOne('App\Models\Importacionesv2\TPuertoEmbarque', 'id', 'tran_puerto_embarque');
    }

     public function tipoCarga()
    {
        return $this->hasOne('App\Models\Importacionesv2\TTipoCarga', 'id', 'tran_tipo_carga');
    }

    public function lineaMaritima()
    {
        return $this->hasOne('App\Models\Importacionesv2\TLineaMaritima', 'id', 'tran_linea_maritima');
    }

    public function embarcador()
    {
        return $this->hasOne('App\Models\Genericas\Tercero', 'nitTercero', 'tran_embarcador');
    }


}
