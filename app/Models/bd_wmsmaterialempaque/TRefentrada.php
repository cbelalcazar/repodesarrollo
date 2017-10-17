<?php

namespace App\Models\bd_wmsmaterialempaque;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRefentrada
 */
class TRefentrada extends Model
{
    protected $connection = 'bd_wmsmaterialempaque';

    protected $table = 't_refentrada';

    protected $primaryKey = 'rec_int_id';

	public $timestamps = false;

    protected $fillable = [
        'rec_int_identradacedi',
        'rec_txt_referencia',
        'rec_int_cantidad',
        'rec_int_saldo',
        'rec_int_cajas',
        'rec_txt_lote',
        'rec_int_estiba',
        'rec_int_idestado',
        'rec_int_undempaque',
        'rec_txt_estadoconfirmado',
        'rec_txt_estadoubicacion',
        'rec_txt_fecharegistro',
        'rec_int_idtipoembalaje',
        'rec_int_idnoveda',
        'rec_txt_usuario'
    ];

    protected $guarded = [];

        
}