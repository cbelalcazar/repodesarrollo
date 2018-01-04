<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliZona
 */
class TSoliZona extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solizona';

    protected $fillable = [
        'szn_id',
        'szn_sol_id',  
        'szn_coc_id',  
        'szn_ppart',
        'szn_estado',
    ];

    public function hisZona(){
      return $this->hasOne('App\Models\Genericas\TCoCanal', 'coc_id', 'szn_coc_id');
    }
}