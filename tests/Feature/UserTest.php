<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */



    public function testUserCanLogin()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/home');
    }


    public function testUserCanSeeTickets()
    {
        $this->markTestSkipped('must be revisited.');
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');

        $response = $this->get("/tickets");

        $response->assertStatus(200);
    }
}
