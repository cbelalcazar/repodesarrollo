<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TPuertoEmbarque
 */
class TPuertoEmbarque extends Model
{
    use SoftDeletes;

    protected $table = 't_puerto_embarque';

    public $timestamps = true;

    protected $fillable = [
        'puem_nombre'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
