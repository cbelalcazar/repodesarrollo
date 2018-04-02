<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliCostosLineas
 */
class TSoliCostosLineas extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicostoslineas';

    public $incrementing = true;

    public $primaryKey = 'scl_id';

    public $timestamps = false;

    protected $fillable = [
        'scl_soc_id',  
        'scl_cat_id', 
        'scl_lin_id',
        'scl_ppart',
        'scl_costo',
        'scl_costoadi',
        'scl_valorventa',
        'scl_pvalorventa',
        'scl_estado', 
    ];

    public function lineasDetalle(){
      return $this->hasOne('App\Models\Genericas\TLineas', 'lin_id', 'scl_lin_id');
    }
}