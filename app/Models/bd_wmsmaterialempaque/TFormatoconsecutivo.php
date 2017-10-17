<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TFormatoconsecutivo
 */
class TFormatoconsecutivo extends Model
{
    protected $table = 't_formatoconsecutivos';

    protected $primaryKey = 'cfe_int_id';

	public $timestamps = false;

    protected $fillable = [
        'cfe_int_fomatomovimiento',
        'cfe_int_etiquetas'
    ];

    protected $guarded = [];

        
}