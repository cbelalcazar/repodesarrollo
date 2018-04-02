<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoBonoTerc
 */
class TipoBonoTerc extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipobonoterc';

    protected $fillable = [
        'tbt_id',
        'tbt_tib_id',  
        'tbt_idTercero',  
        'tbt_estado',
    ];

    public function bono(){
      return $this->hasOne('App\Models\negociaciones\TipoBono', 'tib_id', 'tbt_tib_id');
    }

}