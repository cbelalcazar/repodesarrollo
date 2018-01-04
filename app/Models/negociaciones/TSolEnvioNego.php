<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolEnvioNego
 */
class TSolEnvioNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solenvionego';

    protected $fillable = [
        'sen_id',
        'sen_sol_id',  
        'sen_ser_id',  
        'sen_idTercero_envia',  
        'sen_idTercero_recibe',  
        'sen_observacion',  
        'sen_fechaenvio',  
        'sen_estadoenvio',  
        'sen_run_id',
    ];

    public function estadoHisProceso(){
      return $this->hasOne('App\Models\negociaciones\TSolEstados', 'ser_id', 'sen_ser_id');
    }

    public function terceroEnvia(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'sen_idTercero_envia');
    }

    public function terceroRecibe(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'sen_idTercero_recibe');
    }
}