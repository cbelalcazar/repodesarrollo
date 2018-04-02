<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliTesoreriaHis extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solitesoreriahis';

    public $incrementing = false;

    protected $primaryKey = 'sth_id';

    public $timestamps = false;

    protected $fillable = [
        'sth_sol_id',  
        'sth_fecha',  
        'sth_usuario',  
        'sth_tipo',  
        'stn_observaciones',  
        'sth_bonosdesde',
    ];

}