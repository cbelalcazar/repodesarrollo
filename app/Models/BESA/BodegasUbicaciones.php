<?php

namespace App\Models\BESA;

use Illuminate\Database\Eloquent\Model;

class BodegasUbicaciones extends Model
{
    protected $connection = 'besa';

    protected $table = '000_BodegasUbicaciones';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id_cia',
        'id_bodega',
        'nom_bodega',
        'id_ubic',
        'nom_ubic',
        'f150_ind_multi_ubicacion',
        'estado_bod',
        'estado_ubicacion'
    ];

}
