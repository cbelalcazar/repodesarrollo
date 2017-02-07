<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTipoImportacion
 */
class TTipoImportacion extends Model
{
    protected $table = 't_tipo_importacion';

    public $timestamps = true;

    protected $fillable = [
        'timp_nombre'
    ];

     protected $connection = 'importacionesV2';

}
