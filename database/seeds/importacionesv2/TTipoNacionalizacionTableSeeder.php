<?php

use Illuminate\Database\Seeder;

class TTipoNacionalizacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::connection('importacionesV2')->table('t_tipo_nacionalizacion')->insert([
    		'id' => 1,
    		'tnac_descripcion' => "AUTOMATICA",
    		]);
    	DB::connection('importacionesV2')->table('t_tipo_nacionalizacion')->insert([
    		'id' => 2,
    		'tnac_descripcion' => "MANUAL",
    		]);
    }
}
