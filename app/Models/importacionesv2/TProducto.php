<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TProducto
 */
class TProducto extends Model
{
    use SoftDeletes;

    protected $table = 't_producto';

    public $timestamps = true;

    protected $fillable = [
        'prod_referencia',
        'prod_req_declaracion_anticipado',
        'prod_req_registro_importacion'
    ];

     protected $connection = 'importacionesV2';

     protected $dates = ['deleted_at'];


 }