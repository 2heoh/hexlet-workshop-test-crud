<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TicketsTests extends TestCase
{

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->user = factory(User::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDisplayTicketsForLoggedUser()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->get('/tickets');

        $response->assertStatus(200);
        $response->assertSeeText($ticket->title);
        $response->assertViewIs('user.index');
    }

    public function testCreateTicket()
    {
        $data = ['title' => 'title', 'description' => 'description'];

        $response = $this->actingAs($this->user)->post('/create/ticket', $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tickets', $data);
    }

    public function testUpdateTicket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $data = ['title' => 'new title', 'description' => 'new description'];

        $response = $this->actingAs($this->user)->patch('/edit/ticket/' . $ticket->id, $data);

        $response->assertStatus(302);
        $data['id'] = $ticket->id;
        $this->assertDatabaseHas('tickets', $data);
    }

    public function testDeleteTicket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->delete('/delete/ticket/' . $ticket->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
