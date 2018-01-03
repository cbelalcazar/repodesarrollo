<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliCostos
 */
class TSoliCostos extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicostos';

    protected $fillable = [
        'soc_id',
        'soc_sol_id',  
        'soc_tbt_id',  
        'soc_valornego',
        'soc_granvalor',  
        'soc_iva',
        'soc_subtotalcliente',
        'soc_retefte',
        'soc_reteica',
        'soc_reteiva',
        'soc_total',
        'soc_formapago',
        'soc_denominacionbono',
    ];

    public function lineas(){
      return $this->hasMany('App\Models\negociaciones\TSoliCostosLineas', 'scl_soc_id', 'soc_id');
    }

}