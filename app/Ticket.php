<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'title', 'description'];

    //

    public function saveTicket($data)
    {
        $this->user_id = $data['user_id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->original_image_url = $data['original_image_url'];
        $this->save();
        return 1;
    }

    public function updateTicket($data)
    {
        $ticket = $this->find($data['id']);
        $ticket->user_id = $data['user_id'];
        $ticket->title = $data['title'];
        $ticket->description = $data['description'];
        $ticket->original_image_url = $data['original_image_url'];
        $ticket->save();
        return 1;
    }
}
