<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTperniveles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_controlinversion')->create('t_perniveles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pern_usuario');
            $table->string('pern_nombre');
            $table->string('pern_cedula');
            $table->integer('pern_zona');
            $table->integer('pern_jefe');
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
