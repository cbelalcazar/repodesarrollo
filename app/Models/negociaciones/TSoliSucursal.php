<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliSucursal
 */
class TSoliSucursal extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solisucursal';

    protected $fillable = [
        'ssu_id',
        'ssu_sol_id',  
        'ssu_suc_id',  
        'ssu_ppart',
        'ssu_estado',
    ];

    public function hisSucu(){
      return $this->hasOne('App\Models\Genericas\TSucursal', 'suc_id', 'ssu_suc_id');
    }

}