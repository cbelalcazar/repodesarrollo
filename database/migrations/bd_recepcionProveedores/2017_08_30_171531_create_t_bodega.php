<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBodega extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('bd_recepcionProveedores')->create('t_bodega', function (Blueprint $table) {
            
            $table->increments('id');

            $table->string('bod_codigo')
                  ->comment('Codigo de la bodega');

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
        //
    }
}
