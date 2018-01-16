<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class NegociacionesVentas extends Model
{
    protected $connection = 'besa';

    protected $table = '001-Negociaciones_Ventas';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'llave',
        'fecha',
        'periodo',
        'codzonavendedor',
        'ciudad',
        'codcanal',
        'nitcliente',
        'codsucursal',
        'codvendedorplataforma',
        'codlinea',
        'cantidad',
        'neto',
        'concepto',
        'co',
        'costopromtot',
    ];
}
