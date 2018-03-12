<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class TInfoReferencia extends Model
{
     use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_inforeferencia';

    public $timestamps = true;

    protected $fillable = [
    'iref_referencia',
    'iref_tipoempaque',
    'iref_pesoporempaque',
    'iref_programable',
    ];

    protected $guarded = [];

    public function referencia(){
        return $this->hasOne('App\Models\Genericas\TItemCriterio', 'ite_txt_referencia','iref_referencia');
    }

}
