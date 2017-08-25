<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTProgramacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('bd_recepcionProveedores')->table('t_programacion', function (Blueprint $table) {
            
            $table->string('prg_idcita')
                  ->nullable()
                  ->comment('Id que identifica esta programacion a que cita pertenece');

        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('bd_recepcionProveedores')->table('t_programacion', function (Blueprint $table) {
            $table->dropColumn('prg_idcita');
        });
    }
}
