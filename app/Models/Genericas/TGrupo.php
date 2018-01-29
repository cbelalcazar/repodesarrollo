<?php

namespace App\Models\Genericas;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TGrupo
 */
class TGrupo extends Model
{
    protected $connection = 'genericas';
    	
    protected $table = 't_grupo';

    public $timestamps = false;

    protected $fillable = [
        'gru_sigla',
        'gru_descripcion',
        'gru_estado'
    ];

    protected $guarded = [];

        
}