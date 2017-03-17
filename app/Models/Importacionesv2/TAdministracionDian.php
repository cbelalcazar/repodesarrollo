<?php

namespace App\Models\Importacionesv2;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class TAdministracionDian extends Model
{
	use SoftDeletes;
	use Auditable;
	protected $table = 't_administracion_dian';

	public $timestamps = true;

	protected $fillable = [
	'descripcion'
	];

	protected $connection = 'importacionesV2';

	protected $dates = ['deleted_at'];

	public function admindianDeclaracion()
	{
		return $this->belongsTo('App\Models\Importacionesv2\TDeclaracion', 'id', 'decl_admin_dian');
	}
}
