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

    public $incrementing = true;

    public $primaryKey = 'soc_id';

    public $timestamps = false;

    protected $fillable = [
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

    public function tipoBono(){
      return $this->hasOne('App\Models\negociaciones\TipoBonoTerc', 'tbt_id', 'soc_tbt_id');
    }

    public function motivo(){
      return $this->hasMany('App\Models\negociaciones\TSoliCostosMotAdic', 'sca_soc_id', 'soc_id');
    }

    public function detalle(){
      return $this->hasOne('App\Models\negociaciones\TSoliCostosDetAdic', 'scd_soc_id', 'soc_id');
    }

}