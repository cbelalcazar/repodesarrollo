<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImportacionesV2Tembarqueimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->table('t_embarque_importacion', function (Blueprint $table) {
            $table->integer('emim_linea_maritima')->default(1)->unsigned()->change();
        });
        Schema::connection('importacionesV2')->table('t_embarque_importacion', function (Blueprint $table) {
            $table->foreign('emim_linea_maritima')->references('id')->on('t_linea_maritima');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::connection('importacionesV2')->table('t_embarque_importacion', function (Blueprint $table) {
            $table->string('emim_linea_maritima')->default("")->unsigned(false)->change();
            $table->dropForeign('emim_linea_maritima');
        });
    }
}
