<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->admin = Role::where('name', 'admin')->first();

        DB::table('users')->insert([
            'name' => 'ADesombergh',
            'username' => 'ADesombergh',
            'password' => bcrypt('ADesombergh'),
        ]);
        User::where('name','ADesombergh')->first()->roles()->save($this->admin);
        DB::table('users')->insert([
            'name' => 'Deba',
            'username' => 'deba',
            'password' => bcrypt('deba'),
        ]);
        User::where('name','Deba')->first()->roles()->save($this->admin);
        
        $this->boss = Role::where('name', 'boss')->first();
        factory(User::class, 2)->create()->each( function($u){
            $u->roles()->save($this->boss);
        });

        $this->horaire = Role::where('name', 'horaire')->first();
        $this->secu = Role::where('name', 'secu')->first();
        factory(User::class, 2)->create()->each( function($u){
            $u->roles()->save($this->secu);
            $u->roles()->save($this->horaire);
        });

        $this->fixe = Role::where('name', 'fixe')->first();
        factory(User::class)->create()->each( function($u){
            $u->roles()->save($this->fixe);
        });

        $this->respo = Role::where('name', 'respo')->first();
        $this->bar = Role::where('name', 'bar')->first();
        $this->hasBonus = Role::where('name', 'hasBonus')->first();
        $this->banque = Role::where('name', 'banque')->first();

        factory(User::class, 3)->create()->each( function($u){
            $u->roles()->save($this->respo);
            $u->roles()->save($this->bar);
            $u->roles()->save($this->horaire);
            $u->roles()->save($this->hasBonus);
            $u->roles()->save($this->banque);
        });

        $this->gerant = Role::where('name', 'gerant')->first();
        factory(User::class, 1)->create()->each( function($u){
            $u->roles()->save($this->respo);
            $u->roles()->save($this->bar);
            $u->roles()->save($this->horaire);
            $u->roles()->save($this->hasBonus);
            $u->roles()->save($this->banque);
            $u->roles()->save($this->gerant);
        });

        factory(User::class, 2)->create()->each( function($u){
            $u->roles()->save($this->bar);
            $u->roles()->save($this->horaire);
            $u->roles()->save($this->hasBonus);
            $u->roles()->save($this->banque);
        });

        $this->cuisine = Role::where('name', 'cuisine')->first();
        factory(User::class, 5)->create()->each( function($u){
            $u->roles()->save($this->cuisine);
            $u->roles()->save($this->horaire);
            $u->roles()->save($this->hasBonus);
            $u->roles()->save($this->banque);
        });

    }
}
