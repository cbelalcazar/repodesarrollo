<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * Class TProducto
 * Creado por Carlos Belalcazar
 * Analista desarrollador de software Belleza Express
 * 22/02/2017
 */
class TProducto extends Model
{
    use SoftDeletes;
    use Auditable;

    protected $table = 't_producto';

    public $timestamps = true;

    protected $fillable = [
        'prod_referencia',
        'prod_req_declaracion_anticipado',
        'prod_req_registro_importacion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];

      public function prodimportacion()
    {
        return $this->belongsTo('App\Models\Importacionesv2\TProductoImportacion', 'pdim_producto', 'id');
    }

    public function productoItem()
    {
        return $this->hasOne('App\Models\Genericas\Item', 'referenciaItem', 'prod_referencia');
    }



 }
