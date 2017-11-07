<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CommentsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$comments = [
			'DJ',
			'Secu',
			'Divers',
		];


        foreach ($comments as $comment) {
        	DB::table('comment_types')->insert([
	            'name' => $comment,
	        ]);
        };
    }
}
