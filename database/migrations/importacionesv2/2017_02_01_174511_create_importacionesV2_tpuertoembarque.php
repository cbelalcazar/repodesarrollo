<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tpuertoembarque extends Migration
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
        Schema::connection('importacionesV2')->create('t_puerto_embarque', function (Blueprint $table)
        {

            $table->increments('id');

            $table->string('puem_nombre')
                  ->comment('Nombre del puerto de embarque');

            $table->string('puem_itime')
                  ->comment('I time del puerto de embarque');

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
        Schema::connection('importacionesV2')->dropIfExists('t_puerto_embarque');
    }
}
