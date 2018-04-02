<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliActaEntrega extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_soliactaentrega';

    public $incrementing = false;

    protected $primaryKey = 'sae_id';

    public $timestamps = false;

    protected $fillable = [
        'sae_sol_id',
        'sae_acta',
        'sae_cedula',
        'sae_nombre',
        'sae_direccion',
        'sae_ciudad',
        'sae_observaciones',
        'sae_usuario',
        'sae_fecha',
        'sae_estado',
    ];

    public function usuario(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'sae_usuario');
    }
}