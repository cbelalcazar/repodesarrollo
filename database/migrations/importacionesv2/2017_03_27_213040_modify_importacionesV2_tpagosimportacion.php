<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyImportacionesV2Tpagosimportacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('importacionesV2')->table('t_pago_importacion', function (Blueprint $table) {
            $table->float('pag_valor_anticipo')->nullable()->change();
            $table->float('pag_valor_saldo')->nullable()->change();
            $table->float('pag_valor_comision')->nullable()->change();
            $table->float('pag_valor_total')->nullable()->change();
            $table->float('pag_valor_fob')->nullable()->change();
            $table->date('pag_fecha_anticipo')->nullable()->change();
            $table->date('pag_fecha_saldo')->nullable()->change();
            $table->date('pag_fecha_factura')->nullable()->change();

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
        Schema::connection('importacionesV2')->table('t_pago_importacion', function (Blueprint $table) {
            $table->float('pag_valor_anticipo')->nullable(false)->change();
            $table->float('pag_valor_saldo')->nullable(false)->change();
            $table->float('pag_valor_comision')->nullable(false)->change();
            $table->float('pag_valor_total')->nullable(false)->change();
            $table->float('pag_valor_fob')->nullable(false)->change();
            $table->date('pag_fecha_anticipo')->nullable(false)->change();
            $table->date('pag_fecha_saldo')->nullable(false)->change();
            $table->date('pag_fecha_factura')->nullable(false)->change();

        });
    }
}
