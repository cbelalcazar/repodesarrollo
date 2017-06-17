<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tpermisosimp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('importacionesV2')->create('t_permisos_imp', function (Blueprint $table)
       {
        $table->increments('id');
        $table->string('perm_cedula')
         ->nullable()
         ->comment('Campo que relaciona la cedula, con el permiso de usuario');
        
        $table->integer('perm_cargo')
         ->nullable()
         ->comment('1 - Jefe, 2 - Auxiliar'); 
     });

 }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_permisos_imp');
    }
}
