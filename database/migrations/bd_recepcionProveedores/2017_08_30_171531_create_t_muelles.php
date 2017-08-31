<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTMuelles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('bd_recepcionProveedores')->create('t_muelles', function (Blueprint $table) {
            
            $table->increments('mu_id');

            $table->string('id')
                  ->comment('Abreviatura del muelle');

            $table->string('title')
                  ->comment('Nombre del muelle');
      
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
