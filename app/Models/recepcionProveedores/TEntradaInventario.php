<?php

namespace App\Models\recepcionProveedores;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;

class TEntradaInventario extends Model
{
    use SoftDeletes;

    use Auditable;

    protected $connection = 'conectoressiesa';

    protected $table = 't_entrada_inventario';

    public $timestamps = true;

    protected $fillable = [
    'dco_nombre',
    'dco_campo',
    'dco_segmento',
    'dco_longitud',
    'dco_tipo',
    'dco_orden',
    'dco_grupo',
    ];

    protected $guarded = [];

}
