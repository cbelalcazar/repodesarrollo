<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TLineaMaritima
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TLineaMaritima extends Model
{
    use SoftDeletes;
	use Auditable;
	protected $table = 't_linea_maritima';
	public $timestamps = true;
	protected $fillable = [
	'lmar_descripcion'
	];
	protected $connection = 'importacionesV2';
	protected $dates = ['deleted_at'];
}