<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionTablaTperniveles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_negociaciones2')->create('t_perniveles', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('pen_usuario');
            $table->string('pen_nombre');
            $table->string('pen_cedula');
            $table->integer('pen_idtipoper');
            $table->integer('pen_nomnivel')->unsigned(); 
            $table->string('pen_idterritorios', 100);
            $table->string('pen_idlineas', 100);
            $table->integer('pen_idpadre', 11);
            $table->timestamps();

            // $table->foreign('pen_nomnivel')->references('id')->on('t_niveles');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
