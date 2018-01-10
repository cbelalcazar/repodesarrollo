<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliReviExhibicion extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solireviexhibicion';

    public $incrementing = false;

    protected $primaryKey = 'sre_id';

    public $timestamps = false;

    protected $fillable = [
        'sre_sol_id',
        'sre_foto',
        'sre_cumplio',
        'sre_puntovento',
        'sre_observacion',
        'sre_usuario',
        'sre_fecha',
        'sre_estado',
    ];

    public function usuario(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'sre_usuario');
    }
}