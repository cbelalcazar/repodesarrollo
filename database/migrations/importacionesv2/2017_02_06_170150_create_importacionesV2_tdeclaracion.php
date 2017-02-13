<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tdeclaracion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_declaracion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('decl_nacionalizacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_nacionalizacion_importacion');

            $table->string('decl_numero')
                  ->comment('Numero de la declaracion de importacion');

            $table->string('decl_sticker')
                  ->comment('Numero del sticker de declaracion de importacion');

            $table->integer('decl_arancel')
                  ->comment('Valor del arancel');

            $table->integer('decl_iva')
                  ->comment('Valor del iva');

            $table->integer('decl_valor_otros')
                  ->comment('Valor otros');

            $table->float('decl_trm', 10, 2)
                  ->comment('Valor del TRM');

            $table->integer('decl_tipo_levante')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_tipo_levante');

            $table->date('decl_fecha_aceptacion')
                  ->comment('Fecha de aceptacion ');

            $table->date('decl_fecha_levante')
                  ->comment('Fecha de levante ');

            $table->date('decl_fecha_legaliza_giro')
                  ->nullable()
                  ->comment('Fecha de legalizacion del giro ');

            $table->integer('decl_admin_dian')
                  ->comment('Campo que relacion el id de la ciudad en el base de datos genericas al sistema de importaciones');

            $table->softDeletes();

            $table->timestamps();
        });


        Schema::connection('importacionesV2')->table('t_declaracion', function(Blueprint $table) {

            $table->foreign('decl_nacionalizacion')->references('id')->on('t_nacionalizacion_importacion');

            $table->foreign('decl_tipo_levante')->references('id')->on('t_tipo_levante');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_declaracion');
    }
}
