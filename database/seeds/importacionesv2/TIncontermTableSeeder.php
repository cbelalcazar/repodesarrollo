<?php

use Illuminate\Database\Seeder;

class TIncontermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 1,
    		'inco_descripcion' => "CFR",
    		]);

        //Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 2,
    		'inco_descripcion' => "CIF",
    		]);

 		//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 3,
    		'inco_descripcion' => "CIP",
    		]);
 		//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 4,
    		'inco_descripcion' => "CPT",
    		]);
		 //Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 5,
    		'inco_descripcion' => "DAP",
    		]);
 		//Estados creados para el proceso de importacionesv2
 	   	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 6,
    		'inco_descripcion' => "DAT",
    		]);
 		//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 7,
    		'inco_descripcion' => "DDP",
    		]);
		 //Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 8,
    		'inco_descripcion' => "EXW",
    		]);
 		//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 9,
    		'inco_descripcion' => "FAS",
    		]);
 		//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 10,
    		'inco_descripcion' => "FCA",
    		]);
    	//Estados creados para el proceso de importacionesv2
    	DB::connection('importacionesV2')->table('t_iconterm')->insert([
    		'id' => 11,
    		'inco_descripcion' => "FOB",
    		]);


    }
}
