<?php

use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$options = [
			'type_bonus' => 'h',
		];


        foreach ($options as $key => $value) {
        	DB::table('options')->insert([
	            'key' => $key,
	            'value' => $value
	        ]);
        }
    }
}
