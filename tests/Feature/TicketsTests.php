<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TicketsTests extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDisplayTicketsForLoggedUser()
    {
        $user = factory(User::class)->create();
        $ticket = factory(Ticket::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/tickets');

        $response->assertStatus(200);
        $response->assertSeeText($ticket->title);
        $response->assertViewIs('user.index');
    }

    public function testCreateTicket()
    {
        $data = ['title' => 'title', 'description' => 'description'];

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/create/ticket', $data);


        $response->assertStatus(302);
        $this->assertDatabaseHas('tickets', $data);
    }


}
