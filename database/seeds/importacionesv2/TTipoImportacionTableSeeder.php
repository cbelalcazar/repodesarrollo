<?php

use Illuminate\Database\Seeder;

class TTipoImportacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::connection('importacionesV2')->table('t_tipo_importacion')->insert([
    		'id' => 1,
    		'timp_nombre' => "Descargue directo / Entrega directa",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_importacion')->insert([
    		'id' => 2,
    		'timp_nombre' => "Ordinaria",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_importacion')->insert([
    		'id' => 3,
    		'timp_nombre' => "Transito aduanero / Zona franca",
    		]);
    }
}
