<?php

namespace App\Models\bd_wmsmaterialempaque;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TEntradawm
 */
class TEntradawm extends Model
{
    protected $connection = 'bd_wmsmaterialempaque';

    protected $table = 't_entradawms';

    protected $primaryKey = 'entm_int_id';

	public $timestamps = false;

    protected $fillable = [
        'entm_txt_fecha',
        'entm_txt_factura',
        'entm_int_muelle',
        'entm_int_idtipoubicacion',
        'entm_txt_idproveedor',
        'entm_txt_estadocreacion',
        'entm_txt_estadodocumento',
        'entm_txt_estadoconfirmado',
        'entm_txt_estadoubicado',
        'entm_txt_usuariocreador',
        'entm_txt_horacreacion',
        'entm_txt_fechacreacion',
        'entm_txt_usumonta',
        'entm_txt_horamonta',
        'entm_txt_fechamonta',
        'entm_txt_funcionarioentrega',
        'entm_txt_vehiculoplaca',
        'entm_txt_transportadora',
        'entm_txt_guia',
        'entm_txt_tipomercancia',
        'entm_txt_observaciones',
        'entm_txt_nmcdindocuemnto',
        'entm_txt_nincofactura',
        'entm_txt_nmcmalrotulada',
        'entm_txt_ndiferenciaunidad',
        'entm_txt_naverias',
        'entm_txt_notros',
        'entm_txt_sinnovedad',
        'entm_txt_cita',
        'entm_txt_tipo_documento'
    ];

    protected $guarded = [];

    public function TRefentrada(){
        return $this->hasMany('App\Models\bd_wmsmaterialempaque\TRefentrada', 'rec_int_identradacedi', 'entm_int_id');
    }        

    public function TCita(){
        return $this->hasOne('App\Models\recepcionProveedores\TCita', 'id', 'entm_txt_cita');
    }

    public function TSucursalProveedor(){
        return $this->hasMany('App\Models\Genericas\TSucursalProveedor', 'ter_id', 'entm_txt_idproveedor');
    }
    
}