<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tadministraciondian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_administracion_dian', function (Blueprint $table)
        {

            $table->increments('id');

            $table->string('descripcion')
                  ->comment('Nombre de la administracion de la dian');

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
       Schema::connection('importacionesV2')->dropIfExists('t_administracion_dian');
    }
}
