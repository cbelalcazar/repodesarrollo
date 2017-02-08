<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TTipoImportacion
 */
class TTipoImportacion extends Model
{
    use SoftDeletes;

    protected $table = 't_tipo_importacion';

    public $timestamps = true;

    protected $fillable = [
        'timp_nombre'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
