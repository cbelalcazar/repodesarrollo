<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TRefedevolucione
 */
class TRefedevolucione extends Model
{
    protected $table = 't_refedevoluciones';

    public $timestamps = false;

    protected $fillable = [
        'rede_int_estiba',
        'rede_txt_referencia',
        'rede_int_cantidad'
    ];

    protected $guarded = [];

        
}