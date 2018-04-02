<?php

namespace App\Models\bd_proveedores;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $connection = 'bd_proveedores';

    protected $table = 't_usuario';

    protected $primaryKey = 'usu_txt_usuario';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'usu_id',
        'uss_txt_clave',
        'usu_txt_registro',
        'usu_txt_ultacceso',
        'usu_num_activo'
    ];

    protected $hidden = [
        'uss_txt_clave',
    ];


    public function setRememberToken($value){}
}
