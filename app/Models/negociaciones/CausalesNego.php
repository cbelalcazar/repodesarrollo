<?php

namespace App\Models\negociaciones;

use Illuminate\Database\Eloquent\Model;

class CausalesNego extends Model
{
    protected $connection = 'bd_negociaciones2';

    protected $table = 't_causalesnego';

    public $incrementing = false;

    protected $primaryKey = 'can_id';

    public $timestamps = false;

    protected $fillable = [
        'can_descripcion',
        'can_ayuda',
        'can_estado',
    ];

}
