<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

/**
 * @resource TTipoLevante
 * 
 * Creado por Carlos Belalcazar
 * 
 * Analista desarrollador de software Belleza Express
 * 
 * 24/04/2017
 */
class TTipoLevante extends Model
{
	use SoftDeletes;
	use Auditable;

	protected $table = 't_tipo_levante';

	public $timestamps = true;

	protected $fillable = [
	'tlev_nombre'
	];

	protected $connection = 'importacionesV2';

	protected $dates = ['deleted_at'];

	public function levanteDeclaracion()
	{
		return $this->belongsTo('App\Models\Importacionesv2\TDeclaracion', 'id', 'decl_tipo_levante');
	}


}
