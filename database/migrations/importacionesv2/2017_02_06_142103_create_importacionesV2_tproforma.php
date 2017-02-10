<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tproforma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_proforma', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('prof_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->string('prof_numero')
                  ->comment('Numero de la proforma');

            $table->dateTime('prof_fecha_creacion')
                  ->comment('Fecha creacion de la proforma');

            $table->dateTime('prof_fecha_entrega')
                  ->comment('Fecha entrega de la proforma');

            $table->integer('prof_valor_proforma')
                  ->comment('Valor de la proforma');

            $table->boolean('prof_principal')
                  ->comment('La proforma es la principal para la importacion?? true / false');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_proforma', function(Blueprint $table) {

            $table->foreign('prof_importacion')->references('id')->on('t_importacion');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_proforma');
    }
}
