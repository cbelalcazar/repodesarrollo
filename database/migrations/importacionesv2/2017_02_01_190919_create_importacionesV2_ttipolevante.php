<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Ttipolevante extends Migration
{
    /**
     * Run the migrations.
     * Creado por Carlos Belalcazar
     * Analista desarrollador de software Belleza Express
     * 22/02/2017
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_tipo_levante', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('tlev_nombre')
                  ->comment('Nombre del tipo de levante');

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
        Schema::connection('importacionesV2')->dropIfExists('t_tipo_levante');
    }
}
