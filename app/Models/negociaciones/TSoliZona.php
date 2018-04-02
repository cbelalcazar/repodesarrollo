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

    public $incrementing = false;

    protected $primaryKey = 'szn_id';

    public $timestamps = false;


    protected $fillable = [
        'szn_sol_id',  
        'szn_coc_id',  
        'szn_ppart',
        'szn_estado',
    ];

    public function hisZona(){
      return $this->hasOne('App\Models\Genericas\TCentroOperaciones', 'cen_id', 'szn_coc_id');
    }
}