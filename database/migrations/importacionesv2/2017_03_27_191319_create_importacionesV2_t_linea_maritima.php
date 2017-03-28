<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2TLineaMaritima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::connection('importacionesV2')->create('t_linea_maritima', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('lmar_descripcion')
                  ->comment('Descripcion de la linea maritima');

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
         Schema::connection('importacionesV2')->dropIfExists('t_linea_maritima');
    }
}
