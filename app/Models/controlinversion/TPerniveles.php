<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNiveles
 */
class TPerniveles extends Model
{
	protected $connection = 'bd_controlinversion';

    protected $table = 't_perniveles';

	public $timestamps = true;

    protected $fillable = [
        'pern_usuario',
        'pern_nombre',
        'pern_cedula',
        'pern_tipopersona',
        'pern_jefe',
        'pern_nomnivel'    
    ];

        
}