<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipodocumento';

    public $incrementing = false;

    protected $primaryKey = 'tdo_id';

    public $timestamps = false;

    protected $fillable = [
        'tdo_descripcion',  
        'tdo_estado',
    ];

}