<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolipernivel
 */
class TSolipernivel extends Model
{
    protected $connection = "bd_negociaciones2";
    
    protected $table = 't_solipernivel';

    public $timestamps = true;

    protected $fillable = [
        'sni_idpernivel',
        'sni_cedula',
        'sni_idsolicitud',
        'sni_estado',
        'sni_orden'
    ];

    protected $guarded = [];

        
}