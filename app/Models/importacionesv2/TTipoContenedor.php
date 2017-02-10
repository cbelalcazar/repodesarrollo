<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTipoContenedor
 */
class TTipoContenedor extends Model
{
    use SoftDeletes;

    protected $table = 't_tipo_contenedor';

    public $timestamps = true;

    protected $fillable = [
        'tcont_descripcion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
