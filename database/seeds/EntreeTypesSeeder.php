<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EntreeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['pieces', 1, 'float'],
            ['billet5', 5, 'integer'],
            ['billet10', 10, 'integer'],
            ['billet20', 20, 'integer'],
            ['billet50', 50, 'integer'],
            ['billet100', 100, 'integer'],
            ['billet200', 200, 'integer'],
        ];


        foreach ($types as $type) {
            DB::table('entree_types')->insert([
                'quoi' => $type[0],
                'facteur' => $type[1],
                'expecting' => $type[2],
            ]);
        }
    }
}
