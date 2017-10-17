<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TPreconversion
 */
class TPreconversion extends Model
{
    protected $table = 't_preconversion';

    protected $primaryKey = 'pcv_id';

	public $timestamps = false;

    protected $fillable = [
        'pcv_mes',
        'pcv_año',
        'pcv_valor'
    ];

    protected $guarded = [];

        
}