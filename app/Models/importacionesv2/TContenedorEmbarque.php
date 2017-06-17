<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TContenedorEmbarque
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TContenedorEmbarque extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_contenedor_embarque';

    public $timestamps = true;

    protected $fillable = [
        'cont_embarque',
        'cont_tipo_contenedor',
        'cont_cantidad',
        'cont_numero_contenedor',
        'cont_cubicaje',
        'cont_peso',
        'cont_cajas'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

     public function tipo()
    {
        return $this->hasOne('App\Models\Importacionesv2\TTipoContenedor', 'id', 'cont_tipo_contenedor');
    }

}
