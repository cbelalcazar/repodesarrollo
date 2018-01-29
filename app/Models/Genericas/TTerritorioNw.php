<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TTerritorioNw
 */
class TTerritorioNw extends Model
{
	protected $connection = 'genericas';
	
    protected $table = 't_territorio_nw';

    public $timestamps = false;

    protected $fillable = [
        'tnw_descripcion',
        'tnw_zonaid',
        'tnw_estado'
    ];

    protected $guarded = [];

    public function zonanw(){
        return $this->hasOne('App\Models\Genericas\TZonasNw', 'id', 'tnw_zonaid');
    }

        
}