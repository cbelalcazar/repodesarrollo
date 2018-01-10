<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class LogAuditoria extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_log_auditoria';

    public $incrementing = false;

    protected $primaryKey = 'lga_id';

    public $timestamps = false;

    protected $fillable = [
        'lga_sol_id',  
        'lga_formulario',  
        'lga_valoresantes',  
        'lga_valoresdespues',
        'lga_usuario',
        'lga_fecha',
    ];

    public function usuario(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'lga_usuario');
    }
}