<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliCausalNego
 */
class TSoliCausalNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicausalnego';

    public $incrementing = true;

    protected $primaryKey = 'scn_id';

    public $timestamps = false;

    protected $fillable = [
        'scn_sol_id',  
        'scn_can_id',  
        'scn_estado',  
    ];

    public function causalDetalle(){
      return $this->hasOne('App\Models\negociaciones\CausalesNego', 'can_id', 'scn_can_id');
    }

}