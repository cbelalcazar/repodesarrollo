<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tproducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_producto', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('prod_referencia')
                  ->comment('Campo que relacion la referencia del producto en el ERP al sistema de importaciones');

            $table->boolean('prod_req_declaracion_anticipado')
                  ->comment('¿El producto requiere declaracion de anticipado?');

            $table->boolean('prod_req_registro_importacion')
                  ->comment('¿El producto requiere registro de importacion?');

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
        Schema::connection('importacionesV2')->dropIfExists('t_producto');
    }
}
