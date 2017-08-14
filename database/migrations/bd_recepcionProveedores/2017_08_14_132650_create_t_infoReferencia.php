<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTInfoReferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_recepcionProveedores')->create('t_inforeferencia', function (Blueprint $table) {
            
            $table->increments('id');

            $table->string('iref_referencia')
                  ->comment('Codigo de la referencia en el UNOE');

            $table->string('iref_tipoempaque')
                  ->comment('Nombre del tipo de empaque en el que viene la referencia');

            $table->string('iref_pesoporempaque')
                  ->comment('Cantidad de unidades que tiene cada empaque');

            $table->string('iref_programable')
                  ->comment('Campo que indica si la orden de compra se debe programar o se debe enviar a solicitud cita');
      
            $table->softDeletes();

            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::connection('bd_recepcionProveedores')->dropIfExists('t_inforeferencia');
    }
}
