<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = [
    		'admin',
			'boss',
			'respo',
			'gerant',
			'bar',
			'cuisine',
			'secu',
			'salaire',
			'horaire',
			'fixe',
			'prestation',
			'banque',
			'hasBonus'
		];


        foreach ($roles as $role) {
        	DB::table('roles')->insert([
	            'name' => $role,
	            'caps' => ''
	        ]);
        }
    }
}
