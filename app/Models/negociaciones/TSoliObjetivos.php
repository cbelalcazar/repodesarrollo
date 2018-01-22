<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class TSoliObjetivos extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_soliobjetivos';

    public $incrementing = true;

    protected $primaryKey = 'soo_id';

    public $timestamps = false;

    protected $fillable = [
        'soo_sol_id',  
        'soo_pecomini',  
        'soo_pecomfin',  
        'soo_mese',  
        'soo_costonego',  
        'soo_pinventaestiline',  
        'soo_venpromeslin',  
        'soo_venprolin6m',  
        'soo_venestlin',  
        'soo_pcrelin',  
        'soo_ventmargilin',  
        'soo_pvenmarlin',  
        'soo_ventapromtotal',  
        'soo_ventapromseisme',  
        'soo_ventaestitotal',  
        'soo_pcreciestima',  
        'soo_ventamargi',  
        'soo_pinverestima',  
        'soo_pinvermargi',  
        'soo_vemesantes',  
        'soo_veprome',  
        'soo_vemesdespues',  
        'soo_observacion',  
        'soo_venprolin6m_2',  
        't_soliobjetivoscol',  
        'soo_ventaverificacion',  
        'soo_cumpliovenreallineas',  
        'soo_pinventaestilineReal',  
        'soo_pcrelinReal',  
        'soo_pvenmarlinReal',  
        'soo_ventmargilinReal',  
        'soo_ventatotalcliente', 
        'soo_ventamargiReal',  
        'soo_pinverestimaReal',  
        'soo_pinvermargiReal'
    ];

}