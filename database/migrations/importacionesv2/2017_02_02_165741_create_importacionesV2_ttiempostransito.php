<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Ttiempostransito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_tiempos_transito', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('tran_embarcador')
                  ->comment('Nit del embarcador en el ERP de siesa');

            $table->integer('tran_puerto_embarque')
                  ->unsigned()
                  ->comment('Campo que relaciona con la tabla t_puerto_embarque');

            $table->string('tran_linea_maritima')
                  ->comment('Nit de la linea maritima en el ERP de siesa');

            $table->integer('tran_tipo_carga')
                  ->unsigned()
                  ->comment('Campo que relaciona con la tabla t_tipo_carga');

            $table->integer('tran_numero_dias')
                  ->comment('Numero de dias de parametrizacion');

            $table->softDeletes();
            
            $table->timestamps();
        });

         Schema::connection('importacionesV2')->table('t_tiempos_transito', function(Blueprint $table) {
             
            $table->foreign('tran_puerto_embarque')->references('id')->on('t_puerto_embarque');

            $table->foreign('tran_tipo_carga')->references('id')->on('t_tipo_carga');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_tiempos_transito');
    }
}
