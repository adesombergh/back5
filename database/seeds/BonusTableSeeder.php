<?php

use Illuminate\Database\Seeder;

class BonusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$types_service = array(
			'joursemaine', 'soirsemaine','jourweekend','soirweekend','brunch'
    	);
    	$min = 2;
    	$max = 5;
        for ($actif=0; $actif <= 1; $actif++) { 
            foreach ($types_service as $type) {
                for ($nb=$min; $nb <= $max; $nb++) { 
                    
                    $row = array(
                        'taille_equipe' => $nb,
                        'seuil_initial' => $nb*1000+(200*$actif),
                        'bonus_initial' => 2,
                        'paliers_suivants' => 250,
                        'supplement' => 0.25,
                        'concerne' => 'bar,cuisine',
                        'actif' => $actif,
                        'type_de_service' => $type
                    );
                    
                    $schema = factory(App\Bonus::class)->create($row);

                }
            }
        }


    }
}
