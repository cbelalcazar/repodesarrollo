<?php

use Illuminate\Database\Seeder;

class TTipoContenedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	DB::connection('importacionesV2')->table('t_tipo_contenedor')->insert([
    		'id' => 1,
    		'tcont_descripcion' => "20 STD",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_contenedor')->insert([
    		'id' => 2,
    		'tcont_descripcion' => "40 STD",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_contenedor')->insert([
    		'id' => 3,
    		'tcont_descripcion' => "40 HC",
    		]);

    	DB::connection('importacionesV2')->table('t_tipo_contenedor')->insert([
    		'id' => 4,
    		'tcont_descripcion' => "40 NOR",
    		]);
    }
}
