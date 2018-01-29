<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPernivcanal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_negociaciones2')->create('t_pernivcanal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pcan_idpernivel');
            $table->string('pcan_idcanal');  
            $table->string('pcan_descripcanal');                   
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
