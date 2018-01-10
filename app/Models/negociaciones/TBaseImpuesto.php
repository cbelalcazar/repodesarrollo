<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TBaseImpuesto
 */
class TBaseImpuesto extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_baseimpuesto';    

    public $incrementing = true;

    public $primaryKey = 'bai_id';

    public $timestamps = false;


    protected $fillable = [
        'bai_ser_id',
        'bai_pai_id',
        'bai_dep_id',
        'bai_ciu_id',
        'bai_tipoimpuesto',
        'bai_declararenta',
        'bai_grancont',
        'bai_base',
        'bai_tasa',
        'bai_cuentaconta',
        'bai_estado',
    ];

}