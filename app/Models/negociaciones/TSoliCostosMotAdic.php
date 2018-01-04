<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliCostosMotAdic
 */
class TSoliCostosMotAdic extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicostosmotadic';

    protected $fillable = [
        'sca_id',  
        'sca_soc_id',  
        'sca_mta_id',
        'sca_valor',
        'sca_mostrar',
        'sca_estado',
    ];

    public function motAdicion(){
      return $this->hasOne('App\Models\negociaciones\TMotivoAdicional', 'mta_id', 'sca_mta_id');
    }
}