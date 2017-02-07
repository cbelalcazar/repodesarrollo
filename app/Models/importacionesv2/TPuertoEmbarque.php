<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPuertoEmbarque
 */
class TPuertoEmbarque extends Model
{
    protected $table = 't_puerto_embarque';

    public $timestamps = true;

    protected $fillable = [
        'puem_nombre'
    ];

     protected $connection = 'importacionesV2';

}
