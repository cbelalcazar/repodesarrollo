<?php

namespace App\Models\controlinversion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TSolipernivel
 */
class TSolipernivel extends Model
{
    protected $connection = "bd_controlinversion";
    protected $table = 't_solipernivel';

    public $timestamps = true;

    protected $fillable = [
        'sni_usrnivel',
        'sni_sci_id',
        'sni_estado',
        'sni_orden'
    ];

    protected $guarded = [];

    public function tpernivel(){
      return $this->hasOne('App\Models\controlinversion\TPerniveles', 'id', 'sni_usrnivel');
    }


}
