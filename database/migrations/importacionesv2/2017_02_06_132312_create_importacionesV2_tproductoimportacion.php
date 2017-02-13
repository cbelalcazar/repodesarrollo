<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tproductoimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_producto_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('pdim_producto')
                  ->unsigned()
                  ->comment('Campo que relacion la referencia del producto en el ERP al sistema de importaciones');

            $table->integer('pdim_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->date('pdim_fech_req_declaracion_anticipado')
                  ->nullable()
                  ->comment('Fecha creacion alerta producto requiere proceso de declaracion de anticipado');

            $table->date('pdim_fech_cierre_declaracion_anticipado')
                  ->nullable()
                  ->comment('Fecha cierre alerta producto requiere proceso de declaracion de anticipado');

            $table->date('pdim_fech_requ_registro_importacion')
                  ->nullable()
                  ->comment('Fecha creacion alerta producto requiere proceso de registro de importacion');

            $table->date('pdim_fech_cierre_registro_importacion')
                  ->nullable()
                  ->comment('Fecha cierre alerta producto requiere proceso de registro de importacion');

            $table->boolean('pdim_alerta')
                  ->nullable()
                  ->comment('Las alertas se encuentran ambas activas?? true / false');

            $table->string('pdim_numero_licencia_importacion')
                  ->nullable()
                  ->comment('Campo que relacion la referencia del producto en el ERP al sistema de importaciones');

            $table->date('pdim_fecha_anticipado')
                  ->nullable()
                  ->comment('Fecha de anticipado');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_producto_importacion', function(Blueprint $table) {

            $table->foreign('pdim_importacion')->references('id')->on('t_importacion');

            $table->foreign('pdim_producto')->references('id')->on('t_producto');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_producto_importacion');
    }
}
