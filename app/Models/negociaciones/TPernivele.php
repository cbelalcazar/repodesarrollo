<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPernivele
 */
class TPernivele extends Model
{
    protected $connection = "bd_negociaciones2";
    
    protected $table = 't_perniveles';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'pen_usuario',
        'pen_nombre',
        'pen_cedula',
        'pen_idtipoper',
        'pen_nomnivel'
    ];

    protected $guarded = [];

    public function TTipopersona(){
        return $this->hasOne('App\Models\Genericas\TTipopersona', 'id', 'pen_idtipoper');
    }

    public function canales(){
        return $this->hasMany('App\Models\negociaciones\TPernivcanal', 'pcan_idpernivel', 'id');
    }

    public function hijos(){
        return $this->hasMany('App\Models\negociaciones\TPernivcanal', 'pcan_aprobador', 'id');
    }

        
}