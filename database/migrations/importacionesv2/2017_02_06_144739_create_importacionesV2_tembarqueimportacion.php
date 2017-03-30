<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportacionesV2Tembarqueimportacion extends Migration
{
    /**
     * Run the migrations.
     * Creado por Carlos Belalcazar
     * Analista desarrollador de software Belleza Express
     * 22/02/2017
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('importacionesV2')->create('t_embarque_importacion', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('emim_importacion')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_importacion');

            $table->string('emim_embarcador')
                  ->comment('Campo que relacion el nit del proveedor en el ERP al sistema de importaciones');

            $table->integer('emim_linea_maritima')
                  ->unsigned()
                  ->comment('Campo que relacion las lineas maritimas de la tabla t_linea_maritima');

            $table->integer('emim_tipo_carga')
                  ->unsigned()
                  ->comment('Campo que relaciona esta tabla con la tabla t_tipo_carga');

            $table->date('emim_fecha_etd')
                  ->comment('Fecha ETD');

            $table->date('emim_fecha_eta')
                  ->comment('Fecha ETA');

            $table->string('emim_documento_transporte')
                  ->comment('Numero documento transporte');

            $table->float('emim_valor_flete', 15, 2)
                  ->nullable()
                  ->comment('Valor del flete de embarque');

            $table->date('emim_fecha_recibido_documentos_ori')
                  ->nullable()
                  ->comment('Fecha recibido documentos originales');

            $table->date('emim_fecha_envio_aduana')
                  ->nullable()
                  ->comment('Fecha envio documentos a la aduana');

            $table->date('emim_fecha_envio_ficha_tecnica')
                  ->nullable()
                  ->comment('Fecha envio ficha tecnica');

            $table->date('emim_fecha_envio_lista_empaque')
                  ->nullable()
                  ->comment('Fecha envio lista de empaque');

            $table->string('emim_aduana')
                  ->comment('Campo que relacion el nit de la aduana en el ERP al sistema de importaciones');

            $table->string('emim_transportador')
                  ->comment('Campo que relacion el nit del transportador en el ERP al sistema de importaciones');

            $table->date('emim_fecha_solicitud_reserva')
                    ->comment('Fecha de solicitud de la reserva');

            $table->date('emim_fecha_confirm_reserva')
                  ->comment('Fecha de confirmacion de la reserva');

            $table->softDeletes();

            $table->timestamps();
        });

        Schema::connection('importacionesV2')->table('t_embarque_importacion', function(Blueprint $table) {

            $table->foreign('emim_importacion')->references('id')->on('t_importacion');

            $table->foreign('emim_tipo_carga')->references('id')->on('t_tipo_carga');

            $table->foreign('emim_linea_maritima')->references('id')->on('t_linea_maritima');

         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('importacionesV2')->dropIfExists('t_embarque_importacion');
    }
}
