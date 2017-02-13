<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Timportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('imp_consecutivo')
                  ->comment('Consecutivo que identifica la importacion para el area de Comercio exterior');

            $table->string('imp_proveedor')
                  ->comment('Campo que relacion el nit del proveedor en el ERP al sistema de importaciones');

            $table->integer('imp_puerto_embarque')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_puerto_embarque');

            $table->integer('imp_iconterm')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_iconterm');

            $table->string('imp_moneda_negociacion')
                  ->comment('Campo que relaciona la moneda de negociacion del ERP al sistema de importaciones');

            $table->date('imp_fecha_entrega_total')
                  ->comment('Fecha entrega total estimada de la mercancia segun proveedor');

            $table->string('imp_observaciones')
                  ->nullable()
                  ->comment('Campo para ingresar observaciones en caso de existir');

            $table->integer('imp_estado_proceso')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_estado clase estado 1 para proceso 1 origen - 2 transito - 3 puerto - 4 bodega - 5 liquidada -6 cerrada -7 anulada');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_importacion', function(Blueprint $table) {

            $table->foreign('imp_puerto_embarque')->references('id')->on('t_puerto_embarque');

            $table->foreign('imp_iconterm')->references('id')->on('t_iconterm');

            $table->foreign('imp_estado_proceso')->references('id')->on('t_estados');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_importacion');
    }
}
