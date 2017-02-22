<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tcausalesdemora extends Migration
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
        Schema::connection('importacionesV2')->create('t_causales_demora', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('cdem_nombre')
                  ->comment('Nombre del tipo de levante');

            $table->integer('cdem_metrica')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_metrica');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_causales_demora', function(Blueprint $table) {
             $table->foreign('cdem_metrica')->references('id')->on('t_metrica');
         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_causales_demora');
    }
}
