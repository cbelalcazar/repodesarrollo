<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tmetrica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_metrica', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('met_nombre')
                  ->comment('Nombre de la metrica');

            $table->integer('met_numero_dias')
                  ->comment('Numero de dias de la metrica');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_metrica');
    }
}
