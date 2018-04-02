<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliCumplimiento extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_solicumplimiento';

    public $incrementing = false;

    protected $primaryKey = 'scu_id';

    public $timestamps = false;

    protected $fillable = [
        'scu_sol_id',  
        'scu_idTercero',  
        'scu_venreallineas',  
        'scu_cumpliovenreallineas',  
        'scu_observenreallineas',  
        'scu_invertotal',  
        'scu_cumpliinvertotal',  
        'scu_observinvertotal',  
        'scu_pcumpventa',  
        'scu_pcrevsante',  
        'scu_reaccionmercado',  
        'scu_preaccionmercado',  
        'scu_dinamicacliente',  
        'scu_pdinamicacliente',  
        'scu_contraprestacion',  
        'scu_pcontraprestacion',  
        'scu_financiero',  
        'scu_pfinanciero',  
        'scu_calificaciontotal',  
        'scu_fecha',  
        'scu_epcventaestimada',  
        'scu_epcporlineas',  
        'scu_epcporinversion',  
        'scu_epcmarginal',  
        'scu_epcpormarginal',  
        'scu_vpcventaestimada',  
        'scu_vpcporlineas',  
        'scu_vpcporinversion',  
        'scu_vpcmarginal',  
        'scu_vpcpormarginal',  
        'scu_vpmventaestimada',  
        'scu_vpmporlineas',  
        'scu_vpmporinversion',  
        'scu_vpmmarginal',  
        'scu_vpmpormarginal',
    ];

}