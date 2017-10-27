<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicitudctlinv
 */
class TSolicitudctlinv extends Model
{

    protected $connection = "bd_controlinversion";

    protected $table = 't_solicitudctlinv';

    protected $primaryKey = 'sci_id';

	public $timestamps = false;

    protected $fillable = [
        'sci_tdc_id',
        'sci_soe_id',
        'sci_tsd_id',
        'sci_mts_id',
        'sci_can_id',
        'sci_fecha',
        'sci_solicitante',
        'sci_periododes_ini',
        'sci_periododes_fin',
        'sci_ventaesperada',
        'sci_descuentoestimado',
        'sci_usuario',
        'sci_tipo',
        'sci_tipono',
        'sci_tipononumero',
        'sci_toc_id',
        'sci_observaciones',
        'sci_tipopersona',
        'sci_cargara',
        'sci_planoprov',
        'sci_cargarlinea',
        'sci_planoprovfecha',
        'sci_totalref',
        'sci_planoobmu',
        'sci_planoobmufecha',
        'sci_cerradaautomatica',
        'sci_fechacierreautomatico',
        'sci_motivodescuento',
        'sci_duplicar',
        'sci_nduplicar',
        'sci_cduplicar',
        'sci_todocanal',
        'sci_nombre',
        'sci_ciudad',
        'sci_direccion',
        'sci_facturara'
    ];

    protected $guarded = [];

    public function clientes(){
      return $this->hasMany('App\Models\controlinversion\TSolicliente', 'scl_sci_id', 'sci_id');
    }

     public function estado(){
      return $this->hasOne('App\Models\controlinversion\TSolestado', 'soe_id', 'sci_soe_id');
    }


}
