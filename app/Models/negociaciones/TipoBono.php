<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoBono
 */
class TipoBono extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_tipobono';

    public $incrementing = true;

    protected $primaryKey = 'tib_id';

    public $timestamps = false;

    protected $fillable = [
        'tib_descripcion',  
        'tib_estado',
    ];

    public function bonosTerc(){
      return $this->hasOne('App\Models\negociaciones\TipoBonoTerc', 'tbt_tib_id', 'tib_id');
    }

}