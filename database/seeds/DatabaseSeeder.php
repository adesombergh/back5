<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Artisan::call('migrate:refresh');
        
        // $this->call(BonusTableSeeder::class);
        
        // $this->call(OptionTableSeeder::class);

        $this->call(RoleTableSeeder::class);

        //$this->call(SortieTypeSeeder::class);

        //$this->call(UserTableSeeder::class);

        //$this->call(CommentsTypeTableSeeder::class);

        //$this->call(ServiceTableSeeder::class);
    }

}
