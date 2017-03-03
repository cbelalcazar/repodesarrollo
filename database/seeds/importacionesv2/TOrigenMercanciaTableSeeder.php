<?php

use Illuminate\Database\Seeder;

class TOrigenMercanciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         //Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_origen_mercancia')->insert([
    		'id' => 1,
    		'ormer_nombre' => "CHINA",
    		'ormer_requ_cert_origen' => 0,
    		]);
    	//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_origen_mercancia')->insert([
    		'id' => 2,
    		'ormer_nombre' => "BRASIL",
    		'ormer_requ_cert_origen' => 0,
    		]);
    	//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_origen_mercancia')->insert([
    		'id' => 3,
    		'ormer_nombre' => "INGLATERRA",
    		'ormer_requ_cert_origen' => 0,
    		]);
    	//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_origen_mercancia')->insert([
    		'id' => 4,
    		'ormer_nombre' => "ISRAEL",
    		'ormer_requ_cert_origen' => 0,
    		]);
    }
}
