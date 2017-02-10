<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TContenedorEmbarque
 */
class TContenedorEmbarque extends Model
{
    use SoftDeletes;

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

}
