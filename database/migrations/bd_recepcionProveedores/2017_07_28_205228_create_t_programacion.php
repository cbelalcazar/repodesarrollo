<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProgramacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::connection('bd_recepcionProveedores')->create('t_programacion', function (Blueprint $table) {
            
            $table->increments('id');

            $table->string('prg_num_orden_compra')
                  ->comment('Numero de la orden de compra');

            $table->string('prg_tipo_doc_oc')
                  ->comment('Tipo de documento de la orden de compra');

            $table->string('prg_referencia')
                  ->comment('referencia del item');

            $table->string('prg_nit_proveedor')
                  ->comment('Nit del proveedor');

            $table->date('prg_fecha_programada')
                  ->comment('Fecha en la que se programa la entrega por planeacion');

            $table->integer('prg_cant_programada')
                  ->comment('Cantidad que se programa para entrega en planeacion para esta programacion en especifico');

            $table->integer('prg_cant_solicitada_oc')
                  ->comment('Cantidad solicitada en toda la orden de compra (REGISTRO ERP)');

            $table->integer('prg_cant_entregada_oc')
                  ->comment('Cantidad entregada en toda la orden de compra (REGISTRO ERP)');            

            $table->integer('prg_cant_pendiente_oc')
                  ->comment('Cantidad pendiente por entregar en toda la orden de compra (REGISTRO ERP)');

            $table->integer('prg_unidad_empaque')
                  ->comment('Unidad de empaque que registra en la orden de compra (REGISTRO ERP)');

            $table->integer('prg_cant_embalaje')
                  ->comment('Cantidad de embalaje que ingresa el proveedor');

            $table->integer('prg_prioridad')
                  ->comment('Prioridad de la programacion para planeacion sirve para informar a abastecimiento que es mas urgente recibir');

            $table->integer('prg_estado')
                  ->comment('Estado de la programacion');

            $table->string('prg_observacion')
                  ->nullable()
                  ->comment('Observacion de la programacion');

            $table->integer('prg_tipo_programacion')
                  ->comment('Indica si es para seguir flujo establecido o solo genera correo');


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
