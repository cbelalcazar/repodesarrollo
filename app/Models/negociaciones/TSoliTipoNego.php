<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSoliTipoNego
 */
class TSoliTipoNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solitiponego';

    public $incrementing = true;

    public $primaryKey = 'stn_id';

    public $timestamps = false;

    protected $fillable = [
        'stn_sol_id',  
        'stn_tin_id',  
        'stn_ser_id',
        'stn_costo',
        'stn_rtfuente',
        'stn_valor_rtfuente',  
        'stn_retfuente_base',  
        'stn_rtica',
        'stn_valor_rtica',  
        'stn_rtica_base',
        'stn_rtiva',
        'stn_valor_rtiva',  
        'stn_rtiva_base',
        'stn_iva',
        'stn_valor_iva',  
        'stn_iva_base',
        'stn_estado',
    ];

    public function tipoNego(){
      return $this->hasOne('App\Models\negociaciones\TipoNegociacion', 'tin_id', 'stn_tin_id');
    }

    public function tipoServicio(){
      return $this->hasOne('App\Models\negociaciones\TipoServicio', 'ser_id', 'stn_ser_id');
    }


}