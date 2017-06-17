<?php

use Illuminate\Database\Seeder;

class TMetricaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 1,
    		'met_nombre' => "TIEMPO DE NACIONALIZACION CON PREINSPECCION",
    		'met_numero_dias' => 0,
    		]);

    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 2,
    		'met_nombre' => "TIEMPO DE NACIONALIZACION SIN PREINSPECCION",
    		'met_numero_dias' => 0,
    		]);

		DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 3,
    		'met_nombre' => "TIEMPO DE LLEGADA A BELLEZA CON CONTROL POSTERIOR",
    		'met_numero_dias' => 0,
    		]);
    	
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 4,
    		'met_nombre' => "TIEMPO DE LLEGADA A BELLEZA SIN CONTROL POSTERIOR",
    		'met_numero_dias' => 0,
    		]);

    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 5,
    		'met_nombre' => "ENVIO DOCUMENTOS AGENCIA DE ADUANAS",
    		'met_numero_dias' => 0,
    		]);

    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 6,
    		'met_nombre' => "ENVIO LISTA DE EMPAQUE",
    		'met_numero_dias' => 0,
    		]);

    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 7,
    		'met_nombre' => "RECEPCION LISTA DE EMPAQUE Y CIEGO",
    		'met_numero_dias' => 0,
    		]);
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 8,
    		'met_nombre' => "ENVIO DE LIQUIDACION Y COSTEO",
    		'met_numero_dias' => 0,
    		]);
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 9,
    		'met_nombre' => "ENTRADA AL SISTEMA",
    		'met_numero_dias' => 0,
    		]);
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 10,
    		'met_nombre' => "TIEMPO DE LEGALIZACION",
    		'met_numero_dias' => 0,
    		]);
    	DB::connection('importacionesV2')->table('t_metrica')->insert([
    		'id' => 11,
    		'met_nombre' => "TIEMPO DE FECHA DE EMBARQUE",
    		'met_numero_dias' => 0,
    		]);    	
    }
}
