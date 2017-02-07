<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TDeclaracion
 */
class TDeclaracion extends Model
{
    protected $table = 't_declaracion';

    public $timestamps = true;

    protected $fillable = [
        'decl_nacionalizacion',
        'decl_numero',
        'decl_sticker',
        'decl_arancel',
        'decl_iva',
        'decl_valor_otros',
        'decl_trm',
        'decl_tipo_levante',
        'decl_fecha_aceptacion',
        'decl_fecha_levante',
        'decl_fecha_legaliza_giro',
        'decl_admin_dian'
    ];

     protected $connection = 'importacionesV2';


}
