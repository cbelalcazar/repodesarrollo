<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::connection('bd_recepcionProveedores')->create('t_citas', function (Blueprint $table) {
            
            $table->increments('id');

            $table->string('cit_nitproveedor')
                  ->comment('Nit del proveedor al que se le asigna la cita');

            $table->string('cit_nombreproveedor')
                  ->comment('Nit del proveedor al que se le asigna la cita');

            $table->dateTime('cit_fechainicio')
                  ->comment('Fecha y hora que inicia la cita');

            $table->dateTime('cit_fechafin')
                  ->comment('fecha y hora que finaliza la cita');

            $table->string('cit_muelle')
                  ->comment('muelle de descarga asignado');

            $table->date('cit_fechacumplimiento')
                  ->nullable()
                  ->comment('fecha en la que realiza la entrega el proveedor');

            $table->string('cit_estado')
                  ->comment('estado de la cita');

            $table->string('cit_objcalendarcita', 355)
                  ->comment('campo para guardar el json');

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
         Schema::connection('bd_recepcionProveedores')->dropIfExists('t_citas');
    }
}
