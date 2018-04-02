<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliVerificacionCobro extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_soliverificacioncobro';

    public $incrementing = false;

    protected $primaryKey = 'svc_id';

    public $timestamps = false;

    protected $fillable = [
        'svc_sol_id',  
        'svc_tdo_id',  
        'svc_idTercero',  
        'svc_ndocumento',  
        'svc_fechadocumento',  
        'svc_formapago',  
        'svc_valorbruto',  
        'svc_diferencia',  
        'svc_fecharecibido', 
        'svc_observaciones',  
        'svc_nprovision',  
        'svc_fecharegistro',  
        'svc_estado',  
        'svc_usuario',
    ];

    public function documento(){
      return $this->hasOne('App\Models\negociaciones\TipoDocumento', 'tdo_id', 'svc_tdo_id');
    }

    public function proveedor(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'svc_idTercero');
    }
}
