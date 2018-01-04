<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolicitudNego
 */
class TSolicitudNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicitudnego';

    protected $fillable = [
        'sol_id',
        'sol_evt_id',  
        'sol_soc_id',  
        'sol_ser_id',  
        'sol_ven_id',  
        'sol_sef_id',  
        'sol_set_id',  
        'sol_zona',  
        'sol_can_id',  
        'sol_cli_id',  
        'sol_lis_id',  
        'sol_fecha', 
        'sol_clase',  
        'sol_tipocliente',  
        'sol_descomercial',  
        'sol_peri_facturaini',  
        'sol_peri_facturafin',  
        'sol_mesesfactu',  
        'sol_peri_ejeini',  
        'sol_peri_ejefin',  
        'sol_meseseje',  
        'sol_observaciones',  
        'sol_clasificacion',  
        'sol_ppresupuestozona',  
        'sol_valorpresupuestozona',  
        'sol_ppresupuestocanal',  
        'sol_valorpresupuestocanal',  
        'sol_valorpresupuestomerca',  
        'sol_ppresupuestomerca',  
        'sol_tipoacta',  
        'sol_llegoacta',  
        'sol_obstesoreriabono',  
        'sol_fechatesorbono',  
        'sol_fechacomparacionini',  
        'sol_fechacomparacionfin',  
        'sol_mesescomp',  
        'sol_observacion_objetivos', 
        'sol_ventaestimada',  
        'sol_correofechaejecucion', 
        'sol_observacionanulacion',  
        'sol_observacioncameje',  
        'sol_tipo',
        'sol_obsconfirbono', 
        'sol_fechaconfirbono', 
        'sol_obsdesconfirbono', 
        'sol_fechadesconfirbono', 
        'sol_estadocobro', 
        'sol_fechalimiteeval', 
        'sol_huella_capitalizar',  
        'sol_fechaaprobaciontotal',
    ];

    public function getSolCanIdAttribute($value){
        return trim($value);
    }

    public function costo(){
      return $this->hasOne('App\Models\negociaciones\TSoliCostos', 'soc_sol_id', 'sol_id');
    }

    public function estado(){
      return $this->hasOne('App\Models\negociaciones\TSolEstados', 'ser_id', 'sol_ser_id');
    }

    public function evento(){
      return $this->hasOne('App\Models\negociaciones\EventoTemp', 'evt_id', 'sol_evt_id');
    }

    public function clasificacion(){
      return $this->hasOne('App\Models\negociaciones\TClasificacionGasto', 'clg_id', 'sol_clasificacion');
    }

    public function cliente(){
      return $this->hasOne('App\Models\Genericas\TCliente', 'cli_id', 'sol_cli_id');
    }

    public function canal(){
      return $this->hasOne('App\Models\Genericas\TCanal', 'can_id', 'sol_can_id');
    }

    public function listaPrecios(){
      return $this->hasOne('App\Models\Genericas\TListaPrecios', 'lis_id', 'sol_lis_id');
    }

    public function vendedor(){
      return $this->hasOne('App\Models\Genericas\Tercero', 'idTercero', 'sol_ven_id');
    }

    public function zona(){
      return $this->hasOne('App\Models\Genericas\TZona', 'zon_id', 'sol_zona');
    }

    public function hisProceso(){
      return $this->hasMany('App\Models\negociaciones\TSolEnvioNego', 'sen_sol_id', 'sol_id');
    }

    public function soliZona(){
      return $this->hasMany('App\Models\negociaciones\TSoliZona', 'szn_sol_id', 'sol_id');
    }

    public function soliSucu(){
      return $this->hasMany('App\Models\negociaciones\TSoliSucursal', 'ssu_sol_id', 'sol_id');
    }

    public function soliTipoNego(){
      return $this->hasMany('App\Models\negociaciones\TSoliTipoNego', 'stn_sol_id', 'sol_id');
    }

    public function causal(){
      return $this->hasMany('App\Models\negociaciones\TSoliCausalNego', 'scn_sol_id', 'sol_id');
    }

}