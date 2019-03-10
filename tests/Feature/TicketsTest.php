<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->user = factory(User::class)->create();
    }

    public function testDisplayTicketsForLoggedUser()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->get('/tickets');

        $response->assertStatus(200);
        $response->assertSeeText($ticket->title);
    }

    public function testCreateTicket()
    {
        $data = [
            'title' => 'title',
            'description' => 'description',
            'image_url' => 'image'
        ];

        $response = $this->actingAs($this->user)->post('/create/ticket', $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tickets', $data);
    }
    public function testScreenshotUploadWithCreateTicket()
    {
        $this->markTestSkipped();
        $data = [
            'title' => 'title',
            'description' => 'description',
            'image_url' => 'some image from internet.jpg'
        ];

        $response = $this->actingAs($this->user)->post(route('ticket.create'), $data);

        $response->assertStatus(302);
        $data['image_url'] = 'image on disc.jpg';
        $this->assertDatabaseHas('tickets', $data);
        $this->assertTrue(Storage::exists('public/'.$data['image_url']));
    }

    public function testUpdateTicket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $data = ['title' => 'new title', 'description' => 'new description'];

        $response = $this->actingAs($this->user)->patch(route('ticket.edit', ['id' => $ticket->id]), $data);

        $response->assertStatus(302);
        $data['id'] = $ticket->id;
        $this->assertDatabaseHas('tickets', $data);
    }

    public function testDeleteTicket()
    {
        $ticket = factory(Ticket::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)->delete(route('ticket.delete', ['id' => $ticket->id]));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
