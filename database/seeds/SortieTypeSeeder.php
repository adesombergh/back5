<?php

use Illuminate\Database\Seeder;

class SortieTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Avance' => 'avances',
            'Sécu' => 'secu',
            'Dj' => 'none',
            'Courses' => 'text',
            'Autre' => 'text',
        ];


        foreach ($types as $name => $options) {
            DB::table('sortie_types')->insert([
                'name' => $name,
                'options' => $options,
            ]);
        }
    }
}
