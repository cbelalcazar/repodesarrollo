<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImportacionesV2Tnacionalizacioncosteoimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->table('t_nacionalizacion_importacion', function (Blueprint $table) {
            $table->string('naco_numero_comex')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->table('t_nacionalizacion_importacion', function (Blueprint $table) {
            $table->integer('naco_numero_comex')->change();
        });
    }
}
