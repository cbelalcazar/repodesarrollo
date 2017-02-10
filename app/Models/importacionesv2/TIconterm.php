<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TIconterm
 */
class TIconterm extends Model
{
    use SoftDeletes;

    protected $table = 't_iconterm';

    public $timestamps = true;

    protected $fillable = [
        'inco_descripcion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

}
