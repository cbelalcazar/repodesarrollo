<?php

use Illuminate\Database\Seeder;

class TestadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creado por Carlos Belalcazar
     * Analista desarrollador de software Belleza Express
     * 22/02/2017
     *
     * @return void
     */
    public function run()
    {
        //Estados creados para el proceso de importacionesv2
         DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 1,
            'est_nombre' => "ORIGEN",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 2,
            'est_nombre' => "TRANSITO",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 3,
            'est_nombre' => "PUERTO",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 4,
            'est_nombre' => "BODEGA",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 5,
            'est_nombre' => "LIQUIDADA",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 6,
            'est_nombre' => "CERRADA",
        ]);

        DB::connection('importacionesV2')->table('t_estados')->insert([
            'id' => 7,
            'est_nombre' => "ANULADA",
        ]);
    }
}
