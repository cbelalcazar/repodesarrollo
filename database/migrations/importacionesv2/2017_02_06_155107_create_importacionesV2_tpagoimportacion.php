<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tpagoimportacion extends Migration
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
        Schema::connection('importacionesV2')->create('t_pago_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('pag_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->float('pag_valor_anticipo', 10, 2)
                  ->nullable()
                  ->comment('pago valor anticipo');

            $table->date('pag_fecha_anticipo')
                  ->nullable()
                  ->comment('Fecha del anticipo');

            $table->float('pag_valor_saldo', 10, 2)
                  ->nullable()
                  ->comment('pago valor saldo');

            $table->date('pag_fecha_saldo')
                  ->nullable()
                  ->comment('Fecha del saldo');

            $table->float('pag_valor_comision', 10, 2)
                  ->nullable()
                  ->comment('pago valor comision');

            $table->float('pag_valor_total', 10, 2)
                  ->nullable()
                  ->comment('pago valor total');

            $table->float('pag_valor_fob', 10, 2)
                  ->nullable()
                  ->comment('pago valor fob');

            $table->string('pag_numero_factura')
                  ->nullable()
                  ->comment('Numero de la factura');

            $table->date('pag_fecha_factura')
                  ->nullable()
                  ->comment('Fecha de la factura');

            $table->float('trm_liquidacion_factura', 10, 2)
                  ->comment('pago valor fob');

            $table->date('pag_fecha_envio_contabilidad')
                  ->comment('Fecha de envio documentacion a contabilidad');

            $table->softDeletes();

            $table->timestamps();

        });

        Schema::connection('importacionesV2')->table('t_pago_importacion', function(Blueprint $table) {

            $table->foreign('pag_importacion')->references('id')->on('t_importacion');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_pago_importacion');
    }
}