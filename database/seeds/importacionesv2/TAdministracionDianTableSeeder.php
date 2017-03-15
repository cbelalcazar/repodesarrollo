<?php

use Illuminate\Database\Seeder;

class TAdministracionDianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::connection('importacionesV2')->table('t_administracion_dian')->insert([
            'id' => 1,
            'descripcion' => "BUENAVENTURA",
        ]);

        DB::connection('importacionesV2')->table('t_administracion_dian')->insert([
            'id' => 2,
            'descripcion' => "CALI",
        ]);

        DB::connection('importacionesV2')->table('t_administracion_dian')->insert([
            'id' => 3,
            'descripcion' => "CARTAGENA",
        ]);

        DB::connection('importacionesV2')->table('t_administracion_dian')->insert([
            'id' => 4,
            'descripcion' => "BOGOTA",
        ]);
    }
}
