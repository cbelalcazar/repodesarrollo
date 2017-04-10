<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TDeclaracion
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TDeclaracion extends Model
{
    use SoftDeletes;
    use Auditable;

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

     protected $dates = ['deleted_at'];

      public function levanteDeclaracion()
    {
        return $this->hasOne('App\Models\Importacionesv2\TTipoLevante', 'id', 'decl_tipo_levante');
    }

     public function admindianDeclaracion()
    {
        return $this->hasOne('App\Models\Importacionesv2\TAdministracionDian', 'id', 'decl_admin_dian');
    }

     public function nacionalizacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TNacionalizacionImportacion', 'decl_nacionalizacion', 'id');
    }




}
