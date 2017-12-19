<?php

namespace App\Models\unoeereal;

use Illuminate\Database\Eloquent\Model;

class T021MmTiposDocumentos extends Model
{
    protected $connection = 'unoeereal';

    protected $table = 't021_mm_tipos_documentos';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
       'f021_id_cia'
      ,'f021_id'
      ,'f021_descripcion'
      ,'f021_id_flia_docto'
      ,'f021_id_formato'
      ,'f021_ind_prefijo'
      ,'f021_notas'
      ,'f021_ind_mandato'
      ,'f021_ind_verificacion'
      ,'f021_rowid_movto_entidad'
      ,'f021_id_fact_elect'
      ,'f021_id_tipo_ident'
      ,'f021_id_formato_edi'
      ,'f021_ruta_formato_edi'
      ,'f021_id_formato_liq_fletes'
      ,'f021_id_formato_aprob_entrada'
      ,'f021_ind_granularidad_docto'
    ];
}
