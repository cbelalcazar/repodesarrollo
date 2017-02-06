<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Ttiponacionalizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_tipo_nacionalizacion', function (Blueprint $table)
        {
          $table->increments('id');

          $table->string('tnac_descripcion')
                ->comment('Nombre del tipo de nacionalizacion');

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
        Schema::connection('importacionesV2')->dropIfExists('t_tipo_nacionalizacion');
    }
}
