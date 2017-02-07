<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TIconterm
 */
class TIconterm extends Model
{
    protected $table = 't_iconterm';

    public $timestamps = true;

    protected $fillable = [
        'inco_descripcion'
    ];

     protected $connection = 'importacionesV2';

}
