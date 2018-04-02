<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TKeyAccount
 */
class TKeyAccount extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_keyaccount';

    public $incrementing = true;

    protected $primaryKey = 'kea_id';

    public $timestamps = false;


    protected $fillable = [
        'kea_idTercero_res',  
        'kea_idTercero_clien',  
        'kea_estado'
    ];

    public function cliente(){
        return $this->hasOne('App\Models\Genericas\TCliente', 'ter_id', 'kea_idTercero_clien');
    }
}