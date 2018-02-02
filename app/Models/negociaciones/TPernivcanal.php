<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPernivele
 */
class TPernivCanal extends Model
{
    protected $connection = "bd_negociaciones2";
    
    protected $table = 't_pernivcanal';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'pcan_idpernivel',
        'pcan_cedula',
        'pcan_idcanal',
        'pcan_descripcanal',
        'pcan_idterritorio',
        'pcan_aprobador'
    ];

    protected $guarded = [];

    public function lineas(){
        return $this->hasMany('App\Models\negociaciones\TPernivLinea', 'pcan_idcanal', 'id');
    }
        
}