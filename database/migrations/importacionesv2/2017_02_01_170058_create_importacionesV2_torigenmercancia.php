<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Torigenmercancia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_origen_mercancia', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('ormer_nombre')
                  ->comment('Nombre del origen de la mercancia');

            $table->boolean('ormer_requ_cert_origen')
                  ->comment('¿la mercancia requiere certificado de origen? R: True / False');

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
        Schema::connection('importacionesV2')->dropIfExists('t_origen_mercancia');
    }
}
