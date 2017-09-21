<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;


/**
 * Class TCita
 */
class TCita extends Model
{
    use SoftDeletes;

    use Auditable;

    protected $connection = 'bd_recepcionProveedores';

    protected $table = 't_citas';

    public $timestamps = true;

    protected $fillable = [
        'cit_nitproveedor',
        'cit_nombreproveedor',
        'cit_fechainicio',
        'cit_fechafin',
        'cit_muelle',
        'cit_fechacumplimiento',
        'cit_estado',
        'cit_objcalendarcita'
    ];

    protected $guarded = [];

    public function setCitObjcalendarcitaAttribute($value){
        $this->attributes['cit_objcalendarcita'] = serialize($value);
    }

    public function getCitObjcalendarcitaAttribute($value){
        return unserialize($value);
    }

    public function programaciones(){
        return $this->hasMany('App\Models\recepcionProveedores\TProgramacion',"prg_idcita","id");
    }

        
}