<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class TicketsTests extends TestCase
{

    public function setUp() : void
    {
        parent::setUp();
        \Artisan::call('migrate');
        \Artisan::call('db:seed');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTickets()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/tickets');

        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }
}
