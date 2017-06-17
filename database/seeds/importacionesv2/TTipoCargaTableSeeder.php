<?php

use Illuminate\Database\Seeder;

class TTipoCargaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::connection('importacionesV2')->table('t_tipo_carga')->insert([
    		'id' => 1,
    		'tcar_descripcion' => "AEREO",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_carga')->insert([
    		'id' => 2,
    		'tcar_descripcion' => "LCL",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_carga')->insert([
    		'id' => 3,
    		'tcar_descripcion' => "FCL",
    		]);
    }
}
