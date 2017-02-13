<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tnacionalizacioncosteoimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_nacionalizacion_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('naco_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->integer('naco_tipo_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_tipo_importacion');

            $table->float('naco_anticipo_aduana', 10, 2)
                  ->comment('Valor anticipo aduana');

            $table->date('naco_fecha_anticipo_aduana')
                  ->comment('Fecha de anticipo a la aduana');

            $table->boolean('naco_preinscripcion')
                  ->comment('¿la nacionalizacion requiere preinscripcion? True / False');

            $table->boolean('naco_control_posterior')
                  ->comment('¿la nacionalizacion requiere control posterior? True / False');

            $table->date('naco_fecha_recibo_fact_be')
                  ->comment('Fecha de recibido facturas en Belleza Express');

            $table->date('naco_fecha_entrega_fact_cont')
                  ->comment('Fecha de entrega de facturas a contabilidad');

            $table->date('naco_fecha_entrega_docu_transp')
                  ->comment('Fecha de entrega de documentos transportador');

            $table->date('naco_fecha_retiro_puert')
                  ->comment('Fecha de retiro del Puerto / Aeropuerto');

            $table->date('naco_fecha_envio_comex')
                  ->comment('Fecha de envio a Comex');

            $table->date('naco_fecha_llegada_be')
                  ->comment('Fecha de llegada a belleza express');

            $table->date('naco_fecha_recep_list_empaq')
                  ->comment('Fecha de recepcion lista de empaque + ciego');

            $table->date('naco_fecha_envi_liqu_costeo')
                  ->comment('Fecha de envio a liquidacion y costeo');

            $table->date('naco_fecha_entrada_sistema')
                  ->comment('Fecha de entrada al sistema');

            $table->float('naco_sobrante', 10, 2)
                  ->nullable()
                  ->comment('Valor sobrante');

            $table->float('naco_faltante', 10, 2)
                  ->nullable()
                  ->comment('Valor faltante');

            $table->float('naco_factor_dolar_porc', 10, 2)
                  ->nullable()
                  ->comment('Valor factor dolar porcentaje');

            $table->float('naco_factor_dolar_tasa', 10, 2)
                  ->nullable()
                  ->comment('Valor factor dolar Tasa');

            $table->float('naco_factor_logist_porc', 10, 2)
                  ->nullable()
                  ->comment('Valor factor logistico porcentaje');

            $table->float('naco_factor_logist_tasa', 10, 2)
                  ->nullable()
                  ->comment('Valor factor logistico Tasa');

            $table->float('naco_factor_arancel_porc', 10, 2)
                  ->nullable()
                  ->comment('Valor factor arancel porcentaje resta de los dos anteriores');

            $table->integer('naco_tipo_nacionalizacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_tipo_nacionalizacion');

            $table->softDeletes();

            $table->timestamps();

        });

        Schema::connection('importacionesV2')->table('t_nacionalizacion_importacion', function(Blueprint $table) {

            $table->foreign('naco_importacion')->references('id')->on('t_importacion');

            $table->foreign('naco_tipo_importacion')->references('id')->on('t_tipo_importacion');

            $table->foreign('naco_tipo_nacionalizacion')->references('id')->on('t_tipo_nacionalizacion');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_nacionalizacion_importacion');
    }
}