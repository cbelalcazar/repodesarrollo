<?php

namespace App\Models\bd_proveedores;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ContactoProveedor extends Authenticatable
{
    use Notifiable;

    protected $connection = 'bd_proveedores';

    protected $table = 't_contactoproveedor';

    protected $primaryKey = 'con_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'usu_id',
        'con_num_documento',
        'con_txt_nombre',
        'con_txt_correoelec',
        'con_txt_telefono',
        'con_txt_cargo'
    ];

}
