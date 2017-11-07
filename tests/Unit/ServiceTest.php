<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use \App\Role;
use \App\Service;

class ServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllServicesLogged()
    {
        $boss = Role::where('name','boss')->first()->users()->get()->random();

        $response = $this->actingAs($boss)->get('/service');

        $json = json_decode($response->getContent());

        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertEquals( 25, count($json) );
    }


    public function testGetAllServicesNotLogged()
    {
        $nb_services = 25;
        $now = new Carbon;
        $boss = Role::where('name','boss')->first()->users()->get()->random();

        for ($i=0; $i < $nb_services; $i++) { 
            $date = $now->format('Y-m-d');
            $heure = $now->format('a')=='am' ? '08:00:00' : '20:00:00';

            factory(Service::class)->create([
                'qui' => $boss->id,
                'quand' => ($date.' '.$heure)
            ]);

            $now->subHours(12);
        }

        $response = $this->get('/service');

        $json = json_decode($response->getContent());

        $this->assertEquals( 302, $response->getStatusCode() );
        $this->assertEquals( 0, count($json) );
    }


    public function testStoreServiceLoggedAndThenTryToStoreExistingService()
    {
        $boss = Role::where('name','boss')->first()->users()->get()->random();
        $now = new Carbon;
        $now->subHours(12);

        $data = [
            'quand' => $now->format('Y-m-d').' '.($now->format('a')=='am' ? '08:00:00' : '20:00:00')
        ];

        $oldcount = Service::count();

        $response = $this->actingAs($boss)->post('/service',$data);

        $this->assertEquals( 200, $response->getStatusCode());
        $this->assertDatabaseHas('services', [
            'quand' => $now->format('Y-m-d').' '.($now->format('a')=='am' ? '08:00:00' : '20:00:00'),
            'qui' => $boss->id,
        ]);
        $this->assertEquals( Service::count(), $oldcount+1 );



        $oldcount = Service::count();
        $response = $this->actingAs($boss)->post('/service',$data);
        $this->assertEquals( 302, $response->getStatusCode() );
        $this->assertEquals( Service::count(), $oldcount );
    }



    public function testStoreServiceLoggedButNotAuthorized()
    {
        $role = Role::where('name', 'bar')->first();
        $not_boss = new \App\User();
        $not_boss->name = 'Employee Name';
        $not_boss->username = 'fuckyea';
        $not_boss->password = bcrypt('secret');
        $not_boss->save();
        $not_boss->roles()->attach($role);

        $now = new Carbon;
        $now->subHours(12);

        $data = [
            'quand' => $now->format('Y-m-d').' '.($now->format('a')=='am' ? '08:00:00' : '20:00:00')
        ];

        $oldcount = Service::count();

        $response = $this->actingAs($not_boss)->post('/service',$data);

        $this->assertEquals( 401, $response->getStatusCode());
        $this->assertEquals( Service::count(), $oldcount );
    }


    public function testStoreServiceNotLogged()
    {
        $now = new Carbon;
        $now->subHours(12);
        $data = [
            'quand' => $now->format('Y-m-d').' '.($now->format('a')=='am' ? '08:00:00' : '20:00:00')
        ];

        $oldcount = Service::count();

        $response = $this->post('/service',$data);

        $this->assertEquals( 302, $response->getStatusCode());
        $this->assertEquals( Service::count(), $oldcount );
    }


    public function testDeleteLastService()
    {
        $oldcount = Service::count();
        $boss = Role::where('name','boss')->first()->users()->get()->random();
        $last = Service::all()->sortBy('quand')->last();

        $response = $this->actingAs($boss)->call('DELETE', '/service/'.$last->id,['_token' => csrf_token()] );

        $this->assertEquals( 200, $response->getStatusCode(), $response->getContent());

        $this->assertDatabaseMissing('services', ['id' => $last->id]);
        $this->assertEquals( Service::count(), $oldcount-1 );

    }


    public function setUp() {
        parent::setUp();
        \Illuminate\Support\Facades\Artisan::call('migrate:refresh',['--seed'=>true]);
    }



}
