<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTPeriodo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_recepcionProveedores')->create('t_periodo', function (Blueprint $table) {
            
            $table->increments('id');

            $table->date('per_fecha_inicio')
                  ->comment('Fecha inicio programacion');

            $table->date('per_fecha_fin')
                  ->comment('Fecha fin programacion');

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
       Schema::connection('bd_recepcionProveedores')->dropIfExists('t_periodo');
    }
}
