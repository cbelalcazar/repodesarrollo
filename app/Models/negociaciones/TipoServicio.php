<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_servicio';

    public $incrementing = false;

    protected $primaryKey = 'ser_id';

    public $timestamps = false;

    protected $fillable = [
        'ser_descripcion',
        'ser_estado',
    ];

}
