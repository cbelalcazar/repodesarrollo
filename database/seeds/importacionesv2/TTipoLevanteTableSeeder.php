<?php

use Illuminate\Database\Seeder;

class TTipoLevanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection('importacionesV2')->table('t_tipo_levante')->insert([
    		'id' => 1,
    		'tlev_nombre' => "Automatico",
    		]);
         DB::connection('importacionesV2')->table('t_tipo_levante')->insert([
    		'id' => 2,
    		'tlev_nombre' => "Documental",
    		]);
          DB::connection('importacionesV2')->table('t_tipo_levante')->insert([
    		'id' => 3,
    		'tlev_nombre' => "Fisico",
    		]);
    }
}
