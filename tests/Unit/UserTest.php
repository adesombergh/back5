<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetInCreateUserFormOnlyIfLogged()
    {
    	$response = $this->get('/register');
        $this->assertEquals(302,$response->getStatusCode());

    	$someone = factory(\App\User::class)->create();


    	$response = $this->actingAs($someone)->get('/register');
        $this->assertEquals(200,$response->getStatusCode());
    }


    public function setUp() {
        parent::setUp();
        \Illuminate\Support\Facades\Artisan::call('migrate:refresh');
    }


}
