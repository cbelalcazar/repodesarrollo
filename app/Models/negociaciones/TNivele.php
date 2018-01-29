<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TNivele
 */
class TNivele extends Model
{
	protected $connection = "bd_negociaciones2";
	
    protected $table = 't_niveles';

    public $timestamps = true;

    protected $fillable = [
        'niv_descripcion'
    ];

    protected $guarded = [];

        
}