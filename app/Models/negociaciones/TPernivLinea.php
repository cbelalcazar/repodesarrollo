<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPernivele
 */
class TPernivLinea extends Model
{
    protected $connection = "bd_negociaciones2";
    
    protected $table = 't_pernivlinea';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'pcan_idcanal',
        'pcan_idlinea',
        'pcan_descriplinea'
    ];

    protected $guarded = [];

    public function canal(){
        return $this->belongsTo('App\Models\negociaciones\TPernivCanal', 'pcan_idcanal', 'id');
    }
        
}