<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoContenedor
 */
class TTipoContenedor extends Model
{
    protected $table = 't_tipo_contenedor';

    public $timestamps = true;

    protected $fillable = [
        'tcont_descripcion'
    ];

     protected $connection = 'importacionesV2';

}
