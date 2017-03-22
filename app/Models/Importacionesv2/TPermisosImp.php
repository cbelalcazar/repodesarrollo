<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class TPermisosImp extends Model
{
    protected $table = 't_permisos_imp';
    protected $fillable = [
        'perm_cedula',
        'perm_cargo'
    ];
     protected $connection = 'importacionesV2';
}
