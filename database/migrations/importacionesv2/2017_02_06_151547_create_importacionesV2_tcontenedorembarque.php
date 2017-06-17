<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tcontenedorembarque extends Migration
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
        Schema::connection('importacionesV2')->create('t_contenedor_embarque', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('cont_embarque')
                  ->unsigned()
                  ->nullable()
                  ->comment('Campo que relaciona esta tabla con la tabla t_embarque_importacion');

            $table->integer('cont_tipo_contenedor')
                  ->unsigned()
                  ->nullable()
                  ->comment('Campo que relaciona esta tabla con la tabla t_tipo_contenedor');

            $table->integer('cont_cantidad')
                  ->nullable()
                  ->comment('cantidad de contenedores a importar');

            $table->string('cont_numero_contenedor')
                  ->nullable()
                  ->comment('numero del contenedor');

            $table->float('cont_cubicaje', 10, 2)
                  ->nullable()
                  ->comment('Cubicaje importado');

            $table->float('cont_peso', 10, 2)
                  ->nullable()
                  ->comment('peso importado');

            $table->integer('cont_cajas')
                  ->nullable()
                  ->comment('cantidad de cajas importadas');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_contenedor_embarque', function(Blueprint $table) {

            $table->foreign('cont_embarque')->references('id')->on('t_embarque_importacion');

            $table->foreign('cont_tipo_contenedor')->references('id')->on('t_tipo_contenedor');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_contenedor_embarque');
    }
}
