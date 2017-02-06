<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Torigenmercanciaimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_origen_mercancia_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('omeim_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->integer('omeim_origen_mercancia')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_origen_mercancia');

            $table->softDeletes();

            $table->timestamps();

        });

        Schema::connection('importacionesV2')->table('t_origen_mercancia_importacion', function(Blueprint $table) {

            $table->foreign('omeim_importacion')->references('id')->on('t_importacion');

            $table->foreign('omeim_origen_mercancia')->references('id')->on('t_origen_mercancia');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_origen_mercancia_importacion');
    }
}
